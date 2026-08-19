@extends('adminlte::page')

@section('title', 'Tambah Surat Keluar')

@section('content')

<x-page.header
    title="Tambah Surat Keluar"
    subtitle="Input data surat keluar universitas" />

<x-page.card
    title="Form Surat Keluar"
    icon="fas fa-plus-circle">

    <form
        action="{{ route('outgoing-letters.store') }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf

        <div class="row">

            @include('outgoing_letters._form')

        </div>

        <hr>

        <div class="d-flex justify-content-between">

            <a
                href="{{ route('outgoing-letters.index') }}"
                class="btn btn-secondary">

                <i class="fas fa-arrow-left mr-1"></i>
                Kembali

            </a>

            <button
                type="submit"
                class="btn btn-primary">

                <i class="fas fa-save mr-1"></i>
                Simpan

            </button>

        </div>

    </form>

</x-page.card>

@stop