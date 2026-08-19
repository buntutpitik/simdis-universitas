<aside class="w-64 bg-slate-800 text-white min-h-screen">

    <div class="p-5 text-2xl font-bold">
        SIMDIS
    </div>

    <nav class="px-4">

        <ul class="space-y-2">

            {{-- Dashboard --}}
            @can('dashboard.view')

                <li>
                    <a href="{{ route('dashboard') }}">
                        Dashboard
                    </a>
                </li>

            @endcan


            {{-- Master Data --}}
            @canany(['positions.view', 'users.view'])

                <li>
                    <span>
                        Master Data
                    </span>

                    <ul class="ml-4 mt-2 space-y-2">

                        @can('positions.view')

                            <li>
                                <a href="{{ route('positions.index') }}">
                                    Jabatan
                                </a>
                            </li>

                        @endcan


                        @can('users.view')

                            <li>
                                <a href="{{ route('users.index') }}">
                                    User
                                </a>
                            </li>

                        @endcan

                    </ul>

                </li>

            @endcanany


            {{-- Surat Masuk --}}
            @can('incoming.view')

                <li>
                    <a href="{{ route('incoming-letters.index') }}">
                        Surat Masuk
                    </a>
                </li>

            @endcan


            {{-- Surat Keluar --}}
            @can('outgoing.view')

                <li>
                    <a href="{{ route('outgoing-letters.index') }}">
                        Surat Keluar
                    </a>
                </li>

            @endcan


            {{-- Disposisi --}}
            @can('disposition.view')

                <li>
                    <a href="{{ route('dispositions.index') }}">
                        Disposisi
                    </a>
                </li>

            @endcan


            {{-- Laporan --}}
            @can('reports.view')

                <li>
                    <a href="{{ route('reports.index') }}">
                        Laporan
                    </a>
                </li>

            @endcan

        </ul>

    </nav>

</aside>