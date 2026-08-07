<?php

namespace App\Policies;

use App\Models\Admin;

class ChartOfAccountPolicy extends BasePolicy
{
    public function viewAny(Admin $user): bool
    {
        return $user->can('accounts.view');
    }

    public function view(Admin $user): bool
    {
        return $user->can('accounts.view');
    }

    public function create(Admin $user): bool
    {
        return $user->can('accounts.create');
    }

    public function update(Admin $user): bool
    {
        return $user->can('accounts.edit');
    }

    public function delete(Admin $user): bool
    {
        return $user->can('accounts.delete');
    }
}
