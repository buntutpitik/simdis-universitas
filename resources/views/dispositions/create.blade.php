@extends('adminlte::page')

@section('title', 'Tambah Disposisi')

@section('content')

    <x-page.header
        title="Tambah Disposisi"
        subtitle="Input disposisi surat masuk universitas"
    />

    <x-page.card
        title="Form Disposisi"
        icon="fas fa-share"
    >

        <form
            action="{{ route('dispositions.store') }}"
            method="POST"
        >

            @csrf

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

                    Simpan

                </button>

            </div>

        </form>

    </x-page.card>

@stop