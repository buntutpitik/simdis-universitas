@extends('adminlte::page')

@section('title', 'Disposisi Surat')

@section('content')

<x-page.header
    title="Daftar Disposisi"
    subtitle="Kelola disposisi surat masuk universitas"
/>


<x-page.card
    title="Filter Pencarian"
    icon="fas fa-search"
>

    <x-page.filter
        :action="route('dispositions.index')"
        :reset="route('dispositions.index')"
    >

        <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Cari nomor surat, pengirim, perihal, atau penerima..."
            value="{{ request('search') }}"
        >

        <x-slot:actions>

            @if(auth()->user()->can('disposition.create'))

                <a
                    href="{{ route('dispositions.create') }}"
                    class="btn btn-success"
                >
                    <i class="fas fa-plus mr-1"></i>
                    Tambah Disposisi
                </a>

            @endif

        </x-slot:actions>

    </x-page.filter>

</x-page.card>


<x-page.card
    title="Data Disposisi"
    icon="fas fa-share-square"
>

    <x-alert />

    <div class="table-responsive">

        <table class="table table-bordered table-hover">

            <thead>

                <tr>

                    <th width="50">No</th>

                    <th>Surat Masuk</th>

                    <th>Penerima</th>

                    <th>Instruksi</th>

                    <th>Prioritas</th>

                    <th>Batas Waktu</th>

                    <th>Status</th>

                    <th width="180">Aksi</th>

                </tr>

            </thead>


            <tbody>

                @forelse($dispositions as $disposition)

                    <tr>

                        {{-- No --}}
                        <td>

                            {{ $dispositions->firstItem() + $loop->index }}

                        </td>


                        {{-- Surat Masuk --}}
                        <td>

                            <strong>
                                {{ $disposition->incomingLetter?->agenda_number ?? '-' }}
                            </strong>

                            <br>

                            <small class="text-muted">
                                {{ $disposition->incomingLetter?->letter_number ?? '-' }}
                            </small>

                            <br>

                            <small>
                                {{ $disposition->incomingLetter?->sender ?? '-' }}
                            </small>

                        </td>


                        {{-- Penerima --}}
                        <td>

                            @forelse($disposition->recipients as $recipient)

                                <div class="mb-1">

                                    <strong>
                                        {{ $recipient->user?->full_name ?? '-' }}
                                    </strong>

                                    @if($recipient->user?->position)

                                        <br>

                                        <small class="text-muted">
                                            {{ $recipient->user->position->name }}
                                        </small>

                                    @endif

                                </div>

                            @empty

                                <span class="text-muted">
                                    Belum ada penerima
                                </span>

                            @endforelse

                        </td>


                        {{-- Instruksi --}}
                        <td>

                            {{ $disposition->instruction ?? '-' }}

                        </td>


                        {{-- Prioritas --}}
                        <td>

                            <x-page.badge.priority
                                :value="$disposition->priority"
                            />

                        </td>


                        {{-- Batas Waktu --}}
                        <td>

                            {{ $disposition->deadline?->translatedFormat('d F Y') ?? '-' }}

                        </td>


                        {{-- Status --}}
                        <td>

                            <x-page.badge.status
                                :value="$disposition->status"
                            />

                        </td>


                        {{-- Aksi --}}
                        <td>

                            @include(
                                'dispositions._actions',
                                ['disposition' => $disposition]
                            )

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="8">

                            <x-page.empty
                                title="Belum ada disposisi"
                            >
                                Silakan tambahkan disposisi surat pertama.
                            </x-page.empty>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    <div class="mt-3">

        {{ $dispositions->links() }}

    </div>

</x-page.card>

@stop