@props([
    'label',
    'value' => null,
    'width' => 220,
])

<tr>

    <th width="{{ $width }}">

        {{ $label }}

    </th>

    <td>

        @if(trim($slot))

            {{ $slot }}

        @else

            {{ filled($value) ? $value : '-' }}

        @endif

    </td>

</tr>