@extends('adminlte::page')

@section('title', 'Detail Surat Masuk')

@section('content')

<x-page.header
    title="Detail Surat Masuk"
    subtitle="Informasi lengkap surat masuk" />

<x-page.actions>

    <x-page.button
        color="secondary"
        icon="fas fa-arrow-left"
        :href="route('incoming-letters.index')">

        Kembali

    </x-page.button>

    @if($incomingLetter->file)

        <x-page.button
            color="info"
            icon="fas fa-eye"
            :href="route('incoming-letters.file', $incomingLetter)"
            target="_blank">

            Lihat PDF

        </x-page.button>

        <x-page.button
            color="success"
            icon="fas fa-download"
            :href="route('incoming-letters.file', $incomingLetter)"
            download>

            Download

        </x-page.button>

    @endif

    @if(
        auth()->user()->can('incoming.edit')
        && $incomingLetter->status === 'Baru'
    )

        <x-page.button
            color="warning"
            icon="fas fa-edit"
            :href="route('incoming-letters.edit', $incomingLetter)">

            Edit

        </x-page.button>

    @endif

    @if(
        $incomingLetter->status === 'Baru'
        && auth()->user()->can('disposition.create')
    )

        <x-page.button
            color="primary"
            icon="fas fa-share"
            :href="route('dispositions.create', ['incoming_letter_id' => $incomingLetter->id])">

            Buat Disposisi

        </x-page.button>

    @endif

</x-page.actions>

<div class="row">

    <div class="col-md-8">

        <x-page.card
            title="Informasi Surat"
            icon="fas fa-envelope-open-text">

            <x-page.description-table>

                <x-page.description-row
                    label="Nomor Agenda"
                    :value="$incomingLetter->agenda_number" />

                <x-page.description-row
                    label="Nomor Surat"
                    :value="$incomingLetter->letter_number" />

                <x-page.description-row
                    label="Tanggal Surat"
                    :value="$incomingLetter->letter_date?->translatedFormat('d F Y')" />

                <x-page.description-row
                    label="Tanggal Diterima"
                    :value="$incomingLetter->received_date?->translatedFormat('d F Y')" />

                <x-page.description-row
                    label="Pengirim"
                    :value="$incomingLetter->sender" />

                <x-page.description-row
                    label="Perihal"
                    :value="$incomingLetter->regarding" />

                <x-page.description-row label="Prioritas">

                    <x-page.badge.priority
                        :value="$incomingLetter->priority" />

                </x-page.description-row>

                <x-page.description-row label="Status">

                    <x-page.badge.status
                        :value="$incomingLetter->status" />

                </x-page.description-row>

                <x-page.description-row
                    label="Lampiran"
                    :value="$incomingLetter->attachment ?: '-'" />

                <x-page.description-row
                    label="Keterangan"
                    :value="$incomingLetter->description ?: '-'" />

            </x-page.description-table>

        </x-page.card>

    </div>

    <div class="col-md-4">

        <x-page.card
            title="Informasi Penginput"
            icon="fas fa-user">

            <x-page.description-table>

                <x-page.description-row label="Nama">

                    <x-page.user-info
                        :user="$incomingLetter->createdBy" />

                </x-page.description-row>

                <x-page.description-row
                    label="Role Sistem"
                    :value="$incomingLetter->createdBy?->getRoleNames()->first() ?? '-'" />

                <x-page.description-row
                    label="Tanggal Input"
                    :value="$incomingLetter->created_at?->translatedFormat('d F Y H:i')" />

                <x-page.description-row
                    label="Terakhir Diubah"
                    :value="$incomingLetter->updated_at?->translatedFormat('d F Y H:i')" />

            </x-page.description-table>

        </x-page.card>

    </div>

</div>

@stop