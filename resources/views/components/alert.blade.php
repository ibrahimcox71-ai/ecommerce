@props(['type' => 'info', 'icon' => null, 'dismiss' => true, 'class' => ''])
<div class="alert alert-{{ $type }} alert-dismissible fade show d-flex align-items-center gap-2 {{ $class }}" role="alert">
    @if($icon)
        <i class="{{ $icon }}" aria-hidden="true"></i>
    @elseif($type === 'success')
        <i class="fas fa-check-circle" aria-hidden="true"></i>
    @elseif($type === 'danger' || $type === 'error')
        <i class="fas fa-exclamation-circle" aria-hidden="true"></i>
    @elseif($type === 'warning')
        <i class="fas fa-exclamation-triangle" aria-hidden="true"></i>
    @elseif($type === 'info')
        <i class="fas fa-info-circle" aria-hidden="true"></i>
    @endif
    <div class="flex-grow-1">{{ $slot }}</div>
    @if($dismiss)
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @endif
</div>
