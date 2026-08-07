@props(['compact' => false])
@if($compact)
    @include('partials.frontend.footer-minimal')
@else
    @include('partials.frontend.footer')
@endif
