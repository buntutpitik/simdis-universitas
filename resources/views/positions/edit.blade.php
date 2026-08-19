@extends('adminlte::page')

@section('title', 'Edit Jabatan')

@section('content_header')
<h1>Edit Jabatan</h1>
@stop

@section('content')

<div class="card">

    <form action="{{ route('positions.update', $position) }}" method="POST">

        @csrf
        @method('PUT')

        <div class="card-body">

            <div class="form-group">
                <label>Kode</label>

                <input
                    type="text"
                    name="code"
                    class="form-control @error('code') is-invalid @enderror"
                    value="{{ old('code', $position->code) }}"
                    value="{{ old('name', $position->name) }}"

                @error('code')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="form-group">

                <label>Nama Jabatan</label>

                <input
                    type="text"
                    name="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}">

                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

        </div>

        <div class="card-footer">

            <button class="btn btn-primary">
                Simpan
            </button>

            <a href="{{ route('positions.index') }}"
               class="btn btn-secondary">

                Kembali

            </a>

        </div>

    </form>

</div>

@stop