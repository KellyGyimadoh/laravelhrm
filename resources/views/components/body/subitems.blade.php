@props(['id'])

<ul {{ $attributes->merge(['class' => 'nav-content collapse', 'id' => $id, 'data-bs-parent' => '#sidebar-nav']) }}>
    {{ $slot }}
</ul>
