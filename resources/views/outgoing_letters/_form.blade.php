<div class="col-md-8">

    <div class="form-group">

        <label>
            Nomor Surat <span class="text-danger">*</span>
        </label>

        <input
            type="text"
            name="letter_number"
            class="form-control @error('letter_number') is-invalid @enderror"
            value="{{ old('letter_number', $outgoingLetter->letter_number ?? '') }}"
            required>

        @error('letter_number')
            <span class="invalid-feedback">
                {{ $message }}
            </span>
        @enderror

    </div>

    <div class="form-group">

        <label>
            Tanggal Surat <span class="text-danger">*</span>
        </label>

        <input
            type="date"
            name="letter_date"
            class="form-control @error('letter_date') is-invalid @enderror"
            value="{{ old('letter_date', isset($outgoingLetter) ? $outgoingLetter->letter_date?->format('Y-m-d') : '') }}"
            required>

        @error('letter_date')
            <span class="invalid-feedback">
                {{ $message }}
            </span>
        @enderror

    </div>

    <div class="form-group">

        <label>
            Tujuan Surat <span class="text-danger">*</span>
        </label>

        <input
            type="text"
            name="recipient"
            class="form-control @error('recipient') is-invalid @enderror"
            value="{{ old('recipient', $outgoingLetter->recipient ?? '') }}"
            required>

        @error('recipient')
            <span class="invalid-feedback">
                {{ $message }}
            </span>
        @enderror

    </div>

    <div class="form-group">

        <label>
            Perihal <span class="text-danger">*</span>
        </label>

        <input
            type="text"
            name="regarding"
            class="form-control @error('regarding') is-invalid @enderror"
            value="{{ old('regarding', $outgoingLetter->regarding ?? '') }}"
            required>

        @error('regarding')
            <span class="invalid-feedback">
                {{ $message }}
            </span>
        @enderror

    </div>

    <div class="form-group">

        <label>
            Prioritas
        </label>

        <select
            name="priority"
            class="form-control @error('priority') is-invalid @enderror">

            @foreach([
                'Biasa',
                'Penting',
                'Segera',
                'Rahasia'
            ] as $priority)

                <option
                    value="{{ $priority }}"
                    @selected(
                        old(
                            'priority',
                            $outgoingLetter->priority ?? 'Biasa'
                        ) == $priority
                    )>

                    {{ $priority }}

                </option>

            @endforeach

        </select>

        @error('priority')
            <span class="invalid-feedback">
                {{ $message }}
            </span>
        @enderror

    </div>

    <div class="form-group">

        <label>
            Lampiran
        </label>

        <input
            type="text"
            name="attachment"
            class="form-control @error('attachment') is-invalid @enderror"
            value="{{ old('attachment', $outgoingLetter->attachment ?? '') }}">

        @error('attachment')
            <span class="invalid-feedback">
                {{ $message }}
            </span>
        @enderror

    </div>

    <div class="form-group">

        <label>
            Keterangan
        </label>

        <textarea
            name="description"
            rows="5"
            class="form-control @error('description') is-invalid @enderror">{{ old('description', $outgoingLetter->description ?? '') }}</textarea>

        @error('description')
            <span class="invalid-feedback">
                {{ $message }}
            </span>
        @enderror

    </div>

</div>

<div class="col-md-4">

    <div class="form-group">

        <label>
            File PDF
            @if(!isset($outgoingLetter))
                <span class="text-danger">*</span>
            @endif
        </label>

        <input
            type="file"
            name="file"
            class="form-control-file @error('file') is-invalid @enderror"
            accept=".pdf">

        @error('file')
            <span class="invalid-feedback d-block">
                {{ $message }}
            </span>
        @enderror

        @isset($outgoingLetter)

            @if($outgoingLetter->file)

                <div class="mt-3">

                    <a
                        href="{{ route('outgoing-letters.file', $outgoingLetter) }}"
                        target="_blank"
                        class="btn btn-info btn-block">

                        <i class="fas fa-eye mr-1"></i>
                        Lihat File Saat Ini

                    </a>

                </div>

                <small class="text-muted d-block mt-2">
                    Kosongkan jika tidak ingin mengganti file PDF.
                </small>

            @endif

        @endisset

    </div>

</div>