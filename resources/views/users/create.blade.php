@extends('adminlte::page')

@section('title', 'Tambah User')

@section('content_header')
    <h1>Tambah User</h1>
@stop

@section('content')

<div class="card">

    <div class="card-header">

        <h3 class="card-title">
            Form Tambah User
        </h3>

    </div>

    <form
        action="{{ route('users.store') }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf

        <div class="card-body">

            @include('users._form')

        </div>

    </form>

</div>

@stop