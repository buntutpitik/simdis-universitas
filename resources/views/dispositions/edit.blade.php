@extends('adminlte::page')

@section('title', 'Edit Disposisi')

@section('content')

    <x-page.header
        title="Edit Disposisi"
        subtitle="Perbarui data disposisi surat masuk"
    />

    <x-page.card
        title="Form Disposisi"
        icon="fas fa-edit"
    >

        <form
            action="{{ route('dispositions.update', $disposition) }}"
            method="POST"
        >

            @csrf

            @method('PUT')

            <div class="row">

                @include('dispositions._form')

            </div>

            <div class="mt-3">

                <a
                    href="{{ route('dispositions.index') }}"
                    class="btn btn-secondary"
                >

                    <i class="fas fa-arrow-left mr-1"></i>

                    Kembali

                </a>

                <button
                    type="submit"
                    class="btn btn-primary"
                >

                    <i class="fas fa-save mr-1"></i>

                    Update

                </button>

            </div>

        </form>

    </x-page.card>

@stop