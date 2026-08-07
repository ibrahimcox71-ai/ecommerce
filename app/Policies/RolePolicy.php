<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\User;

class RolePolicy extends BasePolicy
{
    public function viewAny(Admin|User $user): bool
    {
        return $user->can('roles.view');
    }

    public function view(Admin|User $user): bool
    {
        return $user->can('roles.view');
    }

    public function create(Admin|User $user): bool
    {
        return $user->can('roles.create');
    }

    public function update(Admin|User $user): bool
    {
        return $user->can('roles.edit');
    }

    public function delete(Admin|User $user): bool
    {
        return $user->can('roles.delete');
    }

    public function restore(Admin|User $user): bool
    {
        return $user->can('roles.restore');
    }
}
