@extends('adminlte::page')

@section('title', 'Surat Masuk')

@section('content')

<x-page.header
    title="Daftar Surat Masuk"
    subtitle="Kelola seluruh surat masuk universitas" />

<x-page.card
    title="Filter Pencarian"
    icon="fas fa-search">

    <x-page.filter
        :action="route('incoming-letters.index')"
        :reset="route('incoming-letters.index')">

        <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Cari nomor surat, pengirim, atau perihal..."
            value="{{ request('search') }}">

        <x-slot:actions>

            @can('incoming.create')

                <a
                    href="{{ route('incoming-letters.create') }}"
                    class="btn btn-success">

                    <i class="fas fa-plus mr-1"></i>
                    Tambah Surat

                </a>

            @endcan

        </x-slot:actions>

    </x-page.filter>

</x-page.card>

<x-page.card
    title="Data Surat Masuk"
    icon="fas fa-envelope">

    <x-alert />

    <div class="table-responsive">

        <x-page.table class="mb-0">

            <thead class="bg-light">

                <tr>

                    <th class="align-middle text-center" width="50">
                        No
                    </th>

                    <th class="align-middle" width="190">
                        Nomor Agenda
                    </th>

                    <th class="align-middle">
                        Nomor Surat
                    </th>

                    <th class="align-middle" width="120">
                        Tanggal
                    </th>

                    <th class="align-middle" width="220">
                        Pengirim
                    </th>

                    <th class="align-middle" width="260">
                        Perihal
                    </th>

                    <th class="align-middle text-center" width="110">
                        Prioritas
                    </th>

                    <th class="align-middle text-center" width="110">
                        Status
                    </th>

                    <th class="align-middle" width="180">
                        Petugas
                    </th>

                    <th class="align-middle text-center" width="220">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($letters as $letter)

                    <tr>

                        <td class="align-middle text-center">
                            {{ $letters->firstItem() + $loop->index }}
                        </td>

                        <td class="align-middle font-weight-bold text-primary text-nowrap">
                            {{ $letter->agenda_number }}
                        </td>

                        <td class="align-middle text-nowrap">
                            {{ $letter->letter_number }}
                        </td>

                        <td class="align-middle text-nowrap">
                            {{ $letter->letter_date?->translatedFormat('d F Y') ?? '-' }}
                        </td>

                        <td class="align-middle">
                            {{ $letter->sender }}
                        </td>

                        <td class="align-middle">
                            {{ Str::limit($letter->regarding, 55) }}
                        </td>

                        <td class="align-middle text-center">

                            <x-page.badge.priority
                                :value="$letter->priority" />

                        </td>

                        <td class="align-middle text-center">

                            <x-page.badge.status
                                :value="$letter->status" />

                        </td>

                        <td class="align-middle">

                            <x-page.user-info
                                :user="$letter->createdBy" />

                        </td>

                        {{-- MENU AKSI — FROZEN --}}

                        <td class="align-middle text-center text-nowrap">

                            <div class="d-inline-flex align-items-center">

                                <div class="btn-group btn-group-sm" role="group">

                                    <x-page.button
                                        :href="route('incoming-letters.show', $letter)"
                                        color="info"
                                        icon="fas fa-eye"
                                        title="Detail" />

                                    @if($letter->file)

                                        <x-page.button
                                            :href="route('incoming-letters.file', $letter)"
                                            color="success"
                                            icon="fas fa-file-pdf"
                                            title="Download"
                                            download />

                                    @endif

                                    @if(
                                        auth()->user()->can('incoming.edit')
                                        && $letter->status === 'Baru'
                                    )

                                        <x-page.button
                                            :href="route('incoming-letters.edit', $letter)"
                                            color="warning"
                                            icon="fas fa-edit"
                                            title="Edit" />

                                    @endif

                                </div>

                                @if(
                                    auth()->user()->can('incoming.delete')
                                    && $letter->status === 'Baru'
                                    && ! $letter->dispositions_exists
                                )

                                    <x-page.button-delete
                                        :action="route('incoming-letters.destroy', $letter)"
                                        message="Apakah Anda yakin ingin menghapus surat ini?"
                                        title="Hapus"
                                        class="ml-1" />

                                @endif

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="10">

                            <x-page.empty
                                title="Belum ada surat masuk">

                                Silakan tambahkan surat masuk pertama.

                            </x-page.empty>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </x-page.table>

    </div>

    <div class="d-flex justify-content-between align-items-center mt-3">

        <div class="text-muted small">

            Menampilkan
            <strong>{{ $letters->firstItem() ?? 0 }}</strong>
            -
            <strong>{{ $letters->lastItem() ?? 0 }}</strong>
            dari
            <strong>{{ $letters->total() }}</strong>
            surat

        </div>

        <div>

            {{ $letters->onEachSide(1)->links() }}

        </div>

    </div>

</x-page.card>

@stop