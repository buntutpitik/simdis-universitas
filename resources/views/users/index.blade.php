@extends('adminlte::page')

@section('title', 'Master User')

@section('content_header')

<h1>Master User</h1>

@stop

@section('content')

<x-alert />

<div class="card">

    <div class="card-header">

        <h3 class="card-title">
            Daftar User
        </h3>

        <div class="card-tools">

            @can('users.create')

                <a
                    href="{{ route('users.create') }}"
                    class="btn btn-primary btn-sm">

                    <i class="fas fa-plus"></i>

                    Tambah User

                </a>

            @endcan

        </div>

    </div>

    <div class="card-body">

        <table class="table table-bordered table-striped">

            <thead>

                <tr>

                    <th width="50">No</th>

                    <th width="70">Avatar</th>

                    <th>Nama</th>

                    <th>Email</th>

                    <th>Jabatan</th>

                    <th>Role</th>

                    <th>Status</th>

                    <th width="120">Aksi</th>

                </tr>

            </thead>

            <tbody>

                @forelse($users as $user)

                <tr>

                    <td>
                        {{ $users->firstItem() + $loop->index }}
                    </td>

                    <td>

                        @if($user->avatar)

                            <img
                                src="{{ asset('storage/'.$user->avatar) }}"
                                width="45"
                                class="img-circle">

                        @else

                            <img
                                src="https://ui-avatars.com/api/?name={{ urlencode($user->full_name) }}"
                                width="45"
                                class="img-circle">

                        @endif

                    </td>

                    <td>{{ $user->full_name }}</td>

                    <td>{{ $user->email }}</td>

                    <td>{{ $user->position->name ?? '-' }}</td>

                    <td>

                        @foreach($user->roles as $role)

                            <span class="badge badge-info">

                                {{ $role->name }}

                            </span>

                        @endforeach

                    </td>

                    <td>

                        @if($user->is_active)

                            <span class="badge badge-success">

                                Aktif

                            </span>

                        @else

                            <span class="badge badge-danger">

                                Nonaktif

                            </span>

                        @endif

                    </td>

                    <td>

                        @can('users.edit')

                            <a
                                href="{{ route('users.edit', $user) }}"
                                class="btn btn-warning btn-xs">

                                <i class="fas fa-edit"></i>

                            </a>

                        @endcan

                        @can('users.delete')

                            <form
                                action="{{ route('users.destroy', $user) }}"
                                method="POST"
                                style="display:inline">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn btn-danger btn-xs">

                                    <i class="fas fa-trash"></i>

                                </button>

                            </form>

                        @endcan

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="8" class="text-center">

                        Belum ada data.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="card-footer clearfix">

        {{ $users->links() }}

    </div>

</div>

@stop