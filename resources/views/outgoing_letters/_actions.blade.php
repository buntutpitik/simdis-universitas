<a
    href="{{ route('outgoing-letters.show', $letter) }}"
    class="btn btn-info btn-xs"
    title="Detail">

    <i class="fas fa-eye"></i>

</a>

@if($letter->file)

    <a
        href="{{ route('outgoing-letters.file', $letter) }}"
        download
        class="btn btn-success btn-xs"
        title="Download">

        <i class="fas fa-download"></i>

    </a>

@endif

<a
    href="{{ route('outgoing-letters.edit', $letter) }}"
    class="btn btn-warning btn-xs"
    title="Edit">

    <i class="fas fa-edit"></i>

</a>

<form
    action="{{ route('outgoing-letters.destroy', $letter) }}"
    method="POST"
    class="d-inline">

    @csrf
    @method('DELETE')

    <button
        type="submit"
        class="btn btn-danger btn-xs"
        onclick="return confirm('Apakah Anda yakin ingin menghapus surat ini?')">

        <i class="fas fa-trash"></i>

    </button>

</form>