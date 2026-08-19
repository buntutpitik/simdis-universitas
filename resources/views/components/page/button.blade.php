@props([
    'href' => null,
    'color' => 'primary',
    'icon' => null,
    'size' => 'xs',
    'title' => null,
    'target' => null,
])

@if($href)

    <a
        href="{{ $href }}"
        {{ $attributes->except('download')->merge([
            'class' => 'btn btn-'.$color.' btn-'.$size.' shadow-sm',
        ]) }}
        @if($target) target="{{ $target }}" @endif
        @if($attributes->has('download')) download @endif
        title="{{ $title }}">

        @isset($icon)
            <i class="{{ $icon }}"></i>
        @endisset

        {{ $slot }}

    </a>

@else

    <button
        type="submit"
        {{ $attributes->merge([
            'class' => 'btn btn-'.$color.' btn-'.$size.' shadow-sm',
        ]) }}
        title="{{ $title }}">

        @isset($icon)
            <i class="{{ $icon }}"></i>
        @endisset

        {{ $slot }}

    </button>

@endif