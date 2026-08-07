@props(['items' => []])
<nav aria-label="breadcrumb" {{ $attributes }}>
    <ol class="breadcrumb breadcrumb-premium mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none"><i class="fas fa-home me-1" aria-hidden="true"></i>Home</a></li>
        @foreach ($items as $item)
            @if ($loop->last)
                <li class="breadcrumb-item active" aria-current="page">{{ $item['label'] }}</li>
            @else
                <li class="breadcrumb-item"><a href="{{ $item['url'] }}" class="text-decoration-none">{{ $item['label'] }}</a></li>
            @endif
        @endforeach
    </ol>
</nav>
