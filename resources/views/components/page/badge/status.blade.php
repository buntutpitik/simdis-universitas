@props(['value'])

@php
    $config = match($value) {
        'Baru' => [
            'color' => 'primary',
            'icon'  => 'fas fa-envelope',
            'text'  => 'Baru',
        ],

        'Didisposisi' => [
            'color' => 'warning',
            'icon'  => 'fas fa-share',
            'text'  => 'Didisposisi',
        ],

        'Selesai' => [
            'color' => 'success',
            'icon'  => 'fas fa-check-circle',
            'text'  => 'Selesai',
        ],

        default => [
            'color' => 'secondary',
            'icon'  => 'fas fa-question-circle',
            'text'  => $value ?? '-',
        ],
    };
@endphp

<span class="badge badge-{{ $config['color'] }} px-2 py-1">

    <i class="{{ $config['icon'] }} mr-1"></i>

    {{ $config['text'] }}

</span>