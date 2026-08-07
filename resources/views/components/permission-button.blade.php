@props([
    'permission',
    'tag' => 'button',
    'href' => null,
    'class' => '',
    'action' => null,
])

@php
    $user = auth()->guard('admin')->user();
    $hasAccess = $user && ($user->hasRole('super-admin') || $user->can($permission));
@endphp

@if($hasAccess)
    @if($tag === 'a')
        <a href="{{ $href }}" class="{{ $class }}" @if($action) data-action="{{ $action }}" @endif>
            {{ $slot }}
        </a>
    @else
        <button type="button" class="{{ $class }}" @if($action) data-action="{{ $action }}" @endif>
            {{ $slot }}
        </button>
    @endif
@endif
