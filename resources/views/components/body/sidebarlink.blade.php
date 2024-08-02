@props(['item'])

    <li>
        <a  {{ $attributes->merge(['class'=>'sidebarnavitem']) }}>
            <i class="bi bi-circle"></i><span>{{ $item }}</span>
        </a>
    </li>

