@if(auth()->user()->can('disposition.view'))

    <a
        href="{{ route('dispositions.show', $disposition) }}"
        class="btn btn-info btn-xs"
        title="Lihat">

        <i class="fas fa-eye"></i>

    </a>

@endif


@if(
        auth()->user()->can('disposition.edit')
        && $disposition->status !== 'Selesai'
    )

    <a
        href="{{ route('dispositions.edit', $disposition) }}"
        class="btn btn-warning btn-xs"
        title="Edit">

        <i class="fas fa-edit"></i>

    </a>

@endif


@if(
        auth()->user()->can('disposition.delete')
        && $disposition->status === 'Baru'
    )

    <form
        action="{{ route('dispositions.destroy', $disposition) }}"
        method="POST"
        class="d-inline">

        @csrf

        @method('DELETE')

        <button
            type="submit"
            class="btn btn-danger btn-xs"
            title="Hapus"
            onclick="return confirm('Apakah Anda yakin ingin menghapus disposisi ini?')">

            <i class="fas fa-trash"></i>

        </button>

    </form>

@endif