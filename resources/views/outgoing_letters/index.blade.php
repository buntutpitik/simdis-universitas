@extends('adminlte::page')

@section('title', 'Surat Keluar')

@section('content')

<x-page.header
    title="Daftar Surat Keluar"
    subtitle="Kelola seluruh surat keluar universitas" />

<x-page.card
    title="Filter Pencarian"
    icon="fas fa-search">

    <x-page.filter
        :action="route('outgoing-letters.index')"
        :reset="route('outgoing-letters.index')">

        <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Cari nomor surat, tujuan, perihal, atau petugas..."
            value="{{ request('search') }}">

        <x-slot:actions>

            @if(auth()->user()->can('outgoing.create'))

                <a
                    href="{{ route('outgoing-letters.create') }}"
                    class="btn btn-success">

                    <i class="fas fa-plus mr-1"></i>
                    Tambah Surat

                </a>

            @endif

        </x-slot:actions>

    </x-page.filter>

</x-page.card>

<x-page.card
    title="Data Surat Keluar"
    icon="fas fa-paper-plane">

    <x-alert />

    <x-page.table>

        <thead class="bg-light">

            <tr>

                <th class="align-middle" width="50">
                    No
                </th>

                <th class="align-middle" width="190">
                    Nomor Agenda
                </th>

                <th class="align-middle">
                    Nomor Surat
                </th>

                <th class="align-middle">
                    Tanggal
                </th>

                <th class="align-middle">
                    Tujuan
                </th>

                <th class="align-middle">
                    Perihal
                </th>

                <th class="align-middle" width="110">
                    Prioritas
                </th>

                <th class="align-middle" width="180">
                    Petugas
                </th>

                <th class="align-middle" width="220">
                    Aksi
                </th>

            </tr>

        </thead>

        <tbody>

            @forelse($letters as $letter)

                <tr class="text-center">

                    <td class="align-middle">
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

                    <td class="align-middle" style="min-width:220px">
                        {{ $letter->recipient }}
                    </td>

                    <td class="align-middle" style="min-width:260px">
                        {{ Str::limit($letter->regarding, 55) }}
                    </td>

                    <td class="align-middle text-center">

                        <x-page.badge.priority
                            :value="$letter->priority" />

                    </td>

                    <td class="align-middle">

                        <x-page.user-info
                            :user="$letter->createdBy" />

                    </td>

                    <td class="align-middle text-nowrap">

                        <div class="d-inline-flex align-items-center">

                            <div
                                class="btn-group btn-group-sm"
                                role="group">

                                <x-page.button
                                    :href="route('outgoing-letters.show', $letter)"
                                    color="info"
                                    icon="fas fa-eye"
                                    title="Detail" />

                                @if($letter->file)

                                    <x-page.button
                                        :href="route('outgoing-letters.file', $letter)"
                                        color="success"
                                        icon="fas fa-file-pdf"
                                        title="Download"
                                        download />

                                @endif

                                @if(auth()->user()->can('outgoing.edit'))

                                    <x-page.button
                                        :href="route('outgoing-letters.edit', $letter)"
                                        color="warning"
                                        icon="fas fa-edit"
                                        title="Edit" />

                                @endif

                            </div>

                            @if(auth()->user()->can('outgoing.delete'))

                                <x-page.button-delete
                                    :action="route('outgoing-letters.destroy', $letter)"
                                    message="Apakah Anda yakin ingin menghapus surat ini?"
                                    title="Hapus"
                                    class="ml-1" />

                            @endif

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="9">

                        <x-page.empty
                            title="Belum ada surat keluar">

                            Silakan tambahkan surat keluar pertama.

                        </x-page.empty>

                    </td>

                </tr>

            @endforelse

        </tbody>

    </x-page.table>

    <div class="mt-3">

        {{ $letters->links() }}

    </div>

</x-page.card>

@stop