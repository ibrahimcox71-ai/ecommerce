@props(['cards' => []])

@if(empty($cards))
    <p class="text-muted small">No statistics available.</p>
@else
<div class="row g-3 mb-4">
    @foreach($cards as $card)
        <div class="col-6 col-md-4 col-lg-3 col-xl-2">
            <div class="card border-0 shadow-sm h-100 {{ $card['class'] ?? '' }}">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        @isset($card['icon'])
                            <span class="stat-icon d-flex align-items-center justify-content-center p-2 rounded-3" style="width: 40px; height: 40px; background: {{ $card['icon_bg'] ?? 'var(--bs-primary-bg-subtle)' }};">
                                <i class="{{ $card['icon'] }} fs-5" style="color: {{ $card['icon_color'] ?? 'var(--bs-primary)' }};" aria-hidden="true"></i>
                            </span>
                        @endisset
                        <div class="flex-grow-1 min-w-0">
                            <p class="text-muted mb-0 small text-truncate">{{ $card['label'] }}</p>
                            <h5 class="mb-0 fw-bold">{{ $card['value'] }}</h5>
                            @isset($card['trend'])
                                <small class="text-{{ $card['trend_color'] ?? 'success' }}">{{ $card['trend'] }}</small>
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endif
