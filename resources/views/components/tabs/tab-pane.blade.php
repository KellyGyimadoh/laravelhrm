@props(['id', 'active' => false, 'show' => false])

@php
    // Determine the classes to apply
    $classes = 'tab-pane fade';
    if ($active) $classes .= ' active';
    if ($show) $classes .= ' show';

    // Set the default attributes, merging with any additional attributes passed
    $defaults = [
        'class' => $classes,
        'id' => $id,
    ];
@endphp

<div {{ $attributes->merge($defaults) }}>
    {{ $slot }}
</div>
