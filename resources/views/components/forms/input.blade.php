@props(['name','label'])
@php
    $defaults=[
        'type'=>"text",
        'class'=>"form-control",
        'id'=>$name,
        'name'=>$name,
        'value'=>old($name)
    ]
@endphp
<x-forms.field :$label :$name>
<input {{$attributes->merge($defaults)}}>
</x-forms.field>
