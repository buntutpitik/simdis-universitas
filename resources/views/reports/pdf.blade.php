<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <title>Laporan SIMDIS Universitas</title>

    <style>

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #222;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
            font-size: 18px;
        }

        .header p {
            margin: 4px 0 0;
            font-size: 11px;
            color: #555;
        }

        .filter-info {
            margin-bottom: 15px;
        }

        .filter-info table {
            width: auto;
            border-collapse: collapse;
        }

        .filter-info td {
            padding: 2px 8px 2px 0;
            border: none;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
        }

        .report-table th {
            background: #eeeeee;
            border: 1px solid #555;
            padding: 6px;
            text-align: center;
            font-weight: bold;
        }

        .report-table td {
            border: 1px solid #777;
            padding: 5px;
            vertical-align: top;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 15px;
            font-size: 10px;
            color: #555;
        }

    </style>

</head>

<body>

    <div class="header">

        <h2>
            LAPORAN ADMINISTRASI PERSURATAN
        </h2>

        <p>
            SIMDIS Universitas
        </p>

    </div>


    <div class="filter-info">

        <table>

            <tr>
                <td>
                    <strong>Jenis Laporan</strong>
                </td>

                <td>
                    :
                    @if($type === 'incoming')
                        Surat Masuk
                    @elseif($type === 'outgoing')
                        Surat Keluar
                    @elseif($type === 'disposition')
                        Disposisi
                    @endif
                </td>
            </tr>


            <tr>
                <td>
                    <strong>Periode</strong>
                </td>

                <td>
                    :
                    {{ $dateFrom ?: 'Semua tanggal' }}

                    @if($dateFrom || $dateTo)
                        s/d
                        {{ $dateTo ?: 'Sekarang' }}
                    @endif
                </td>
            </tr>


            @if($type !== 'outgoing')

                <tr>
                    <td>
                        <strong>Status</strong>
                    </td>

                    <td>
                        :
                        {{ $status ?: 'Semua Status' }}
                    </td>
                </tr>

            @endif


            <tr>
                <td>
                    <strong>Prioritas</strong>
                </td>

                <td>
                    :
                    {{ $priority ?: 'Semua Prioritas' }}
                </td>
            </tr>

        </table>

    </div>


    {{-- =========================================================
         SURAT MASUK
    ========================================================== --}}

    @if($type === 'incoming')

        <table class="report-table">

            <thead>

                <tr>

                    <th width="4%">
                        No
                    </th>

                    <th width="12%">
                        Agenda
                    </th>

                    <th width="16%">
                        Nomor Surat
                    </th>

                    <th width="11%">
                        Tanggal Terima
                    </th>

                    <th width="17%">
                        Pengirim
                    </th>

                    <th>
                        Perihal
                    </th>

                    <th width="9%">
                        Prioritas
                    </th>

                    <th width="10%">
                        Status
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($data as $letter)

                    <tr>

                        <td class="text-center">
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            {{ $letter->agenda_number }}
                        </td>

                        <td>
                            {{ $letter->letter_number }}
                        </td>

                        <td class="text-center">
                            {{ $letter->received_date?->format('d-m-Y') ?? '-' }}
                        </td>

                        <td>
                            {{ $letter->sender }}
                        </td>

                        <td>
                            {{ $letter->regarding }}
                        </td>

                        <td class="text-center">
                            {{ $letter->priority }}
                        </td>

                        <td class="text-center">
                            {{ $letter->status }}
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="8"
                            class="text-center">

                            Tidak ada data surat masuk.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>


    {{-- =========================================================
         SURAT KELUAR
    ========================================================== --}}

    @elseif($type === 'outgoing')

        <table class="report-table">

            <thead>

                <tr>

                    <th width="4%">
                        No
                    </th>

                    <th width="13%">
                        Agenda
                    </th>

                    <th width="17%">
                        Nomor Surat
                    </th>

                    <th width="11%">
                        Tanggal Surat
                    </th>

                    <th width="20%">
                        Tujuan
                    </th>

                    <th>
                        Perihal
                    </th>

                    <th width="10%">
                        Prioritas
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($data as $letter)

                    <tr>

                        <td class="text-center">
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            {{ $letter->agenda_number }}
                        </td>

                        <td>
                            {{ $letter->letter_number }}
                        </td>

                        <td class="text-center">
                            {{ $letter->letter_date?->format('d-m-Y') ?? '-' }}
                        </td>

                        <td>
                            {{ $letter->recipient }}
                        </td>

                        <td>
                            {{ $letter->regarding }}
                        </td>

                        <td class="text-center">
                            {{ $letter->priority }}
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="7"
                            class="text-center">

                            Tidak ada data surat keluar.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>


    {{-- =========================================================
         DISPOSISI
    ========================================================== --}}

    @elseif($type === 'disposition')

        <table class="report-table">

            <thead>

                <tr>

                    <th width="4%">
                        No
                    </th>

                    <th width="12%">
                        Agenda
                    </th>

                    <th width="15%">
                        Nomor Surat
                    </th>

                    <th width="16%">
                        Pengirim
                    </th>

                    <th>
                        Perihal
                    </th>

                    <th width="9%">
                        Prioritas
                    </th>

                    <th width="9%">
                        Status
                    </th>

                    <th width="10%">
                        Tanggal
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($data as $disposition)

                    <tr>

                        <td class="text-center">
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            {{ $disposition->incomingLetter?->agenda_number ?? '-' }}
                        </td>

                        <td>
                            {{ $disposition->incomingLetter?->letter_number ?? '-' }}
                        </td>

                        <td>
                            {{ $disposition->incomingLetter?->sender ?? '-' }}
                        </td>

                        <td>
                            {{ $disposition->incomingLetter?->regarding ?? '-' }}
                        </td>

                        <td class="text-center">
                            {{ $disposition->priority }}
                        </td>

                        <td class="text-center">
                            {{ $disposition->status }}
                        </td>

                        <td class="text-center">
                            {{ $disposition->created_at?->format('d-m-Y') ?? '-' }}
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="8"
                            class="text-center">

                            Tidak ada data disposisi.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    @endif


    <div class="footer">

        Total data:
        <strong>{{ $data->count() }}</strong>

        <br>

        Dicetak:
        {{ now()->format('d-m-Y H:i') }}

    </div>

</body>
</html>