<nav aria-label="breadcrumb" class="bg-gray-100 py-2 mb-4">
    <div class="container">
        <ol class="breadcrumb breadcrumb-premium mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}"><i class="fas fa-home me-1"></i>Home</a>
            </li>
            @foreach($items as $item)
                @if($loop->last)
                    <li class="breadcrumb-item active" aria-current="page">{{ $item['label'] }}</li>
                @else
                    <li class="breadcrumb-item">
                        <a href="{{ $item['url'] ?? '#' }}">{{ $item['label'] }}</a>
                    </li>
                @endif
            @endforeach
        </ol>
    </div>
</nav>
