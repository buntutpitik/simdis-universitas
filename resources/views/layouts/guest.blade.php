<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1">

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}">

    <title>
        SIMDIS Universitas
    </title>

    <link
        rel="icon"
        type="image/x-icon"
        href="{{ asset('favicon.ico') }}">

    <link
        rel="preconnect"
        href="https://fonts.bunny.net">

    <link
        href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap"
        rel="stylesheet" />

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>

<body class="font-sans antialiased">

    <div
        class="min-h-screen flex items-center justify-center bg-slate-100 px-4">

        <div class="w-full max-w-md">

            {{-- Branding --}}
            <div class="text-center mb-6">

                <div
                    class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-800 text-white shadow-lg">

                    <span class="text-xl font-bold">
                        SD
                    </span>

                </div>

                <h1 class="mt-4 text-2xl font-bold text-slate-800">
                    SIMDIS Universitas
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Sistem Informasi Manajemen Disposisi Surat
                </p>

            </div>


            {{-- Login Card --}}
            <div
                class="overflow-hidden rounded-2xl bg-white px-7 py-7 shadow-lg">

                {{ $slot }}

            </div>


            {{-- Footer --}}
            <div
                class="mt-6 text-center text-xs text-slate-400">

                SIMDIS Universitas
                &copy; {{ date('Y') }}

            </div>

        </div>

    </div>

</body>

</html>