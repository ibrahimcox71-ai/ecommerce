@props(['status' => 'active'])

@php
    $styles = [
        'active' => 'bg-success-subtle text-success border-success-subtle',
        'inactive' => 'bg-secondary-subtle text-secondary border-secondary-subtle',
        'draft' => 'bg-warning-subtle text-warning border-warning-subtle',
        'hidden' => 'bg-dark-subtle text-dark border-dark-subtle',
    ];
    $icons = [
        'active' => 'fa-check-circle',
        'inactive' => 'fa-pause-circle',
        'draft' => 'fa-pen-fancy',
        'hidden' => 'fa-eye-slash',
    ];
    $class = $styles[$status] ?? 'bg-secondary-subtle text-secondary';
    $icon = $icons[$status] ?? 'fa-circle';
@endphp

<span class="badge border {{ $class }} px-3 py-2 rounded-pill">
    <i class="fas {{ $icon }} me-1"></i>
    {{ ucfirst($status) }}
</span>
