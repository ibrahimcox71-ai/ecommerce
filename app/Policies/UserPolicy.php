<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\User;

class UserPolicy extends BasePolicy
{
    public function viewAny(Admin|User $user): bool
    {
        return $user->can('users.view');
    }

    public function view(Admin|User $user): bool
    {
        return $user->can('users.view');
    }

    public function create(Admin|User $user): bool
    {
        return $user->can('users.create');
    }

    public function update(Admin|User $user): bool
    {
        return $user->can('users.edit');
    }

    public function delete(Admin|User $user): bool
    {
        return $user->can('users.delete');
    }

    public function restore(Admin|User $user): bool
    {
        return $user->can('users.restore');
    }

    public function suspend(Admin|User $user): bool
    {
        return $user->can('users.edit');
    }

    public function activate(Admin|User $user): bool
    {
        return $user->can('users.edit');
    }

    public function resetPassword(Admin|User $user): bool
    {
        return $user->can('users.edit');
    }
}
