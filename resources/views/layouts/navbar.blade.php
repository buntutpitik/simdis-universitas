<nav class="bg-white shadow px-6 py-4 flex justify-between items-center">

    <h1 class="text-xl font-bold">

        SIMDIS Universitas

    </h1>

    <div class="flex items-center gap-3">

        <span>

            {{ auth()->user()->full_name }}

        </span>

        <form method="POST" action="{{ route('logout') }}">

            @csrf

            <button
                class="bg-red-600 text-white px-3 py-2 rounded">

                Logout

            </button>

        </form>

    </div>

</nav>