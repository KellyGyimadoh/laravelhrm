@props(['name'])
@php
    $defaults=[
        'name'=>$name,
        'class'=>'form-select',
        'aria-label'=>'Default select example'
    ];
@endphp


<select {{$attributes($defaults)}}>
    {{$slot}}
  </select>
