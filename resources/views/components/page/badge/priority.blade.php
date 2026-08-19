@props(['value'])

@php
    $config = match($value) {
        'Rahasia' => [
            'color' => 'danger',
            'icon'  => 'fas fa-lock',
            'text'  => 'Rahasia',
        ],

        'Segera' => [
            'color' => 'warning',
            'icon'  => 'fas fa-bolt',
            'text'  => 'Segera',
        ],

        'Penting' => [
            'color' => 'info',
            'icon'  => 'fas fa-exclamation-circle',
            'text'  => 'Penting',
        ],

        default => [
            'color' => 'secondary',
            'icon'  => 'fas fa-circle',
            'text'  => 'Biasa',
        ],
    };
@endphp

<span class="badge badge-{{ $config['color'] }} px-2 py-1">

    <i class="{{ $config['icon'] }} mr-1"></i>

    {{ $config['text'] }}

</span>