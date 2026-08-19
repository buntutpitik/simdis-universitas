<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportsExport implements FromCollection, WithHeadings
{
    protected string $type;

    protected Collection $data;

    public function __construct(
        string $type,
        Collection $data
    ) {
        $this->type = $type;
        $this->data = $data;
    }

    /**
     * Data yang akan diexport.
     */
    public function collection(): Collection
    {
        /*
        |--------------------------------------------------------------------------
        | Surat Masuk
        |--------------------------------------------------------------------------
        */

        if ($this->type === 'incoming') {

            return $this->data
                ->values()
                ->map(function ($letter, $index) {

                    return [
                        'no' => $index + 1,
                        'agenda_number' => $letter->agenda_number,
                        'letter_number' => $letter->letter_number,
                        'received_date' => $letter->received_date
                            ?->format('d-m-Y') ?? '-',
                        'sender' => $letter->sender,
                        'regarding' => $letter->regarding,
                        'priority' => $letter->priority,
                        'status' => $letter->status,
                    ];

                });
        }

        /*
        |--------------------------------------------------------------------------
        | Surat Keluar
        |--------------------------------------------------------------------------
        */

        if ($this->type === 'outgoing') {

            return $this->data
                ->values()
                ->map(function ($letter, $index) {

                    return [
                        'no' => $index + 1,
                        'agenda_number' => $letter->agenda_number,
                        'letter_number' => $letter->letter_number,
                        'letter_date' => $letter->letter_date
                            ?->format('d-m-Y') ?? '-',
                        'recipient' => $letter->recipient,
                        'regarding' => $letter->regarding,
                        'priority' => $letter->priority,
                    ];

                });
        }

        /*
        |--------------------------------------------------------------------------
        | Disposisi
        |--------------------------------------------------------------------------
        */

        if ($this->type === 'disposition') {

            return $this->data
                ->values()
                ->map(function ($disposition, $index) {

                    return [
                        'no' => $index + 1,
                        'agenda_number' =>
                            $disposition->incomingLetter?->agenda_number ?? '-',

                        'letter_number' =>
                            $disposition->incomingLetter?->letter_number ?? '-',

                        'sender' =>
                            $disposition->incomingLetter?->sender ?? '-',

                        'regarding' =>
                            $disposition->incomingLetter?->regarding ?? '-',

                        'priority' => $disposition->priority,

                        'status' => $disposition->status,

                        'date' => $disposition->created_at
                            ?->format('d-m-Y') ?? '-',
                    ];

                });
        }

        return collect();
    }

    /**
     * Header kolom Excel.
     */
    public function headings(): array
    {
        if ($this->type === 'incoming') {

            return [
                'No',
                'Nomor Agenda',
                'Nomor Surat',
                'Tanggal Terima',
                'Pengirim',
                'Perihal',
                'Prioritas',
                'Status',
            ];
        }

        if ($this->type === 'outgoing') {

            return [
                'No',
                'Nomor Agenda',
                'Nomor Surat',
                'Tanggal Surat',
                'Tujuan',
                'Perihal',
                'Prioritas',
            ];
        }

        if ($this->type === 'disposition') {

            return [
                'No',
                'Nomor Agenda',
                'Nomor Surat',
                'Pengirim',
                'Perihal',
                'Prioritas',
                'Status',
                'Tanggal',
            ];
        }

        return [];
    }
}