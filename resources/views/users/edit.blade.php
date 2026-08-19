@extends('adminlte::page')

@section('title', 'Edit User')

@section('content_header')
<h1>Edit User</h1>
@stop

@section('content')

<div class="card">

    <div class="card-header">

        <h3 class="card-title">
            Form Edit User
        </h3>

    </div>

    <form
        action="{{ route('users.update', $user) }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="card-body">

            @include('users._form')

        </div>

    </form>

</div>

@stop