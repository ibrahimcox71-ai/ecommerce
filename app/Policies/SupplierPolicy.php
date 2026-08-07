<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Supplier;

class SupplierPolicy extends BasePolicy
{
    public function viewAny(Admin $user): bool
    {
        return $user->can('suppliers.view');
    }

    public function view(Admin $user, Supplier $supplier): bool
    {
        return $user->can('suppliers.view');
    }

    public function create(Admin $user): bool
    {
        return $user->can('suppliers.create');
    }

    public function update(Admin $user, Supplier $supplier): bool
    {
        return $user->can('suppliers.edit');
    }

    public function delete(Admin $user, Supplier $supplier): bool
    {
        return $user->can('suppliers.delete');
    }

    public function restore(Admin $user, Supplier $supplier): bool
    {
        return $user->can('suppliers.restore');
    }

    public function forceDelete(Admin $user, Supplier $supplier): bool
    {
        return $user->can('suppliers.delete');
    }

    public function export(Admin $user): bool
    {
        return $user->can('suppliers.export');
    }

    public function manage(Admin $user): bool
    {
        return $user->can('suppliers.manage');
    }
}
