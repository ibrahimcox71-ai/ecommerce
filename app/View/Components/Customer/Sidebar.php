<?php

namespace App\View\Components\Customer;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class Sidebar extends Component
{
    public array $navigation;

    public function __construct()
    {
        $this->navigation = $this->buildNavigation();
    }

    public function render(): View|Closure|string
    {
        return view('partials.customer.sidebar');
    }

    private function buildNavigation(): array
    {
        return [
            [
                'label' => 'Dashboard',
                'route' => 'customer.dashboard',
                'icon' => 'fas fa-chart-bar',
            ],
            [
                'label' => 'My Orders',
                'route' => 'customer.orders',
                'icon' => 'fas fa-shopping-bag',
            ],
            [
                'label' => 'Wishlist',
                'route' => 'customer.wishlist',
                'icon' => 'fas fa-heart',
            ],
            [
                'label' => 'Addresses',
                'route' => 'customer.addresses',
                'icon' => 'fas fa-map-marker-alt',
            ],
            [
                'label' => 'Reviews',
                'route' => 'customer.reviews',
                'icon' => 'fas fa-star',
            ],
            [
                'label' => 'Notifications',
                'route' => 'customer.notifications',
                'icon' => 'fas fa-bell',
                'badge' => 'unread-notifications',
            ],
            [
                'label' => 'Profile',
                'route' => 'customer.profile',
                'icon' => 'fas fa-user',
            ],
        ];
    }

    public function isActive(string $route): bool
    {
        return Route::currentRouteName() === $route;
    }
}
