<header class="main-header" role="banner">
    <div class="container">
        <div class="header-inner">

            <button class="header-action-btn d-lg-none touch-target" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileNavOffcanvas" aria-label="Open menu">
                <i class="fas fa-bars" aria-hidden="true"></i>
            </button>

            <a class="header-logo" href="{{ route('home') }}" aria-label="{{ config('app.name') }} home">
                <span class="logo-icon"><i class="fas fa-store" aria-hidden="true"></i></span>
                <span class="logo-text">{{ config('app.name') }}</span>
            </a>

            <div class="search-container d-none d-lg-block" role="search">
                <form action="{{ route('search') }}" method="GET" class="search-wrapper" aria-label="Search products">
                    <span class="search-icon"><i class="fas fa-search" aria-hidden="true"></i></span>
                    <input type="text" name="q" class="search-input" placeholder="Search products, brands, categories..." autocomplete="off" aria-label="Search query" aria-autocomplete="list" aria-controls="searchSuggestions" role="combobox" aria-expanded="false">
                    <button type="submit" class="search-submit" aria-label="Submit search">
                        <i class="fas fa-arrow-right" aria-hidden="true"></i>
                    </button>
                </form>
                <div class="search-suggestions" id="searchSuggestions" role="listbox" aria-label="Search suggestions">
                    <div class="p-3 text-center text-muted small">Type to search products...</div>
                </div>
            </div>

            <div class="header-actions">

                <div class="flash-header-timer" id="headerFlashTimer" role="timer" aria-label="Flash sale ends in 00 hours 00 minutes 00 seconds" aria-live="polite">
                    <i class="fas fa-bolt" aria-hidden="true"></i>
                    <span>Ends in</span>
                    <span class="timer-unit fh-hours" aria-hidden="true">00</span>
                    <span aria-hidden="true">:</span>
                    <span class="timer-unit fh-mins" aria-hidden="true">00</span>
                    <span aria-hidden="true">:</span>
                    <span class="timer-unit fh-secs" aria-hidden="true">00</span>
                </div>

                <a href="{{ route('wishlist') }}" class="header-action-btn touch-target" title="Wishlist" aria-label="Wishlist">
                    <i class="far fa-heart" aria-hidden="true"></i>
                    <span class="header-action-badge wishlist-count-badge d-none" role="status">0</span>
                </a>

                <button class="header-action-btn touch-target" title="Compare" aria-label="Compare products" disabled>
                    <i class="fas fa-random" aria-hidden="true"></i>
                </button>

                <a href="{{ route('cart') }}" class="header-action-btn touch-target" id="cartDropdown" data-bs-toggle="dropdown" aria-expanded="false" title="Cart" aria-label="Shopping cart">
                    <i class="fas fa-shopping-bag" aria-hidden="true"></i>
                    <span class="header-action-badge cart-count-badge d-none" role="status">0</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end mini-cart-dropdown-v2" id="miniCartDropdown" aria-label="Mini cart">
                    <x-mini-cart-content />
                </div>

                @auth('web')
                    <a href="{{ route('customer.notifications') }}" class="header-action-btn d-none d-md-flex touch-target" title="Notifications" aria-label="Notifications">
                        <i class="fas fa-bell" aria-hidden="true"></i>
                        <span class="header-action-badge notification-count-badge d-none" role="status">0</span>
                    </a>
                    <div class="dropdown d-none d-sm-block">
                        <a href="{{ route('customer.dashboard') }}" class="header-auth-btn btn-filled" aria-label="My account">
                            <i class="fas fa-user" aria-hidden="true"></i>
                            <span>{{ auth()->guard('web')->user()->name }}</span>
                        </a>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="header-auth-btn d-none d-sm-inline-flex" aria-label="Sign in">
                        <i class="fas fa-sign-in-alt" aria-hidden="true"></i>
                        <span>Sign In</span>
                    </a>
                @endauth

            </div>
        </div>
    </div>
</header>
