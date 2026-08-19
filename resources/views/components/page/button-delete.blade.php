@props([
    'action',
    'message' => 'Apakah Anda yakin ingin menghapus data ini?',
    'title' => 'Hapus',
    'size' => 'xs',
])

<form
    action="{{ $action }}"
    method="POST"
    class="d-inline">

    @csrf
    @method('DELETE')

    <button
        type="submit"
        {{ $attributes->merge([
            'class' => 'btn btn-danger btn-'.$size.' shadow-sm',
        ]) }}
        title="{{ $title }}"
        onclick="return confirm('{{ $message }}')">

        <i class="fas fa-trash"></i>

    </button>

</form>