@props(['title'])
<div class="pagetitle">
    <h1>{{ $title }}</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a {{ $attributes }}>{{ $title }}</a></li>

        </ol>
    </nav>
</div>
