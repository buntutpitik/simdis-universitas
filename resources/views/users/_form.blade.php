<div class="form-group">

    <label>
        Nama Lengkap
        <span class="text-danger">*</span>
    </label>

    <input
        type="text"
        name="full_name"
        class="form-control @error('full_name') is-invalid @enderror"
        value="{{ old('full_name', $user->full_name ?? '') }}"
        required>

    @error('full_name')
        <span class="invalid-feedback">
            {{ $message }}
        </span>
    @enderror

</div>

<div class="form-group">

    <label>
        Email
        <span class="text-danger">*</span>
    </label>

    <input
        type="email"
        name="email"
        class="form-control @error('email') is-invalid @enderror"
        value="{{ old('email', $user->email ?? '') }}"
        required>

    @error('email')
        <span class="invalid-feedback">
            {{ $message }}
        </span>
    @enderror

</div>

<div class="form-group">

    <label>

        Password

        @if(!isset($user))
            <span class="text-danger">*</span>
        @endif

    </label>

    <input
        type="password"
        name="password"
        class="form-control @error('password') is-invalid @enderror">

    @if(isset($user))
        <small class="text-muted">
            Kosongkan jika tidak ingin mengubah password.
        </small>
    @endif

    @error('password')
        <span class="invalid-feedback">
            {{ $message }}
        </span>
    @enderror

</div>

<div class="form-group">

    <label>Konfirmasi Password</label>

    <input
        type="password"
        name="password_confirmation"
        class="form-control">

</div>

<div class="form-group">

    <label>
        Jabatan
        <span class="text-danger">*</span>    
    </label>

    <select
        name="position_id"
        class="form-control">

        @foreach($positions as $position)

            <option
                value="{{ $position->id }}"
                @selected(old('position_id', $user->position_id ?? '') == $position->id)>

                {{ $position->name }}

            </option>

        @endforeach

    </select>

</div>

<div class="form-group">

    <label>
        Role
        <span class="text-danger">*</span>
    </label>

    <select name="role" class="form-control">

    @foreach($roles as $role)

        <option
            value="{{ $role->name }}"
            @selected(
                old(
                    'role',
                    isset($user) ? $user->roles->first()?->name : ''
                ) == $role->name
            )>

            {{ $role->name }}

        </option>

    @endforeach

    </select>

</div>

<div class="form-group">

    <label>No. HP</label>

    <input
        type="text"
        name="phone"
        class="form-control"
        value="{{ old('phone', $user->phone ?? '') }}">

</div>

@if(isset($user) && $user->avatar)

    <div class="mb-3">

        <img
            src="{{ asset('storage/'.$user->avatar) }}"
            class="img-thumbnail"
            width="120">

    </div>

@endif

<div class="form-group">

    <label>Avatar</label>

    @if(isset($user) && $user->avatar)

        <div class="mb-2">

            <img
                src="{{ asset('storage/'.$user->avatar) }}"
                class="img-thumbnail rounded-circle"
                width="120"
                height="120">

        </div>

    @endif

    <input
        type="file"
        name="avatar"
        class="form-control">

    <small class="text-muted">
        Kosongkan jika tidak ingin mengganti avatar.
    </small>

</div>

<div class="form-group">

    <label>Status</label>

    <select
        name="is_active"
        class="form-control">

        <option value="1"
            @selected(old('is_active', $user->is_active ?? 1) == 1)>
            Aktif
        </option>

        <option value="0"
            @selected(old('is_active', $user->is_active ?? 1) == 0)>
            Nonaktif
        </option>

    </select>

</div>

<div class="mt-4">

    <button class="btn btn-primary">

        <i class="fas fa-save"></i>

        {{ isset($user) ? 'Update User' : 'Simpan User' }}

    </button>

    <a
        href="{{ route('users.index') }}"
        class="btn btn-secondary">

        Kembali

    </a>

</div>


