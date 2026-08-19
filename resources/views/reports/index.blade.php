@extends('adminlte::page')

@section('title', 'Laporan')

@section('content')

<x-page.header
    title="Laporan"
    subtitle="Laporan administrasi persuratan universitas" />


@if($errors->any())

    <div class="alert alert-danger">

        <ul class="mb-0">

            @foreach($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif


<x-page.card
    title="Filter Laporan"
    icon="fas fa-filter">

    <form
        action="{{ route('reports.index') }}"
        method="GET">

        <div class="row">

            {{-- Jenis Laporan --}}
            <div class="col-md-4">

                <div class="form-group">

                    <label for="type">
                        Jenis Laporan
                    </label>

                    <select
                        name="type"
                        id="type"
                        class="form-control">

                        <option
                            value="incoming"
                            {{ $type === 'incoming' ? 'selected' : '' }}>
                            Surat Masuk
                        </option>

                        <option
                            value="outgoing"
                            {{ $type === 'outgoing' ? 'selected' : '' }}>
                            Surat Keluar
                        </option>

                        <option
                            value="disposition"
                            {{ $type === 'disposition' ? 'selected' : '' }}>
                            Disposisi
                        </option>

                    </select>

                </div>

            </div>


            {{-- Dari Tanggal --}}
            <div class="col-md-2">

                <div class="form-group">

                    <label for="date_from">
                        Dari Tanggal
                    </label>

                    <input
                        type="date"
                        name="date_from"
                        id="date_from"
                        class="form-control"
                        value="{{ $dateFrom }}">

                </div>

            </div>


            {{-- Sampai Tanggal --}}
            <div class="col-md-2">

                <div class="form-group">

                    <label for="date_to">
                        Sampai Tanggal
                    </label>

                    <input
                        type="date"
                        name="date_to"
                        id="date_to"
                        class="form-control"
                        value="{{ $dateTo }}">

                </div>

            </div>


            {{-- Status --}}
            <div class="col-md-2">

                <div class="form-group">

                    <label for="status">
                        Status
                    </label>

                    <select
                        name="status"
                        id="status"
                        class="form-control"
                        {{ $type === 'outgoing' ? 'disabled' : '' }}>

                        <option value="">
                            Semua Status
                        </option>

                        @if($type === 'incoming')

                            <option
                                value="Baru"
                                {{ $status === 'Baru' ? 'selected' : '' }}>
                                Baru
                            </option>

                            <option
                                value="Didisposisi"
                                {{ $status === 'Didisposisi' ? 'selected' : '' }}>
                                Didisposisi
                            </option>

                            <option
                                value="Selesai"
                                {{ $status === 'Selesai' ? 'selected' : '' }}>
                                Selesai
                            </option>

                        @elseif($type === 'disposition')

                            <option
                                value="Baru"
                                {{ $status === 'Baru' ? 'selected' : '' }}>
                                Baru
                            </option>

                            <option
                                value="Diproses"
                                {{ $status === 'Diproses' ? 'selected' : '' }}>
                                Diproses
                            </option>

                            <option
                                value="Selesai"
                                {{ $status === 'Selesai' ? 'selected' : '' }}>
                                Selesai
                            </option>

                        @endif

                    </select>

                </div>

            </div>


            {{-- Prioritas --}}
            <div class="col-md-2">

                <div class="form-group">

                    <label for="priority">
                        Prioritas
                    </label>

                    <select
                        name="priority"
                        id="priority"
                        class="form-control">

                        <option value="">
                            Semua Prioritas
                        </option>

                        @foreach([
                            'Biasa',
                            'Penting',
                            'Segera',
                            'Rahasia'
                        ] as $item)

                            <option
                                value="{{ $item }}"
                                {{ $priority === $item ? 'selected' : '' }}>

                                {{ $item }}

                            </option>

                        @endforeach

                    </select>

                </div>

            </div>

        </div>


        <div class="row">

            <div class="col-12">

                <div class="form-group mb-0">

                    <button
                        type="submit"
                        class="btn btn-primary">

                        <i class="fas fa-search mr-1"></i>
                        Tampilkan

                    </button>

                    {{-- RESET --}}
                    <a
                        href="{{ route('reports.index') }}"
                        class="btn btn-secondary">

                        <i class="fas fa-sync-alt mr-1"></i>
                        Reset

                    </a>

                    {{-- PDF --}}
                    <a
                        href="{{ route('reports.pdf', [
                            'type' => $type,
                            'date_from' => $dateFrom,
                            'date_to' => $dateTo,
                            'status' => $status,
                            'priority' => $priority,
                        ]) }}"
                        class="btn btn-danger">

                        <i class="fas fa-file-pdf mr-1"></i>
                        PDF

                    </a>

                    {{-- Excel --}}
                    <a
                        href="{{ route('reports.excel', [
                            'type' => $type,
                            'date_from' => $dateFrom,
                            'date_to' => $dateTo,
                            'status' => $status,
                            'priority' => $priority,
                        ]) }}"
                        class="btn btn-success">

                        <i class="fas fa-file-excel mr-1"></i>
                        Excel

                    </a>

                </div>

            </div>

        </div>

    </form>

</x-page.card>


<x-page.card
    title="Hasil Laporan"
    icon="fas fa-file-alt">

    <x-alert />


    {{-- ======================================================
         SURAT MASUK
    ======================================================= --}}

    @if($type === 'incoming')

        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead class="bg-light">

                    <tr>

                        <th width="50">
                            No
                        </th>

                        <th>
                            Agenda
                        </th>

                        <th>
                            Nomor Surat
                        </th>

                        <th>
                            Tanggal Terima
                        </th>

                        <th>
                            Pengirim
                        </th>

                        <th>
                            Perihal
                        </th>

                        <th>
                            Prioritas
                        </th>

                        <th>
                            Status
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($data as $letter)

                        <tr>

                            <td class="text-center">
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $letter->agenda_number }}
                            </td>

                            <td>
                                {{ $letter->letter_number }}
                            </td>

                            <td>
                                {{ $letter->received_date?->translatedFormat('d F Y') ?? '-' }}
                            </td>

                            <td>
                                {{ $letter->sender }}
                            </td>

                            <td>
                                {{ $letter->regarding }}
                            </td>

                            <td>

                                <x-page.badge.priority
                                    :value="$letter->priority" />

                            </td>

                            <td>

                                <x-page.badge.status
                                    :value="$letter->status" />

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="8"
                                class="text-center text-muted py-4">

                                Tidak ada data surat masuk.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


    {{-- ======================================================
         SURAT KELUAR
    ======================================================= --}}

    @elseif($type === 'outgoing')

        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead class="bg-light">

                    <tr>

                        <th width="50">
                            No
                        </th>

                        <th>
                            Agenda
                        </th>

                        <th>
                            Nomor Surat
                        </th>

                        <th>
                            Tanggal Surat
                        </th>

                        <th>
                            Tujuan
                        </th>

                        <th>
                            Perihal
                        </th>

                        <th>
                            Prioritas
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($data as $letter)

                        <tr>

                            <td class="text-center">
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $letter->agenda_number }}
                            </td>

                            <td>
                                {{ $letter->letter_number }}
                            </td>

                            <td>
                                {{ $letter->letter_date?->translatedFormat('d F Y') ?? '-' }}
                            </td>

                            <td>
                                {{ $letter->recipient }}
                            </td>

                            <td>
                                {{ $letter->regarding }}
                            </td>

                            <td>

                                <x-page.badge.priority
                                    :value="$letter->priority" />

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="text-center text-muted py-4">

                                Tidak ada data surat keluar.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


    {{-- ======================================================
         DISPOSISI
    ======================================================= --}}

    @elseif($type === 'disposition')

        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead class="bg-light">

                    <tr>

                        <th width="50">
                            No
                        </th>

                        <th>
                            Agenda Surat
                        </th>

                        <th>
                            Nomor Surat
                        </th>

                        <th>
                            Pengirim
                        </th>

                        <th>
                            Perihal
                        </th>

                        <th>
                            Prioritas
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Tanggal
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($data as $disposition)

                        <tr>

                            <td class="text-center">
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $disposition->incomingLetter?->agenda_number ?? '-' }}
                            </td>

                            <td>
                                {{ $disposition->incomingLetter?->letter_number ?? '-' }}
                            </td>

                            <td>
                                {{ $disposition->incomingLetter?->sender ?? '-' }}
                            </td>

                            <td>
                                {{ $disposition->incomingLetter?->regarding ?? '-' }}
                            </td>

                            <td>

                                <x-page.badge.priority
                                    :value="$disposition->priority" />

                            </td>

                            <td>

                                <x-page.badge.status
                                    :value="$disposition->status" />

                            </td>

                            <td>
                                {{ $disposition->created_at?->translatedFormat('d F Y') ?? '-' }}
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="8"
                                class="text-center text-muted py-4">

                                Tidak ada data disposisi.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    @endif


    <div class="mt-3 text-muted">

        <small>
            Total data:
            <strong>{{ $data->count() }}</strong>
        </small>

    </div>

</x-page.card>

@stop