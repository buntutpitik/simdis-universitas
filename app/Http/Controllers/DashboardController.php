<?php

namespace App\Http\Controllers;

use App\Models\Disposition;
use App\Models\IncomingLetter;
use App\Models\OutgoingLetter;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class DashboardController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(
                'permission:dashboard.view',
                only: ['index']
            ),
        ];
    }

    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Surat Masuk
        |--------------------------------------------------------------------------
        */

        $totalIncomingLetters = IncomingLetter::count();

        $incomingLettersThisMonth = IncomingLetter::whereMonth(
            'received_date',
            now()->month
        )
            ->whereYear('received_date', now()->year)
            ->count();

        $incomingLettersWithoutDisposition = IncomingLetter::doesntHave(
            'dispositions'
        )->count();

        $incomingLettersDisposed = IncomingLetter::where(
            'status',
            'Didisposisi'
        )->count();

        $incomingLettersCompleted = IncomingLetter::where(
            'status',
            'Selesai'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | Surat Keluar
        |--------------------------------------------------------------------------
        */

        $totalOutgoingLetters = OutgoingLetter::count();

        $outgoingLettersThisMonth = OutgoingLetter::whereMonth(
            'letter_date',
            now()->month
        )
            ->whereYear('letter_date', now()->year)
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Disposisi
        |--------------------------------------------------------------------------
        */

        $totalDispositions = Disposition::count();

        $newDispositions = Disposition::where(
            'status',
            'Baru'
        )->count();

        $processingDispositions = Disposition::where(
            'status',
            'Diproses'
        )->count();

        $completedDispositions = Disposition::where(
            'status',
            'Selesai'
        )->count();

        $activeDispositions = Disposition::where(
            'status',
            '!=',
            'Selesai'
        )->count();


        return view('dashboard.index', compact(
            'totalIncomingLetters',
            'incomingLettersThisMonth',
            'incomingLettersWithoutDisposition',
            'incomingLettersDisposed',
            'incomingLettersCompleted',

            'totalOutgoingLetters',
            'outgoingLettersThisMonth',

            'totalDispositions',
            'newDispositions',
            'processingDispositions',
            'completedDispositions',
            'activeDispositions'
        ));
    }
}