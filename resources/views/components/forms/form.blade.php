@props(['method' => 'GET', 'action' => ''])
<form method="{{ $method }}" action="{{ $action }}" class="row g-3" {{ $attributes }}>
    @csrf
    @if (strtoupper($method) !== 'GET')
        @method($method)
    @endif
    {{ $slot }}
</form><!-- End Multi Columns Form -->
