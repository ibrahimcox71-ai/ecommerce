<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\User;

class WarehousePolicy extends BasePolicy
{
    public function view(Admin|User $user): bool
    {
        return $user->can('warehouse.view');
    }

    public function viewAny(Admin|User $user): bool
    {
        return $user->can('warehouse.view');
    }

    public function create(Admin|User $user): bool
    {
        return $user->can('warehouse.create');
    }

    public function update(Admin|User $user): bool
    {
        return $user->can('warehouse.edit');
    }

    public function delete(Admin|User $user): bool
    {
        return $user->can('warehouse.delete');
    }

    public function restore(Admin|User $user): bool
    {
        return $user->can('warehouse.restore');
    }

    public function forceDelete(Admin|User $user): bool
    {
        return $user->can('warehouse.delete');
    }

    public function manage(Admin|User $user): bool
    {
        return $user->can('warehouse.manage');
    }

    public function toggleStatus(Admin|User $user): bool
    {
        return $user->can('warehouse.edit');
    }
}
