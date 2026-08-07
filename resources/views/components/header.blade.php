@props(['minimal' => false])
@if($minimal)
    @include('partials.frontend.header-minimal')
@else
    @include('partials.frontend.header')
@endif
