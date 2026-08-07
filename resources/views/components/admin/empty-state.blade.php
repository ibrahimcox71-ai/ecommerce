@props([
    'icon' => 'bi bi-inbox',
    'message' => 'No records found.',
    'buttonLabel' => null,
    'buttonRoute' => null,
])

<div class="text-center py-5" role="status">
    <i class="{{ $icon }} text-gray-400" style="font-size: 3rem;" aria-hidden="true"></i>
    <p class="text-muted mt-3 mb-3">{{ $message }}</p>
    @if($buttonLabel && $buttonRoute)
        <a href="{{ route($buttonRoute) }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1" aria-hidden="true"></i> {{ $buttonLabel }}
        </a>
    @endif
</div>
