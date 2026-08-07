<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\User;

class InventoryPolicy extends BasePolicy
{
    public function view(Admin|User $user): bool
    {
        return $user->can('inventory.view');
    }

    public function viewAny(Admin|User $user): bool
    {
        return $user->can('inventory.view');
    }

    public function create(Admin|User $user): bool
    {
        return $user->can('inventory.create');
    }

    public function update(Admin|User $user): bool
    {
        return $user->can('inventory.edit');
    }

    public function delete(Admin|User $user): bool
    {
        return $user->can('inventory.delete');
    }

    public function manage(Admin|User $user): bool
    {
        return $user->can('inventory.manage');
    }

    public function stockIn(Admin|User $user): bool
    {
        return $user->can('inventory.create');
    }

    public function stockOut(Admin|User $user): bool
    {
        return $user->can('inventory.edit');
    }

    public function transfer(Admin|User $user): bool
    {
        return $user->can('inventory.manage');
    }

    public function adjust(Admin|User $user): bool
    {
        return $user->can('inventory.manage');
    }

    public function export(Admin|User $user): bool
    {
        return $user->can('inventory.export') || $user->can('inventory.manage');
    }

    public function viewReports(Admin|User $user): bool
    {
        return $user->can('reports.view') || $user->can('inventory.manage');
    }
}
