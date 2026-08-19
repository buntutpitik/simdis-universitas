<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\IncomingLetter;
use App\Http\Requests\StoreIncomingLetterRequest;
use App\Http\Requests\UpdateIncomingLetterRequest;

use App\Services\NumberGenerator;
use App\Services\FileUploadService;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class IncomingLetterController extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [

            new Middleware(
                'permission:incoming.view',
                only: ['index', 'show']
            ),

            new Middleware(
                'permission:incoming.create',
                only: ['create', 'store']
            ),

            new Middleware(
                'permission:incoming.edit',
                only: ['edit', 'update']
            ),

            new Middleware(
                'permission:incoming.delete',
                only: ['destroy']
            ),

            new Middleware(
                'permission:incoming.view',
                only: ['index', 'show', 'file']
            ),

        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $letters = IncomingLetter::with('createdBy')
            ->withExists('dispositions')
            ->when($search, function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->where('letter_number', 'like', "%{$search}%")
                        ->orWhere('sender', 'like', "%{$search}%")
                        ->orWhere('regarding', 'like', "%{$search}%")
                        ->orWhereHas('createdBy', function ($userQuery) use ($search) {
                            $userQuery->where('full_name', 'like', "%{$search}%");
                        });

                });

            })
            ->orderByDesc('received_date')
            ->paginate(10)
            ->withQueryString();

        return view(
            'incoming_letters.index',
            compact('letters')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('incoming_letters.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIncomingLetterRequest $request)
    {
        $file = FileUploadService::upload(
            $request->file('file'),
            'incoming_letters'
        );

        IncomingLetter::create([
            
            'agenda_number' => NumberGenerator::generate(
                NumberGenerator::INCOMING,
                'incoming_letters'
            ),

            'letter_number' => $request->letter_number,

            'letter_date' => $request->letter_date,

            'received_date' => $request->received_date,

            'sender' => $request->sender,

            'regarding' => $request->regarding,

            'priority' => $request->priority,

            'attachment' => $request->attachment,

            'description' => $request->description,

            'file' => $file,
          
            'created_by' => Auth::id(),

        ]);

        return redirect()
            ->route('incoming-letters.index')
            ->with('success', 'Surat masuk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(IncomingLetter $incomingLetter)
    {
        $incomingLetter->load([
            'createdBy.position',
        ]);

        return view(
            'incoming_letters.show',
            compact('incomingLetter')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit(IncomingLetter $incomingLetter)
    {
        if ($incomingLetter->status !== 'Baru') {
            return redirect()
                ->route('incoming-letters.show', $incomingLetter)
                ->with(
                    'error',
                    'Surat masuk yang sudah didisposisi atau selesai tidak dapat diedit.'
                );
        }

        return view(
            'incoming_letters.edit',
            compact('incomingLetter')
        );
    }

    
    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateIncomingLetterRequest $request,
        IncomingLetter $incomingLetter
    ) {
        $data = $request->validated();

        // Jika upload file baru
        if ($request->hasFile('file')) {

            $data['file'] = FileUploadService::replace(
                $request->file('file'),
                $incomingLetter->file,
                'incoming_letters'
            );

        } else {

            $data['file'] = $incomingLetter->file;

        }

        $incomingLetter->update($data);

        return redirect()
            ->route('incoming-letters.index')
            ->with('success', 'Surat masuk berhasil diperbarui.');
    }

    /**
     * Display or download the PDF securely.
     */
    public function file(IncomingLetter $incomingLetter)
    {
        abort_unless($incomingLetter->file, 404);

        abort_unless(
            Storage::disk('local')->exists($incomingLetter->file),
            404
        );

        return Storage::disk('local')->response(
            $incomingLetter->file
        );
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IncomingLetter $incomingLetter)
    {
        /*
        * Surat masuk yang sudah memiliki disposisi
        * tidak boleh dihapus.
        */
        if ($incomingLetter->dispositions()->exists()) {
            return redirect()
                ->route('incoming-letters.show', $incomingLetter)
                ->with(
                    'error',
                    'Surat masuk yang sudah memiliki disposisi tidak dapat dihapus.'
                );
        }

        FileUploadService::delete(
            $incomingLetter->file
        );

        $incomingLetter->delete();

        return redirect()
            ->route('incoming-letters.index')
            ->with(
                'success',
                'Surat masuk berhasil dihapus.'
            );
    }
}
