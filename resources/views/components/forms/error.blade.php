{{-- resources/views/components/forms/error.blade.php --}}
@props(['error' => null])

@if ($error)
    <div class="text-danger mt-2">{{ $error }}</div>
@endif
