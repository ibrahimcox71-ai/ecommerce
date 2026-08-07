<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\User;

class PermissionPolicy extends BasePolicy
{
    public function viewAny(Admin|User $user): bool
    {
        return $user->can('permissions.view');
    }

    public function view(Admin|User $user): bool
    {
        return $user->can('permissions.view');
    }

    public function create(Admin|User $user): bool
    {
        return $user->can('permissions.create');
    }

    public function update(Admin|User $user): bool
    {
        return $user->can('permissions.edit');
    }

    public function delete(Admin|User $user): bool
    {
        return $user->can('permissions.delete');
    }
}
