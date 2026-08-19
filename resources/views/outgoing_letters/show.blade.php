@extends('adminlte::page')

@section('title', 'Detail Surat Keluar')

@section('content')

<x-page.header
    title="Detail Surat Keluar"
    subtitle="Informasi lengkap surat keluar" />

<x-page.actions>

    <x-page.button
        color="secondary"
        icon="fas fa-arrow-left"
        :href="route('outgoing-letters.index')">

        Kembali

    </x-page.button>

    @if($outgoingLetter->file)

        <x-page.button
            color="info"
            icon="fas fa-eye"
            :href="route('outgoing-letters.file', $outgoingLetter)"
            target="_blank">

            Lihat PDF

        </x-page.button>

        <a
            href="{{ route('outgoing-letters.file', $outgoingLetter) }}"
            download
            class="btn btn-success btn-xs">

            <i class="fas fa-download mr-1"></i>
            Download

        </a>

    @endif

    @if(auth()->user()->can('outgoing.edit'))

        <x-page.button
            color="warning"
            icon="fas fa-edit"
            :href="route('outgoing-letters.edit', $outgoingLetter)">

            Edit

        </x-page.button>

    @endif

</x-page.actions>


<div class="row">

    <div class="col-md-8">

        <x-page.card
            title="Informasi Surat"
            icon="fas fa-paper-plane">

            <x-page.description-table>

                <x-page.description-row
                    label="Nomor Agenda"
                    :value="$outgoingLetter->agenda_number" />

                <x-page.description-row
                    label="Nomor Surat"
                    :value="$outgoingLetter->letter_number" />

                <x-page.description-row
                    label="Tanggal Surat"
                    :value="$outgoingLetter->letter_date?->translatedFormat('d F Y')" />

                <x-page.description-row
                    label="Tujuan"
                    :value="$outgoingLetter->recipient" />

                <x-page.description-row
                    label="Perihal"
                    :value="$outgoingLetter->regarding" />

                <x-page.description-row label="Prioritas">

                    <x-page.badge.priority
                        :value="$outgoingLetter->priority" />

                </x-page.description-row>

                <x-page.description-row
                    label="Lampiran"
                    :value="$outgoingLetter->attachment ?: '-'" />

                <x-page.description-row
                    label="Keterangan"
                    :value="$outgoingLetter->description ?: '-'" />

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
                        :user="$outgoingLetter->createdBy" />

                </x-page.description-row>

                <x-page.description-row
                    label="Role Sistem"
                    :value="$outgoingLetter->createdBy?->getRoleNames()->first() ?? '-'" />

                <x-page.description-row
                    label="Tanggal Input"
                    :value="$outgoingLetter->created_at?->translatedFormat('d F Y H:i')" />

                <x-page.description-row
                    label="Terakhir Diubah"
                    :value="$outgoingLetter->updated_at?->translatedFormat('d F Y H:i')" />

            </x-page.description-table>

        </x-page.card>

    </div>

</div>

@stop