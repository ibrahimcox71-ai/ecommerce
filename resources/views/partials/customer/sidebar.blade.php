<aside class="customer-sidebar" id="customerSidebar">
    <div class="p-4 border-bottom text-center">
        <div class="rounded-circle bg-primary bg-gradient d-flex align-items-center justify-content-center mx-auto mb-2" style="width: 64px; height: 64px;">
            <span class="text-white fw-bold fs-4">{{ substr(auth()->guard('customer')->user()?->name ?? 'U', 0, 1) }}</span>
        </div>
        <h6 class="mb-0 fw-semibold">{{ auth()->guard('customer')->user()?->name ?? 'User' }}</h6>
        <small class="text-muted">{{ auth()->guard('customer')->user()?->email ?? '' }}</small>
    </div>

    <nav class="mt-3">
        <ul class="nav flex-column">
            @foreach($navigation ?? [] as $item)
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() === $item['route'] ? 'active' : '' }}"
                       href="{{ route($item['route']) }}">
                        <i class="{{ $item['icon'] }}"></i>
                        <span>{{ $item['label'] }}</span>
                        @if (isset($item['badge']))
                            <span class="badge bg-danger rounded-pill ms-auto {{ $item['badge'] }}" style="display: none;">0</span>
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>

        <hr class="mx-3">

        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Store</span>
                </a>
            </li>
            <li class="nav-item">
                <form method="POST" action="{{ route('customer.logout') }}">
                    @csrf
                    <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </nav>
</aside>
