
{{-- resources/views/components/forms/radio.blade.php --}}

@props(['label', 'name', 'value'])

@php
  $defaults = [
    'name' => $name,
    'type' => 'radio',
    'value' => $value ?? '',
    'class' => 'form-check-input',
  ];
@endphp

<div class="form-check">
    <input {{ $attributes($defaults) }}>
    <label class="form-check-label" for="{{ $name }}">{{ $label }}</label>
</div>
