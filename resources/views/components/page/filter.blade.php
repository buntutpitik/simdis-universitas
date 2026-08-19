@props([
    'action',
    'reset',
    'method' => 'GET',
])

<form
    action="{{ $action }}"
    method="{{ strtoupper($method) === 'GET' ? 'GET' : 'POST' }}">

    @if(strtoupper($method) !== 'GET')
        @csrf
        @method($method)
    @endif

    <div class="row">

        <div class="col-lg-5 col-md-12 mb-2">

            {{ $slot }}

        </div>

        <div class="col-lg-3 col-md-12 mb-2">

            <div class="d-flex">

                <button
                    type="submit"
                    class="btn btn-primary mr-2">

                    <i class="fas fa-search mr-1"></i>
                    Cari

                </button>

                <a
                    href="{{ $reset }}"
                    class="btn btn-secondary">

                    <i class="fas fa-sync-alt mr-1"></i>
                    Reset

                </a>

            </div>

        </div>

        <div class="col-lg-4 col-md-12 mb-2 text-lg-right">

            {{ $actions ?? '' }}

        </div>

    </div>

</form>