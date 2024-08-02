@props(['dataTarget','targetName'])

<li class="nav-item">
    <button class="nav-link" data-bs-toggle="tab"
        data-bs-target="#{{$dataTarget}}">{{$targetName}}</button>
</li>
