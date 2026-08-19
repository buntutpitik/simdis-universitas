@props([
    'title' => 'Data tidak ditemukan',
])

<div class="text-center py-5">

    <i class="fas fa-folder-open fa-3x text-secondary mb-3"></i>

    <h5>

        {{ $title }}

    </h5>

    <p class="text-muted">

        {{ $slot }}

    </p>

</div>