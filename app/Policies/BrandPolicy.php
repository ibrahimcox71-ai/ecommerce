<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Brand;

class BrandPolicy extends BasePolicy
{
    public function viewAny(Admin $user): bool
    {
        return $user->can('brands.view');
    }

    public function view(Admin $user, Brand $brand): bool
    {
        return $user->can('brands.view');
    }

    public function create(Admin $user): bool
    {
        return $user->can('brands.create');
    }

    public function update(Admin $user, Brand $brand): bool
    {
        return $user->can('brands.edit');
    }

    public function delete(Admin $user, Brand $brand): bool
    {
        return $user->can('brands.delete');
    }

    public function restore(Admin $user, Brand $brand): bool
    {
        return $user->can('brands.restore');
    }

    public function forceDelete(Admin $user, Brand $brand): bool
    {
        return $user->can('brands.delete');
    }

    public function duplicate(Admin $user, Brand $brand): bool
    {
        return $user->can('brands.create');
    }

    public function export(Admin $user): bool
    {
        return $user->can('brands.export');
    }

    public function manage(Admin $user): bool
    {
        return $user->can('brands.manage');
    }
}
