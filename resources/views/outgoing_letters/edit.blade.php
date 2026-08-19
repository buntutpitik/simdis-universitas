@extends('adminlte::page')

@section('title', 'Edit Surat Keluar')

@section('content')

<x-page.header
    title="Edit Surat Keluar"
    subtitle="Perbarui data surat keluar universitas" />

<x-page.card
    title="Form Edit Surat Keluar"
    icon="fas fa-edit">

    <form
        action="{{ route('outgoing-letters.update', $outgoingLetter) }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="row">

            @include('outgoing_letters._form')

        </div>

        <div class="mt-3">

            <a
                href="{{ route('outgoing-letters.index') }}"
                class="btn btn-secondary">

                <i class="fas fa-arrow-left mr-1"></i>
                Kembali

            </a>

            <button
                type="submit"
                class="btn btn-warning">

                <i class="fas fa-save mr-1"></i>
                Update

            </button>

        </div>

    </form>

</x-page.card>

@stop