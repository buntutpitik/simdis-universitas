@extends('layouts.app')

@section('content')

<div class="container-fluid">

    {{-- =========================================================
         RINGKASAN UTAMA
    ========================================================== --}}

    <div class="row">

        {{-- Surat Masuk --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $totalIncomingLetters }}</h3>
                    <p>Total Surat Masuk</p>
                </div>

                <div class="icon">
                    <i class="fas fa-envelope"></i>
                </div>

                <a href="{{ route('incoming-letters.index') }}"
                   class="small-box-footer">
                    Lihat Surat Masuk
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>


        {{-- Surat Keluar --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalOutgoingLetters }}</h3>
                    <p>Total Surat Keluar</p>
                </div>

                <div class="icon">
                    <i class="fas fa-paper-plane"></i>
                </div>

                <a href="{{ route('outgoing-letters.index') }}"
                   class="small-box-footer">
                    Lihat Surat Keluar
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>


        {{-- Total Disposisi --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $totalDispositions }}</h3>
                    <p>Total Disposisi</p>
                </div>

                <div class="icon">
                    <i class="fas fa-share"></i>
                </div>

                <a href="{{ route('dispositions.index') }}"
                   class="small-box-footer">
                    Lihat Disposisi
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>


        {{-- Disposisi Aktif --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $activeDispositions }}</h3>
                    <p>Disposisi Aktif</p>
                </div>

                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>

                <a href="{{ route('dispositions.index') }}"
                   class="small-box-footer">
                    Lihat Disposisi
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

    </div>


    {{-- =========================================================
         STATISTIK BULAN INI
    ========================================================== --}}

    <div class="row">

        {{-- Surat Masuk Bulan Ini --}}
        <div class="col-md-6">
            <div class="info-box">
                <span class="info-box-icon bg-primary">
                    <i class="fas fa-envelope"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">
                        Surat Masuk Bulan Ini
                    </span>

                    <span class="info-box-number">
                        {{ $incomingLettersThisMonth }}
                    </span>
                </div>
            </div>
        </div>


        {{-- Surat Keluar Bulan Ini --}}
        <div class="col-md-6">
            <div class="info-box">
                <span class="info-box-icon bg-success">
                    <i class="fas fa-paper-plane"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">
                        Surat Keluar Bulan Ini
                    </span>

                    <span class="info-box-number">
                        {{ $outgoingLettersThisMonth }}
                    </span>
                </div>
            </div>
        </div>

    </div>


    {{-- =========================================================
         STATUS SURAT MASUK & DISPOSISI
    ========================================================== --}}

    <div class="row">

        {{-- Status Surat Masuk --}}
        <div class="col-md-6">

            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-envelope mr-2"></i>
                        Status Surat Masuk
                    </h3>
                </div>

                <div class="card-body">

                    <div class="row">

                        {{-- Tanpa Disposisi --}}
                        <div class="col-md-4">
                            <div class="info-box mb-3">

                                <span class="info-box-icon bg-secondary">
                                    <i class="fas fa-inbox"></i>
                                </span>

                                <div class="info-box-content">
                                    <span class="info-box-text">
                                        Belum Disposisi
                                    </span>

                                    <span class="info-box-number">
                                        {{ $incomingLettersWithoutDisposition }}
                                    </span>
                                </div>

                            </div>
                        </div>


                        {{-- Didisposisi --}}
                        <div class="col-md-4">
                            <div class="info-box mb-3">

                                <span class="info-box-icon bg-warning">
                                    <i class="fas fa-share"></i>
                                </span>

                                <div class="info-box-content">
                                    <span class="info-box-text">
                                        Didisposisi
                                    </span>

                                    <span class="info-box-number">
                                        {{ $incomingLettersDisposed }}
                                    </span>
                                </div>

                            </div>
                        </div>


                        {{-- Selesai --}}
                        <div class="col-md-4">
                            <div class="info-box mb-3">

                                <span class="info-box-icon bg-success">
                                    <i class="fas fa-check"></i>
                                </span>

                                <div class="info-box-content">
                                    <span class="info-box-text">
                                        Selesai
                                    </span>

                                    <span class="info-box-number">
                                        {{ $incomingLettersCompleted }}
                                    </span>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Status Disposisi --}}
        <div class="col-md-6">

            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-share mr-2"></i>
                        Status Disposisi
                    </h3>
                </div>

                <div class="card-body">

                    <div class="row">

                        {{-- Baru --}}
                        <div class="col-md-4">
                            <div class="info-box mb-3">

                                <span class="info-box-icon bg-primary">
                                    <i class="fas fa-file"></i>
                                </span>

                                <div class="info-box-content">
                                    <span class="info-box-text">
                                        Baru
                                    </span>

                                    <span class="info-box-number">
                                        {{ $newDispositions }}
                                    </span>
                                </div>

                            </div>
                        </div>


                        {{-- Diproses --}}
                        <div class="col-md-4">
                            <div class="info-box mb-3">

                                <span class="info-box-icon bg-warning">
                                    <i class="fas fa-spinner"></i>
                                </span>

                                <div class="info-box-content">
                                    <span class="info-box-text">
                                        Diproses
                                    </span>

                                    <span class="info-box-number">
                                        {{ $processingDispositions }}
                                    </span>
                                </div>

                            </div>
                        </div>


                        {{-- Selesai --}}
                        <div class="col-md-4">
                            <div class="info-box mb-3">

                                <span class="info-box-icon bg-success">
                                    <i class="fas fa-check-circle"></i>
                                </span>

                                <div class="info-box-content">
                                    <span class="info-box-text">
                                        Selesai
                                    </span>

                                    <span class="info-box-number">
                                        {{ $completedDispositions }}
                                    </span>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         INFORMASI SINGKAT
    ========================================================== --}}

    <div class="row">

        <div class="col-12">

            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle mr-2"></i>
                        Ringkasan Sistem
                    </h3>
                </div>

                <div class="card-body">

                    <p class="mb-2">
                        Selamat datang di
                        <strong>SIMDIS Universitas</strong>.
                    </p>

                    <p class="text-muted mb-0">
                        Dashboard menampilkan ringkasan administrasi
                        persuratan berdasarkan data yang tersimpan
                        dalam sistem.
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection