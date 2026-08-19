@extends('adminlte::page')

@section('title', 'Edit Surat Masuk')

@section('content')

<x-page.header
    title="Edit Surat Masuk"
    subtitle="Perbarui data surat masuk universitas" />

<x-page.card
    title="Form Edit Surat Masuk"
    icon="fas fa-edit">

    <form
        action="{{ route('incoming-letters.update', $incomingLetter) }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf
        @method('PUT')

        @include('incoming_letters._form')

    </form>

</x-page.card>

@stop