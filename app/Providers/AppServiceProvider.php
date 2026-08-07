<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(\Spatie\Permission\PermissionServiceProvider::class);
    }

    public function boot(): void
    {
        Paginator::useBootstrap();

        Blade::if('admin', function () {
            return auth()->guard('admin')->check();
        });

        Blade::if('customer', function () {
            return auth()->guard('customer')->check();
        });

        Blade::if('permission', function ($permission) {
            $user = auth()->guard('admin')->user();
            return $user && ($user->hasRole('super-admin') || $user->can($permission));
        });

        Blade::if('role', function ($role) {
            $user = auth()->guard('admin')->user();
            return $user && $user->hasRole($role);
        });

        Blade::if('canany', function (array $permissions) {
            $user = auth()->guard('admin')->user();
            if (!$user) return false;
            if ($user->hasRole('super-admin')) return true;
            foreach ($permissions as $permission) {
                if ($user->can($permission)) return true;
            }
            return false;
        });

        Gate::before(function ($user, $ability) {
            if ($user->hasRole('super-admin')) {
                return true;
            }
            return null;
        });
    }
}
