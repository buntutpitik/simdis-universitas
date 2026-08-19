<form action="{{ $action }}" method="POST" style="display:inline">

    @csrf
    @method('DELETE')

    <button
        type="submit"
        class="btn btn-danger btn-sm"
        onclick="return confirm('Yakin ingin menghapus data ini?')">

        <i class="fas fa-trash"></i>
        Hapus

    </button>

</form>