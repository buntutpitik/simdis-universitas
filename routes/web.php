<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IncomingLetterController;
use App\Http\Controllers\OutgoingLetterController;
use App\Http\Controllers\DispositionController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
    Route::get('/reports', [ReportController::class, 'index'])
        ->name('reports.index');
    Route::get('/reports/pdf', [ReportController::class, 'pdf'])
        ->name('reports.pdf');
    Route::get('/reports/excel', [ReportController::class, 'excel'])
        ->name('reports.excel');
    Route::get(
            'incoming-letters/{incomingLetter}/file',
            [IncomingLetterController::class, 'file']
        )->name('incoming-letters.file');

        Route::get(
            'outgoing-letters/{outgoingLetter}/file',
            [OutgoingLetterController::class, 'file']
        )->name('outgoing-letters.file');        
    Route::resource('positions', PositionController::class);  
    Route::resource('users', UserController::class);
    Route::resource('incoming-letters', IncomingLetterController::class);
    Route::resource('outgoing-letters', OutgoingLetterController::class);
    Route::put(
        'disposition-recipients/{recipient}/process',
        [DispositionController::class, 'process']
    )->name('disposition-recipients.process');
    Route::put(
        'disposition-recipients/{recipient}/complete',
        [DispositionController::class, 'complete']
    )->name('disposition-recipients.complete');
    Route::resource('dispositions', DispositionController::class);  

    
});

require __DIR__.'/auth.php';