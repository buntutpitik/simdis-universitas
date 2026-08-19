@extends('adminlte::page')

@section('title', 'Master Jabatan')

@section('content_header')
    <h1>Master Jabatan</h1>
@stop

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h3 class="card-title">
            Daftar Jabatan
        </h3>

        @can('positions.create')

            <x-button-create :href="route('positions.create')">
                Tambah Jabatan
            </x-button-create>

        @endcan

    </div>

    <div class="card-body">

        <x-alert />

        <table class="table table-bordered table-striped">

            <thead>

                <tr>
                    <th width="60">No</th>
                    <th width="120">Kode</th>
                    <th>Nama Jabatan</th>
                    <th width="180" class="text-center">Aksi</th>
                </tr>

            </thead>

            <tbody>

                @forelse($positions as $position)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $position->code }}</td>

                        <td>{{ $position->name }}</td>

                        <td class="text-center">

                            @can('positions.edit')

                                <x-button-edit
                                    :href="route('positions.edit', $position)" />

                            @endcan

                            @can('positions.delete')

                                <x-button-delete
                                    :action="route('positions.destroy', $position)" />

                            @endcan

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="4" class="text-center text-muted">
                            Belum ada data jabatan.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@stop