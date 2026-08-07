@props([
    'title',
    'subtitle' => null,
    'buttons' => [],
])

<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
    <div>
        <h4 class="mb-1 fw-semibold">{{ $title }}</h4>
        @if($subtitle)
            <p class="text-muted mb-0 small">{{ $subtitle }}</p>
        @endif
    </div>
    <div class="d-flex gap-2 flex-wrap">
        @foreach($buttons as $button)
            @isset($button['route'])
                <a href="{{ route($button['route'], $button['params'] ?? []) }}"
                   class="btn btn-{{ $button['color'] ?? 'primary' }} btn-sm d-flex align-items-center gap-1">
                    @isset($button['icon'])<i class="{{ $button['icon'] }}"></i>@endisset
                    {{ $button['label'] }}
                </a>
            @endisset
            @isset($button['modal'])
                <button type="button" class="btn btn-{{ $button['color'] ?? 'primary' }} btn-sm d-flex align-items-center gap-1"
                        data-bs-toggle="modal" data-bs-target="#{{ $button['modal'] }}">
                    @isset($button['icon'])<i class="{{ $button['icon'] }}"></i>@endisset
                    {{ $button['label'] }}
                </button>
            @endisset
        @endforeach
        {{ $slot ?? '' }}
    </div>
</div>
