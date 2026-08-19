@props([
    'title',
    'subtitle' => null,
])

<div class="d-flex justify-content-between align-items-center flex-wrap mb-3">

    <div>

        <h3 class="mb-0">

            {{ $title }}

        </h3>

        @isset($subtitle)

            <small class="text-muted">

                {{ $subtitle }}

            </small>

        @endisset

    </div>

    @isset($actions)

        <div class="mt-2 mt-md-0">

            {{ $actions }}

        </div>

    @endisset

</div>