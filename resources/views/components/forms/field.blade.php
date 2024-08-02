{{-- resources/views/components/forms/field.blade.php --}}
@props(['label', 'name'])

<div {{$attributes->merge(['class'=>"col-md-12 mb-3"])}}>

    @if ($label)
        <x-forms.label :name="$name" :label="$label" />
    @endif

    <div class="mt-3">
        {{ $slot }}
        <x-forms.error :error="$errors->first($name)" />
    </div>
</div>
