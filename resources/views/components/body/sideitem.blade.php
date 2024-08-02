@props(['item', 'collapsed' => false, 'icon', 'target' => null])

<li class="nav-item">
    <a
        {{ $attributes->merge([
            'class' => $collapsed ? 'nav-link collapsed' : 'nav-link',
            'data-bs-toggle' => $target ? 'collapse' : '',
            'data-bs-target' => $target ? "#$target" : ''
        ]) }}
    >
        <i class="{{ $icon }}"></i>
        <span>{{ $item }}</span>
        @if ($target)
            <i class='bi bi-chevron-down ms-auto'></i>
        @endif
    </a>
    {{ $slot }}
</li>
