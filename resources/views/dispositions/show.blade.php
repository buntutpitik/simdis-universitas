@extends('adminlte::page')

@section('title', 'Detail Disposisi')

@section('content')

<x-page.header
    title="Detail Disposisi"
    subtitle="Informasi lengkap disposisi surat masuk"
/>

<x-alert />

<x-page.actions>

    <x-page.button
        color="secondary"
        icon="fas fa-arrow-left"
        :href="route('dispositions.index')"
    >
        Kembali
    </x-page.button>

    @if($disposition->incomingLetter)

        <x-page.button
            color="info"
            icon="fas fa-envelope"
            :href="route('incoming-letters.show', $disposition->incomingLetter)"
        >
            Lihat Surat Masuk
        </x-page.button>

    @endif

    {{-- Edit --}}
    @if(
        auth()->user()->can('disposition.edit')
        && $disposition->status !== 'Selesai'
    )

        <x-page.button
            color="warning"
            icon="fas fa-edit"
            :href="route('dispositions.edit', $disposition)"
        >
            Edit
        </x-page.button>

    @endif

    @if(
        auth()->user()->can('disposition.delete')
        && $disposition->status === 'Baru'
    )

        <x-page.button-delete
            :action="route('dispositions.destroy', $disposition)"
            message="Apakah Anda yakin ingin menghapus disposisi ini?"
            title="Hapus Disposisi"
            size="sm"
        />

    @endif

</x-page.actions>


<div class="row">

    {{-- Informasi Surat Masuk --}}
    <div class="col-md-7">

        <x-page.card
            title="Surat Masuk"
            icon="fas fa-envelope-open-text"
        >

            <x-page.description-table>

                <x-page.description-row
                    label="Nomor Agenda"
                    :value="$disposition->incomingLetter?->agenda_number ?? '-'" />

                <x-page.description-row
                    label="Nomor Surat"
                    :value="$disposition->incomingLetter?->letter_number ?? '-'" />

                <x-page.description-row
                    label="Tanggal Surat"
                    :value="$disposition->incomingLetter?->letter_date?->translatedFormat('d F Y') ?? '-'" />

                <x-page.description-row
                    label="Tanggal Diterima"
                    :value="$disposition->incomingLetter?->received_date?->translatedFormat('d F Y') ?? '-'" />

                <x-page.description-row
                    label="Pengirim"
                    :value="$disposition->incomingLetter?->sender ?? '-'" />

                <x-page.description-row
                    label="Perihal"
                    :value="$disposition->incomingLetter?->regarding ?? '-'" />

                <x-page.description-row label="Prioritas">

                    <x-page.badge.priority
                        :value="$disposition->incomingLetter?->priority ?? 'Biasa'"
                    />

                </x-page.description-row>

                <x-page.description-row label="Status Surat">

                    <x-page.badge.status
                        :value="$disposition->incomingLetter?->status ?? 'Baru'"
                    />

                </x-page.description-row>

            </x-page.description-table>


            @if($disposition->incomingLetter?->file)

                <div class="mt-3">

                    <x-page.button
                        color="info"
                        icon="fas fa-eye"
                        :href="asset('storage/'.$disposition->incomingLetter->file)"
                        target="_blank"
                    >
                        Lihat PDF
                    </x-page.button>

                    <x-page.button
                        color="success"
                        icon="fas fa-download"
                        :href="asset('storage/'.$disposition->incomingLetter->file)"
                        download
                    >
                        Download
                    </x-page.button>

                </div>

            @endif

        </x-page.card>

    </div>


    {{-- Informasi Disposisi --}}
    <div class="col-md-5">

        <x-page.card
            title="Informasi Disposisi"
            icon="fas fa-share"
        >

            <x-page.description-table>

                <x-page.description-row label="Jumlah Penerima">

                    {{ $disposition->recipients->count() }} orang

                </x-page.description-row>

                <x-page.description-row label="Prioritas">

                    <x-page.badge.priority
                        :value="$disposition->priority"
                    />

                </x-page.description-row>

                <x-page.description-row
                    label="Batas Waktu"
                    :value="$disposition->deadline?->translatedFormat('d F Y') ?? '-'" />

                <x-page.description-row label="Status">

                    <x-page.badge.status
                        :value="$disposition->status"
                    />

                </x-page.description-row>

                <x-page.description-row
                    label="Instruksi"
                    :value="$disposition->instruction ?: '-'" />

                <x-page.description-row
                    label="Catatan"
                    :value="$disposition->note ?: '-'" />

            </x-page.description-table>

        </x-page.card>


        {{-- Daftar Penerima --}}
        <x-page.card
            title="Penerima Disposisi"
            icon="fas fa-users"
        >

            @forelse($disposition->recipients as $recipient)

                <div class="border rounded p-3 mb-3">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="font-weight-bold">
                                {{ $recipient->user?->full_name ?? '-' }}
                            </div>

                            @if($recipient->user?->position)

                                <div class="text-muted small">
                                    {{ $recipient->user->position->name }}
                                </div>

                            @endif

                        </div>

                        <x-page.badge.status
                            :value="$recipient->status"
                        />

                    </div>


                    {{-- Timeline status penerima --}}
                    <div class="mt-3">

                        @if($recipient->processed_at)

                            <div class="small text-muted">
                                <i class="fas fa-play mr-1"></i>
                                Diproses:
                                {{ $recipient->processed_at->translatedFormat('d F Y H:i') }}
                            </div>

                        @endif


                        @if($recipient->completed_at)

                            <div class="small text-muted">
                                <i class="fas fa-check mr-1"></i>
                                Selesai:
                                {{ $recipient->completed_at->translatedFormat('d F Y H:i') }}
                            </div>

                        @endif

                    </div>


                    {{-- Aksi penerima --}}
                    <div class="mt-3">

                        {{-- Proses --}}
                        @if(
                            $recipient->status === 'Baru'
                            && auth()->user()->can('disposition.process')
                        )

                            <form
                                action="{{ route('disposition-recipients.process', $recipient) }}"
                                method="POST"
                                class="d-inline"
                            >

                                @csrf
                                @method('PUT')

                                <x-page.button
                                    type="submit"
                                    color="primary"
                                    icon="fas fa-play"
                                >
                                    Proses
                                </x-page.button>

                            </form>

                        @endif


                        {{-- Selesaikan --}}
                        @if(
                            $recipient->status === 'Diproses'
                            && auth()->user()->can('disposition.complete')
                        )

                            <form
                                action="{{ route('disposition-recipients.complete', $recipient) }}"
                                method="POST"
                                class="d-inline"
                            >

                                @csrf
                                @method('PUT')

                                <x-page.button
                                    type="submit"
                                    color="success"
                                    icon="fas fa-check"
                                >
                                    Selesaikan
                                </x-page.button>

                            </form>

                        @endif

                    </div>

                </div>

            @empty

                <div class="text-muted">
                    Belum ada penerima disposisi.
                </div>

            @endforelse

        </x-page.card>


        {{-- Informasi Penginput --}}
        <x-page.card
            title="Informasi Penginput"
            icon="fas fa-user"
        >

            <x-page.description-table>

                <x-page.description-row label="Nama">

                    <x-page.user-info
                        :user="$disposition->createdBy"
                    />

                </x-page.description-row>

                <x-page.description-row
                    label="Role Sistem"
                    :value="$disposition->createdBy?->getRoleNames()->first() ?? '-'" />

                <x-page.description-row
                    label="Tanggal Input"
                    :value="$disposition->created_at?->translatedFormat('d F Y H:i') ?? '-'" />

                <x-page.description-row
                    label="Terakhir Diubah"
                    :value="$disposition->updated_at?->translatedFormat('d F Y H:i') ?? '-'" />

            </x-page.description-table>

        </x-page.card>

    </div>

</div>

@stop