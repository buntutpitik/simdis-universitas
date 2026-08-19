<div class="row">

    {{-- Nomor Surat --}}
    <div class="col-md-6">

        <div class="form-group">

            <label>
                Nomor Surat
                <span class="text-danger">*</span>
            </label>

            <input
                type="text"
                name="letter_number"
                class="form-control @error('letter_number') is-invalid @enderror"
                value="{{ old('letter_number', $incomingLetter->letter_number ?? '') }}"
                required>

            @error('letter_number')
                <span class="invalid-feedback">
                    {{ $message }}
                </span>
            @enderror

        </div>

    </div>


    {{-- Pengirim --}}
    <div class="col-md-6">

        <div class="form-group">

            <label>
                Pengirim
                <span class="text-danger">*</span>
            </label>

            <input
                type="text"
                name="sender"
                class="form-control @error('sender') is-invalid @enderror"
                value="{{ old('sender', $incomingLetter->sender ?? '') }}"
                required>

            @error('sender')
                <span class="invalid-feedback">
                    {{ $message }}
                </span>
            @enderror

        </div>

    </div>


    {{-- Tanggal Surat --}}
    <div class="col-md-6">

        <div class="form-group">

            <label>Tanggal Surat</label>

            <input
                type="date"
                name="letter_date"
                class="form-control"
                value="{{ old(
                    'letter_date',
                    isset($incomingLetter)
                        ? $incomingLetter->letter_date?->format('Y-m-d')
                        : ''
                ) }}">

        </div>

    </div>


    {{-- Tanggal Diterima --}}
    <div class="col-md-6">

        <div class="form-group">

            <label>Tanggal Diterima</label>

            <input
                type="date"
                name="received_date"
                class="form-control"
                value="{{ old(
                    'received_date',
                    isset($incomingLetter)
                        ? $incomingLetter->received_date?->format('Y-m-d')
                        : ''
                ) }}">

        </div>

    </div>


    {{-- Perihal --}}
    <div class="col-md-12">

        <div class="form-group">

            <label>Perihal</label>

            <input
                type="text"
                name="regarding"
                class="form-control"
                value="{{ old('regarding', $incomingLetter->regarding ?? '') }}">

        </div>

    </div>


    {{-- Prioritas --}}
    <div class="col-md-6">

        <div class="form-group">

            <label>Prioritas</label>

            <select
                name="priority"
                class="form-control">

                @foreach(['Biasa', 'Penting', 'Segera', 'Rahasia'] as $priority)

                    <option
                        value="{{ $priority }}"
                        @selected(
                            old('priority', $incomingLetter->priority ?? '') == $priority
                        )>

                        {{ $priority }}

                    </option>

                @endforeach

            </select>

        </div>

    </div>


    {{-- Lampiran --}}
    <div class="col-md-6">

        <div class="form-group">

            <label>Lampiran</label>

            <input
                type="text"
                name="attachment"
                class="form-control"
                value="{{ old('attachment', $incomingLetter->attachment ?? '') }}">

        </div>

    </div>


    {{-- Keterangan --}}
    <div class="col-md-12">

        <div class="form-group">

            <label>Keterangan</label>

            <textarea
                name="description"
                rows="4"
                class="form-control">{{ old('description', $incomingLetter->description ?? '') }}</textarea>

        </div>

    </div>


    {{-- File PDF --}}
    <div class="col-md-12">

        <div class="form-group">

            <label>
                File PDF

                @if(!isset($incomingLetter))
                    <span class="text-danger">*</span>
                @endif

            </label>

            <input
                type="file"
                name="file"
                class="form-control @error('file') is-invalid @enderror">

            @if(isset($incomingLetter))

                <small class="text-muted">
                    Kosongkan jika tidak ingin mengganti file PDF.
                </small>

            @endif

            @error('file')

                <span class="invalid-feedback">
                    {{ $message }}
                </span>

            @enderror

        </div>

    </div>

</div>


{{-- Tombol --}}
<div class="d-flex justify-content-between mt-4 pt-3 border-top">

    <a
        href="{{ route('incoming-letters.index') }}"
        class="btn btn-secondary">

        <i class="fas fa-arrow-left mr-1"></i>
        Kembali

    </a>

    <x-page.button
        color="primary"
        icon="fas fa-save"
        :title="isset($incomingLetter) ? 'Update' : 'Simpan'">

        {{ isset($incomingLetter) ? 'Update' : 'Simpan' }}

    </x-page.button>

</div>