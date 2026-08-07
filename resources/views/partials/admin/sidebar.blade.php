<aside class="admin-sidebar text-white" id="adminSidebar">

    <button type="button" class="sidebar-close" id="sidebarClose" aria-label="Close sidebar">
        <i class="bi bi-x-lg"></i>
    </button>

    <div class="sidebar-brand">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand-link">
            <div class="sidebar-brand-icon">
                <i class="bi bi-shop"></i>
            </div>
            <div>
                <div class="sidebar-brand-text">{{ config('app.name') }}</div>
                <div class="sidebar-brand-sub">Admin Panel</div>
            </div>
        </a>
    </div>

    <div class="sidebar-profile">
        <div class="sidebar-profile-avatar">
            {{ strtoupper(substr(auth()->guard('admin')->user()?->name ?? 'A', 0, 1)) }}
        </div>
        <div class="sidebar-profile-info">
            <div class="sidebar-profile-name">{{ auth()->guard('admin')->user()?->name ?? 'Admin' }}</div>
            <div class="sidebar-profile-role">{{ auth()->guard('admin')->user()?->email ?? 'Administrator' }}</div>
        </div>
        <div class="sidebar-profile-badge"></div>
    </div>

    <nav class="sidebar-nav">
        <div class="sidebar-nav-label">Main Menu</div>
        <ul class="list-unstyled mb-0">
            @foreach($navigation ?? [] as $item)
                @if(isset($item['type']) && $item['type'] === 'divider')
                    <li><hr class="sidebar-divider"></li>
                @elseif(isset($item['route']))
                    @php
                        $isActive = Route::currentRouteName() === $item['route'];
                        $hasChildren = !empty($item['children']);
                        $isChildActive = $hasChildren && collect($item['children'])->contains(fn($c) => Route::currentRouteName() === ($c['route'] ?? ''));
                    @endphp
                    <li class="sidebar-nav-item">
                        @if($hasChildren)
                            <a class="sidebar-nav-link {{ ($isActive || $isChildActive) ? 'active' : '' }}"
                               href="#sidebarCollapse_{{ Str::slug($item['label']) }}"
                               data-bs-toggle="collapse" role="button"
                               aria-expanded="{{ $isChildActive ? 'true' : 'false' }}">
                                <i class="{{ $item['icon'] }}"></i>
                                <span class="nav-label">{{ $item['label'] }}</span>
                                <i class="bi bi-chevron-down nav-arrow {{ $isChildActive ? 'open' : '' }}"></i>
                            </a>
                            <ul class="list-unstyled collapse {{ $isChildActive ? 'show' : '' }} sidebar-submenu"
                                id="sidebarCollapse_{{ Str::slug($item['label']) }}">
                                @foreach($item['children'] as $child)
                                    <li>
                                        <a class="sidebar-nav-link sidebar-submenu-link {{ Route::currentRouteName() === ($child['route'] ?? '') ? 'active' : '' }}"
                                           href="{{ isset($child['route']) ? route($child['route']) : '#' }}">
                                            <i class="{{ $child['icon'] ?? 'bi bi-circle' }}"></i>
                                            <span class="nav-label">{{ $child['label'] }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <a class="sidebar-nav-link {{ $isActive ? 'active' : '' }}"
                               href="{{ route($item['route']) }}">
                                <i class="{{ $item['icon'] }}"></i>
                                <span class="nav-label">{{ $item['label'] }}</span>
                                @if(($item['label'] === 'Orders' || $item['label'] === 'Customers') && !$isActive)
                                    <span class="badge bg-danger">3</span>
                                @endif
                            </a>
                        @endif
                    </li>
                @endif
            @endforeach
        </ul>
    </nav>

    <div class="sidebar-footer">
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="sidebar-nav-link w-100 text-start border-0 bg-transparent">
                <i class="bi bi-box-arrow-right"></i>
                <span class="nav-label">Logout</span>
            </button>
        </form>
    </div>

</aside>
