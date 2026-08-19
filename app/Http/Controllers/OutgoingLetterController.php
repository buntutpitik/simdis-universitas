<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOutgoingLetterRequest;
use App\Http\Requests\UpdateOutgoingLetterRequest;
use App\Models\OutgoingLetter;
use App\Services\FileUploadService;
use App\Services\NumberGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class OutgoingLetterController extends Controller implements HasMiddleware
{
    
    public static function middleware(): array
    {
        return [

            new Middleware(
                'permission:outgoing.view',
                only: ['index', 'show', 'file']
            ),

            new Middleware(
                'permission:outgoing.create',
                only: ['create', 'store']
            ),

            new Middleware(
                'permission:outgoing.edit',
                only: ['edit', 'update']
            ),

            new Middleware(
                'permission:outgoing.delete',
                only: ['destroy']
            ),

        ];
    }

    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $letters = OutgoingLetter::with('createdBy.position')

            ->when($search, function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->where('letter_number', 'like', "%{$search}%")
                        ->orWhere('recipient', 'like', "%{$search}%")
                        ->orWhere('regarding', 'like', "%{$search}%")
                        ->orWhereHas('createdBy', function ($userQuery) use ($search) {

                            $userQuery->where('full_name', 'like', "%{$search}%");

                        });

                });

            })

            ->latest('letter_date')

            ->paginate(10)

            ->withQueryString();

        return view(
            'outgoing_letters.index',
            compact('letters')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('outgoing_letters.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOutgoingLetterRequest $request)
    {
        $data = $request->validated();

        $data['agenda_number'] = NumberGenerator::generate(
            NumberGenerator::OUTGOING,
            'outgoing_letters'
        );

        $data['file'] = FileUploadService::upload(
            $request->file('file'),
            'outgoing_letters'
        );

        $data['created_by'] = Auth::id();

        OutgoingLetter::create($data);

        return redirect()
            ->route('outgoing-letters.index')
            ->with('success', 'Surat keluar berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(OutgoingLetter $outgoingLetter)
    {
        $outgoingLetter->load([
            'createdBy.position',
        ]);

        return view(
            'outgoing_letters.show',
            compact('outgoingLetter')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OutgoingLetter $outgoingLetter)
    {
        return view(
            'outgoing_letters.edit',
            compact('outgoingLetter')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateOutgoingLetterRequest $request,
        OutgoingLetter $outgoingLetter
    ) {
        $data = $request->validated();

        if ($request->hasFile('file')) {

            $data['file'] = FileUploadService::replace(
                $request->file('file'),
                $outgoingLetter->file,
                'outgoing_letters'
            );

        } else {

            $data['file'] = $outgoingLetter->file;

        }

        $outgoingLetter->update($data);

        return redirect()
            ->route('outgoing-letters.index')
            ->with('success', 'Surat keluar berhasil diperbarui.');
    }

    /**
     * Display or download the PDF securely.
     */
    public function file(OutgoingLetter $outgoingLetter)
    {
        abort_unless($outgoingLetter->file, 404);

        abort_unless(
            Storage::disk('local')->exists($outgoingLetter->file),
            404
        );

        return Storage::disk('local')->response(
            $outgoingLetter->file
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OutgoingLetter $outgoingLetter)
    {
        FileUploadService::delete(
            $outgoingLetter->file
        );

        $outgoingLetter->delete();

        return redirect()
            ->route('outgoing-letters.index')
            ->with('success', 'Surat keluar berhasil dihapus.');
    }
}