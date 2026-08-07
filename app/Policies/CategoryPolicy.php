<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Category;

class CategoryPolicy extends BasePolicy
{
    public function viewAny(Admin $user): bool
    {
        return $user->can('categories.view');
    }

    public function view(Admin $user, Category $category): bool
    {
        return $user->can('categories.view');
    }

    public function create(Admin $user): bool
    {
        return $user->can('categories.create');
    }

    public function update(Admin $user, Category $category): bool
    {
        return $user->can('categories.edit');
    }

    public function delete(Admin $user, Category $category): bool
    {
        return $user->can('categories.delete');
    }

    public function restore(Admin $user, Category $category): bool
    {
        return $user->can('categories.restore');
    }

    public function forceDelete(Admin $user, Category $category): bool
    {
        return $user->can('categories.delete');
    }

    public function duplicate(Admin $user, Category $category): bool
    {
        return $user->can('categories.create');
    }

    public function export(Admin $user): bool
    {
        return $user->can('categories.export');
    }

    public function manage(Admin $user): bool
    {
        return $user->can('categories.manage');
    }
}
