<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

use App\Models\IncomingLetter;
use App\Models\OutgoingLetter;
use App\Models\Disposition;

use Barryvdh\DomPDF\Facade\Pdf;

use App\Exports\ReportsExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:reports.view'),
        ];
    }

    /**
     * Menampilkan laporan administrasi persuratan.
     */
    public function index(Request $request)
    {
        $request->validate([
            'type' => [
                'nullable',
                'in:incoming,outgoing,disposition',
            ],

            'date_from' => [
                'nullable',
                'date',
            ],

            'date_to' => [
                'nullable',
                'date',
                'after_or_equal:date_from',
            ],

            'status' => [
                'nullable',
                'string',
            ],

            'priority' => [
                'nullable',
                'in:Biasa,Penting,Segera,Rahasia',
            ],
        ], [
            'type.in' => 'Jenis laporan tidak valid.',
            'date_from.date' => 'Tanggal awal tidak valid.',
            'date_to.date' => 'Tanggal akhir tidak valid.',
            'date_to.after_or_equal' => 'Tanggal akhir tidak boleh lebih awal dari tanggal awal.',
            'priority.in' => 'Prioritas tidak valid.',
        ]);

        $type = $request->input('type', 'incoming');

        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $status = $request->input('status');
        $priority = $request->input('priority');

        $data = $this->getReportData(
            $type,
            $dateFrom,
            $dateTo,
            $status,
            $priority
        );

        return view(
            'reports.index',
            compact(
                'type',
                'dateFrom',
                'dateTo',
                'status',
                'priority',
                'data'
            )
        );
    }

    /**
     * Export laporan ke PDF.
     */
    public function pdf(Request $request)
    {
        $request->validate([
            'type' => [
                'nullable',
                'in:incoming,outgoing,disposition',
            ],

            'date_from' => [
                'nullable',
                'date',
            ],

            'date_to' => [
                'nullable',
                'date',
                'after_or_equal:date_from',
            ],

            'status' => [
                'nullable',
                'string',
            ],

            'priority' => [
                'nullable',
                'in:Biasa,Penting,Segera,Rahasia',
            ],
        ], [
            'type.in' => 'Jenis laporan tidak valid.',
            'date_from.date' => 'Tanggal awal tidak valid.',
            'date_to.date' => 'Tanggal akhir tidak valid.',
            'date_to.after_or_equal' => 'Tanggal akhir tidak boleh lebih awal dari tanggal awal.',
            'priority.in' => 'Prioritas tidak valid.',
        ]);

        $type = $request->input('type', 'incoming');

        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $status = $request->input('status');
        $priority = $request->input('priority');

        $data = $this->getReportData(
            $type,
            $dateFrom,
            $dateTo,
            $status,
            $priority
        );

        $pdf = Pdf::loadView(
            'reports.pdf',
            compact(
                'type',
                'dateFrom',
                'dateTo',
                'status',
                'priority',
                'data'
            )
        )->setPaper('a4', 'landscape');

        return $pdf->download(
            'laporan-' .
            $type .
            '-' .
            now()->format('Ymd-His') .
            '.pdf'
        );
    }

    /**
     * Export laporan ke Excel.
     */

    public function excel(Request $request)
    {
        $request->validate([
            'type' => [
                'nullable',
                'in:incoming,outgoing,disposition',
            ],

            'date_from' => [
                'nullable',
                'date',
            ],

            'date_to' => [
                'nullable',
                'date',
                'after_or_equal:date_from',
            ],

            'status' => [
                'nullable',
                'string',
            ],

            'priority' => [
                'nullable',
                'in:Biasa,Penting,Segera,Rahasia',
            ],
        ], [
            'type.in' => 'Jenis laporan tidak valid.',
            'date_from.date' => 'Tanggal awal tidak valid.',
            'date_to.date' => 'Tanggal akhir tidak valid.',
            'date_to.after_or_equal' => 'Tanggal akhir tidak boleh lebih awal dari tanggal awal.',
            'priority.in' => 'Prioritas tidak valid.',
        ]);

        $type = $request->input('type', 'incoming');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $status = $request->input('status');
        $priority = $request->input('priority');

        $data = $this->getReportData(
            $type,
            $dateFrom,
            $dateTo,
            $status,
            $priority
        );

        return Excel::download(
            new ReportsExport(
                $type,
                $data
            ),
            'laporan-' .
            $type .
            '-' .
            now()->format('Ymd-His') .
            '.xlsx'
        );
    }

    /**
     * Mengambil data laporan berdasarkan filter.
     */
    private function getReportData(
        string $type,
        ?string $dateFrom,
        ?string $dateTo,
        ?string $status,
        ?string $priority
    ) {
        /*
        |--------------------------------------------------------------------------
        | Surat Masuk
        |--------------------------------------------------------------------------
        */

        if ($type === 'incoming') {

            return IncomingLetter::with('createdBy')

                ->when($dateFrom, function ($query) use ($dateFrom) {
                    $query->whereDate(
                        'received_date',
                        '>=',
                        $dateFrom
                    );
                })

                ->when($dateTo, function ($query) use ($dateTo) {
                    $query->whereDate(
                        'received_date',
                        '<=',
                        $dateTo
                    );
                })

                ->when($status, function ($query) use ($status) {
                    $query->where(
                        'status',
                        $status
                    );
                })

                ->when($priority, function ($query) use ($priority) {
                    $query->where(
                        'priority',
                        $priority
                    );
                })

                ->orderByDesc('received_date')

                ->get();
        }

        /*
        |--------------------------------------------------------------------------
        | Surat Keluar
        |--------------------------------------------------------------------------
        */

        if ($type === 'outgoing') {

            return OutgoingLetter::with('createdBy')

                ->when($dateFrom, function ($query) use ($dateFrom) {
                    $query->whereDate(
                        'letter_date',
                        '>=',
                        $dateFrom
                    );
                })

                ->when($dateTo, function ($query) use ($dateTo) {
                    $query->whereDate(
                        'letter_date',
                        '<=',
                        $dateTo
                    );
                })

                ->when($priority, function ($query) use ($priority) {
                    $query->where(
                        'priority',
                        $priority
                    );
                })

                ->orderByDesc('letter_date')

                ->get();
        }

        /*
        |--------------------------------------------------------------------------
        | Disposisi
        |--------------------------------------------------------------------------
        */

        if ($type === 'disposition') {

            return Disposition::with([
                'incomingLetter',
                'createdBy',
                'recipients',
            ])

                ->when($dateFrom, function ($query) use ($dateFrom) {
                    $query->whereDate(
                        'created_at',
                        '>=',
                        $dateFrom
                    );
                })

                ->when($dateTo, function ($query) use ($dateTo) {
                    $query->whereDate(
                        'created_at',
                        '<=',
                        $dateTo
                    );
                })

                ->when($status, function ($query) use ($status) {
                    $query->where(
                        'status',
                        $status
                    );
                })

                ->when($priority, function ($query) use ($priority) {
                    $query->where(
                        'priority',
                        $priority
                    );
                })

                ->orderByDesc('created_at')

                ->get();
        }

        return collect();
    }
}