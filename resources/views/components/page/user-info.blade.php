@props([
    'user',
])

@if($user)

    <div class="d-flex flex-column">

        <strong class="text-dark">

            {{ $user->full_name }}

        </strong>

        <small class="text-muted">

            {{ $user->position?->name ?? '-' }}

        </small>

    </div>

@else

    <span class="text-muted">-</span>

@endif