<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Disposition;
use App\Models\IncomingLetter;
use App\Models\User;
use App\Models\DispositionRecipient;

use App\Http\Requests\StoreDispositionRequest;
use App\Http\Requests\UpdateDispositionRequest;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class DispositionController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [

            new Middleware(
                'permission:disposition.view',
                only: [
                    'index',
                    'show',
                ]
            ),

            new Middleware(
                'permission:disposition.create',
                only: [
                    'create',
                    'store',
                ]
            ),

            new Middleware(
                'permission:disposition.edit',
                only: [
                    'edit',
                    'update',
                ]
            ),

            new Middleware(
                'permission:disposition.process',
                only: [
                    'process',
                ]
            ),

            new Middleware(
                'permission:disposition.complete',
                only: [
                    'complete',
                ]
            ),

            new Middleware(
                'permission:disposition.delete',
                only: [
                    'destroy',
                ]
            ),

        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $user = Auth::user();

        $dispositions = Disposition::with([
            'incomingLetter',
            'recipients.user.position',
            'createdBy.position',
        ])

            /*
            * Batasi data berdasarkan role.
            *
            * Administrator dan Admin Persuratan:
            * dapat melihat semua disposisi.
            *
            * Rektor dan Staf:
            * hanya melihat disposisi yang memiliki
            * dirinya sebagai penerima.
            */
            ->when(
                !$user->hasAnyRole([
                    'Administrator',
                    'Admin Persuratan',
                ]),
                function ($query) use ($user) {

                    $query->whereHas(
                        'recipients',
                        function ($recipientQuery) use ($user) {

                            $recipientQuery->where(
                                'user_id',
                                $user->id
                            );

                        }
                    );

                }
            )

            /*
            * Pencarian.
            */
            ->when($search, function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->whereHas(
                        'incomingLetter',
                        function ($letterQuery) use ($search) {

                            $letterQuery
                                ->where(
                                    'agenda_number',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'letter_number',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'sender',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'regarding',
                                    'like',
                                    "%{$search}%"
                                );

                        }
                    )

                    ->orWhereHas(
                        'recipients.user',
                        function ($userQuery) use ($search) {

                            $userQuery->where(
                                'full_name',
                                'like',
                                "%{$search}%"
                            );

                        }
                    )

                    ->orWhere(
                        'instruction',
                        'like',
                        "%{$search}%"
                    );

                });

            })

            ->latest()

            ->paginate(10)

            ->withQueryString();

        return view(
            'dispositions.index',
            compact('dispositions')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $selectedIncomingLetterId = $request->integer(
            'incoming_letter_id'
        );

        $selectedIncomingLetter = IncomingLetter::find(
            $selectedIncomingLetterId
        );

        if (
            !$selectedIncomingLetter ||
            $selectedIncomingLetter->status !== 'Baru'
        ) {
            return redirect()
                ->route('incoming-letters.index')
                ->with(
                    'error',
                    'Surat masuk tersebut tidak dapat dibuatkan disposisi.'
                );
        }

        $incomingLetters = IncomingLetter::where(
            'status',
            'Baru'
        )
            ->orderByDesc('received_date')
            ->get();

        $users = User::with('position')
            ->where('is_active', true)
            ->orderBy('full_name')
            ->get();

        return view(
            'dispositions.create',
            compact(
                'incomingLetters',
                'users',
                'selectedIncomingLetterId'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDispositionRequest $request)
    {
        $data = $request->validated();

        $recipientIds = $data['recipient_ids'];

        unset($data['recipient_ids']);

        $data['created_by'] = Auth::id();

        /*
         * Pastikan satu surat masuk hanya memiliki
         * satu disposisi utama.
         */
        if (
            Disposition::where(
                'incoming_letter_id',
                $data['incoming_letter_id']
            )->exists()
        ) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Surat masuk ini sudah memiliki disposisi.'
                );
        }

        /*
         * Status awal disposisi utama selalu Baru.
         */
        $data['status'] = 'Baru';

        $disposition = Disposition::create($data);

        /*
         * Buat record penerima disposisi.
         */
        foreach ($recipientIds as $userId) {

            $disposition->recipients()->create([
                'user_id' => $userId,
                'status' => 'Baru',
            ]);

        }

        /*
         * Setelah disposisi dibuat,
         * status surat masuk menjadi Didisposisi.
         */
        $disposition->incomingLetter->update([
            'status' => 'Didisposisi',
        ]);

        return redirect()
            ->route('dispositions.show', $disposition)
            ->with(
                'success',
                'Disposisi berhasil dibuat untuk '
                . count($recipientIds)
                . ' penerima.'
            );
    }

    /**
     * Display the specified resource.
     */
    public function show(Disposition $disposition)
    {
        $user = Auth::user();

        /*
        * Administrator dan Admin Persuratan
        * dapat melihat semua disposisi.
        */
        $isFullAccess = $user->hasAnyRole([
            'Administrator',
            'Admin Persuratan',
        ]);

        /*
        * Rektor dan Staf hanya dapat melihat
        * disposisi yang ditujukan kepada dirinya.
        */
        if (!$isFullAccess) {

            $isRecipient = $disposition
                ->recipients()
                ->where('user_id', $user->id)
                ->exists();

            if (!$isRecipient) {

                abort(
                    403,
                    'Anda tidak memiliki akses untuk melihat disposisi ini.'
                );
            }
        }

        $disposition->load([
            'incomingLetter',
            'recipients.user.position',
            'createdBy.position',
        ]);

        return view(
            'dispositions.show',
            compact('disposition')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Disposition $disposition)
    {
        $user = Auth::user();

        /*
        * Pastikan hanya Administrator dan Admin Persuratan
        * yang dapat mengedit disposisi.
        */
        abort_unless(
            $user->hasAnyRole([
                'Administrator',
                'Admin Persuratan',
            ]),
            403,
            'Anda tidak memiliki akses untuk mengedit disposisi ini.'
        );

        /*
        * Disposisi yang sudah selesai tidak boleh diedit.
        */
        if ($disposition->status === 'Selesai') {
            return redirect()
                ->route('dispositions.show', $disposition)
                ->with(
                    'error',
                    'Disposisi yang sudah selesai tidak dapat diedit.'
                );
        }

        $disposition->load('recipients');

        $incomingLetters = IncomingLetter::where(function ($query) use ($disposition) {

            $query
                ->where('status', 'Baru')
                ->orWhere(
                    'id',
                    $disposition->incoming_letter_id
                );

        })
            ->orderByDesc('received_date')
            ->get();

        $users = User::with('position')
            ->where('is_active', true)
            ->orderBy('full_name')
            ->get();

        $selectedRecipientIds = $disposition
            ->recipients
            ->pluck('user_id')
            ->toArray();

        return view(
            'dispositions.edit',
            compact(
                'disposition',
                'incomingLetters',
                'users',
                'selectedRecipientIds'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateDispositionRequest $request,
        Disposition $disposition
    ) {
        $data = $request->validated();

        $recipientIds = $data['recipient_ids'];

        unset($data['recipient_ids']);

        // Status tidak boleh diubah melalui form edit.
        unset($data['status']);

        // Update data utama disposisi.
        $disposition->update($data);

        // Sinkronisasi penerima disposisi.
        //
        // Semua penerima lama dihapus,
        // kemudian dibuat ulang berdasarkan pilihan terbaru.
        $disposition->recipients()->delete();

        foreach ($recipientIds as $userId) {

            $disposition->recipients()->create([
                'user_id' => $userId,
                'status' => 'Baru',
            ]);

        }

        // Sinkronkan kembali status disposisi utama.
        $this->syncDispositionStatus($disposition);

        return redirect()
            ->route('dispositions.show', $disposition)
            ->with(
                'success',
                'Disposisi berhasil diperbarui.'
            );
    }

    /**
     * Update status penerima disposisi menjadi Diproses.
     */
    public function process(DispositionRecipient $recipient)
    {
        $user = Auth::user();

        /*
        * Pastikan penerima disposisi adalah
        * user yang sedang login.
        *
        * Ini mencegah Rektor memproses
        * disposisi milik Staff dan sebaliknya.
        */
        if ($recipient->user_id !== $user->id) {

            abort(
                403,
                'Anda tidak memiliki akses untuk memproses disposisi ini.'
            );
        }

        /*
        * Disposisi penerima hanya dapat diproses
        * jika status masih Baru.
        */
        if ($recipient->status !== 'Baru') {

            return redirect()
                ->route(
                    'dispositions.show',
                    $recipient->disposition_id
                )
                ->with(
                    'error',
                    'Disposisi penerima hanya dapat diproses jika status masih Baru.'
                );
        }

        $recipient->update([
            'status' => 'Diproses',
            'processed_at' => now(),
        ]);

        $this->syncDispositionStatus(
            $recipient->disposition
        );

        return redirect()
            ->route(
                'dispositions.show',
                $recipient->disposition_id
            )
            ->with(
                'success',
                'Disposisi berhasil mulai diproses.'
            );
    }

    /**
     * Update status penerima disposisi menjadi Selesai.
     */
    public function complete(DispositionRecipient $recipient)
    {
        $user = Auth::user();

        /*
        * Pastikan penerima disposisi adalah
        * user yang sedang login.
        *
        * Ini mencegah Rektor menyelesaikan
        * disposisi milik Staff dan sebaliknya.
        */
        if ($recipient->user_id !== $user->id) {

            abort(
                403,
                'Anda tidak memiliki akses untuk menyelesaikan disposisi ini.'
            );
        }

        /*
        * Disposisi penerima hanya dapat diselesaikan
        * jika status sedang Diproses.
        */
        if ($recipient->status !== 'Diproses') {

            return redirect()
                ->route(
                    'dispositions.show',
                    $recipient->disposition_id
                )
                ->with(
                    'error',
                    'Disposisi penerima hanya dapat diselesaikan jika status sedang Diproses.'
                );
        }

        $recipient->update([
            'status' => 'Selesai',
            'completed_at' => now(),
        ]);

        $this->syncDispositionStatus(
            $recipient->disposition
        );

        return redirect()
            ->route(
                'dispositions.show',
                $recipient->disposition_id
            )
            ->with(
                'success',
                'Disposisi berhasil diselesaikan.'
            );
    }

    /**
     * Sinkronisasi status disposisi utama
     * berdasarkan status seluruh penerima.
     */
    private function syncDispositionStatus(
        Disposition $disposition
    ): void {
        $statuses = $disposition
            ->recipients()
            ->pluck('status');

        /*
         * Tidak ada penerima.
         */
        if ($statuses->isEmpty()) {
            return;
        }

        /*
         * Jika seluruh penerima sudah selesai,
         * maka disposisi utama juga selesai.
         */
        if (
            $statuses->every(
                fn ($status) => $status === 'Selesai'
            )
        ) {

            $disposition->update([
                'status' => 'Selesai',
            ]);

            /*
             * Jika semua penerima selesai,
             * surat masuk juga selesai.
             */
            $disposition->incomingLetter?->update([
                'status' => 'Selesai',
            ]);

            return;
        }

        /*
         * Jika minimal satu penerima sedang diproses,
         * disposisi utama menjadi Diproses.
         */
        if ($statuses->contains('Diproses')) {

            $disposition->update([
                'status' => 'Diproses',
            ]);

            return;
        }

        /*
         * Jika tidak ada yang Diproses dan
         * belum semuanya selesai, berarti masih Baru.
         */
        $disposition->update([
            'status' => 'Baru',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Disposition $disposition)
    {
        $user = Auth::user();

        /*
        * Hanya Administrator dan Admin Persuratan
        * yang boleh menghapus disposisi.
        */
        abort_unless(
            $user->hasAnyRole([
                'Administrator',
                'Admin Persuratan',
            ]),
            403,
            'Anda tidak memiliki akses untuk menghapus disposisi ini.'
        );

        /*
        * Disposisi yang sudah mulai diproses
        * tidak boleh dihapus.
        */
        if ($disposition->status !== 'Baru') {
            return redirect()
                ->route('dispositions.show', $disposition)
                ->with(
                    'error',
                    'Disposisi yang sudah diproses tidak dapat dihapus.'
                );
        }

        /*
        * Simpan ID surat masuk sebelum disposisi dihapus.
        */
        $incomingLetter = $disposition->incomingLetter;

        /*
        * Hapus disposisi.
        *
        * Recipient akan ikut terhapus jika
        * foreign key database menggunakan cascadeOnDelete().
        */
        $disposition->delete();

        /*
        * Kembalikan status surat masuk menjadi Baru.
        */
        $incomingLetter?->update([
            'status' => 'Baru',
        ]);

        return redirect()
            ->route('dispositions.index')
            ->with(
                'success',
                'Disposisi berhasil dihapus.'
            );
    }
}