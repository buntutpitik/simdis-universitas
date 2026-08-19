<x-guest-layout>

    <div class="mb-6">

        <h2 class="text-xl font-semibold text-slate-800">
            Masuk ke Sistem
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            Silakan masuk menggunakan akun SIMDIS Anda.
        </p>

    </div>

    <x-auth-session-status
        class="mb-4"
        :status="session('status')" />

    <form
        method="POST"
        action="{{ route('login') }}">

        @csrf

        <div>

            <x-input-label
                for="email"
                value="Email" />

            <x-text-input
                id="email"
                class="mt-1 block w-full"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                autocomplete="username"
                placeholder="Masukkan email" />

            <x-input-error
                :messages="$errors->get('email')"
                class="mt-2" />

        </div>

        <div class="mt-5">

            <x-input-label
                for="password"
                value="Password" />

            <x-text-input
                id="password"
                class="mt-1 block w-full"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="Masukkan password" />

            <x-input-error
                :messages="$errors->get('password')"
                class="mt-2" />

        </div>

        <div class="mt-5">

            <label
                for="remember_me"
                class="inline-flex items-center">

                <input
                    id="remember_me"
                    type="checkbox"
                    class="rounded border-gray-300 text-slate-700 shadow-sm focus:ring-slate-500"
                    name="remember">

                <span class="ms-2 text-sm text-slate-600">
                    Ingat saya
                </span>

            </label>

        </div>

        <div class="mt-6">

            <button
                type="submit"
                class="w-full rounded-lg bg-slate-800 px-4 py-3 text-sm font-semibold text-white transition hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2">

                MASUK

            </button>

        </div>

    </form>

</x-guest-layout>