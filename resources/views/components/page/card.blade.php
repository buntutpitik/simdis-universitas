@props([
    'title' => null,
    'icon' => null,
    'tools' => null,
    'footer' => null,
    'color' => 'primary',
])

<div {{ $attributes->merge([
    'class' => 'card shadow-sm border-0'
]) }}>

    @isset($title)

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <h3 class="card-title mb-0">

                @isset($icon)
                    <i class="{{ $icon }} text-{{ $color }} mr-2"></i>
                @endisset

                {{ $title }}

            </h3>

            @isset($tools)

                <div class="card-tools">

                    {{ $tools }}

                </div>

            @endisset

        </div>

    @endisset

    <div class="card-body">

        {{ $slot }}

    </div>

    @isset($footer)

        <div class="card-footer bg-white">

            {{ $footer }}

        </div>

    @endisset

</div>