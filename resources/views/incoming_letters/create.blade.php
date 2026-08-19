@extends('adminlte::page')

@section('title', 'Tambah Surat Masuk')

@section('content')

<x-page.header
    title="Tambah Surat Masuk"
    subtitle="Input data surat masuk baru" />

<x-page.card
    title="Form Surat Masuk"
    icon="fas fa-plus-circle">

    <form
        action="{{ route('incoming-letters.store') }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf

        @include('incoming_letters._form')

    </form>

</x-page.card>

@stop