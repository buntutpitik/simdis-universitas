@props([
    'label',
    'width' => 220,
])

<tr>

    <th width="{{ $width }}">

        {{ $label }}

    </th>

    <td>

        {{ $slot }}

    </td>

</tr>