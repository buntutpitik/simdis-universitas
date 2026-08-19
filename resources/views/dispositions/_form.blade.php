<div class="col-md-8">

    <x-page.card
        title="Data Disposisi"
        icon="fas fa-share">

        {{-- Surat Masuk --}}
        <div class="form-group">

            <label>
                Surat Masuk
            </label>

            <select
                name="incoming_letter_id"
                class="form-control @error('incoming_letter_id') is-invalid @enderror">

                <option value="">
                    -- Pilih Surat Masuk --
                </option>

                @foreach($incomingLetters as $letter)

                    <option
                        value="{{ $letter->id }}"
                        @selected(
                            old(
                                'incoming_letter_id',
                                $disposition->incoming_letter_id
                                    ?? $selectedIncomingLetterId
                                    ?? ''
                            ) == $letter->id
                        )>

                        {{ $letter->agenda_number }}
                        -
                        {{ $letter->letter_number }}
                        -
                        {{ $letter->sender }}

                    </option>

                @endforeach

            </select>

            @error('incoming_letter_id')

                <span class="invalid-feedback">
                    {{ $message }}
                </span>

            @enderror

        </div>

        {{-- Penerima --}}
        <div class="form-group">

            <label>
                Penerima Disposisi
            </label>

            <select
                name="recipient_ids[]"
                class="form-control @error('recipient_ids') is-invalid @enderror"
                multiple
                size="6">

                @foreach($users as $user)

                    <option
                        value="{{ $user->id }}"
                        @selected(
                            in_array(
                                $user->id,
                                old(
                                    'recipient_ids',
                                    $selectedRecipientIds ?? []
                                )
                            )
                        )>

                        {{ $user->full_name }}

                        @if($user->position)

                            - {{ $user->position->name }}

                        @endif

                    </option>

                @endforeach

            </select>

            <small class="form-text text-muted">
                Tekan Ctrl sambil klik untuk memilih beberapa penerima.
            </small>

            @error('recipient_ids')

                <span class="invalid-feedback">
                    {{ $message }}
                </span>

            @enderror

            @error('recipient_ids.*')

                <span class="invalid-feedback d-block">
                    {{ $message }}
                </span>

            @enderror

        </div>

        {{-- Instruksi --}}
        <div class="form-group">

            <label>
                Instruksi
            </label>

            <textarea
                name="instruction"
                rows="4"
                class="form-control @error('instruction') is-invalid @enderror"
                placeholder="Masukkan instruksi disposisi...">{{ old('instruction', $disposition->instruction ?? '') }}</textarea>

            @error('instruction')

                <span class="invalid-feedback">
                    {{ $message }}
                </span>

            @enderror

        </div>

        {{-- Catatan --}}
        <div class="form-group">

            <label>
                Catatan
            </label>

            <textarea
                name="note"
                rows="3"
                class="form-control @error('note') is-invalid @enderror"
                placeholder="Masukkan catatan jika diperlukan...">{{ old('note', $disposition->note ?? '') }}</textarea>

            @error('note')

                <span class="invalid-feedback">
                    {{ $message }}
                </span>

            @enderror

        </div>

    </x-page.card>

</div>

<div class="col-md-4">

    <x-page.card
        title="Pengaturan Disposisi"
        icon="fas fa-cog">

        {{-- Prioritas --}}
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
                                $disposition->priority ?? 'Biasa'
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

        {{-- Deadline --}}
        <div class="form-group">

            <label>
                Batas Waktu
            </label>

            <input
                type="date"
                name="deadline"
                class="form-control @error('deadline') is-invalid @enderror"
                value="{{ old(
                    'deadline',
                    isset($disposition)
                        ? $disposition->deadline?->format('Y-m-d')
                        : ''
                ) }}">

            @error('deadline')

                <span class="invalid-feedback">
                    {{ $message }}
                </span>

            @enderror

        </div>

        {{-- Status --}}
        <div class="form-group">

            <label>
                Status
            </label>

            <select
                name="status"
                class="form-control @error('status') is-invalid @enderror">

                @foreach([
                    'Baru',
                    'Diproses',
                    'Selesai'
                ] as $status)

                    <option
                        value="{{ $status }}"
                        @selected(
                            old(
                                'status',
                                $disposition->status ?? 'Baru'
                            ) == $status
                        )>

                        {{ $status }}

                    </option>

                @endforeach

            </select>

            @error('status')

                <span class="invalid-feedback">
                    {{ $message }}
                </span>

            @enderror

        </div>

    </x-page.card>

</div>
