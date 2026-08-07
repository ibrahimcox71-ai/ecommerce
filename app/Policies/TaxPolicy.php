<?php

namespace App\Policies;

use App\Models\Admin;

class TaxPolicy extends BasePolicy
{
    public function viewAny(Admin $user): bool
    {
        return $user->can('taxes.view');
    }

    public function view(Admin $user): bool
    {
        return $user->can('taxes.view');
    }

    public function create(Admin $user): bool
    {
        return $user->can('taxes.create');
    }

    public function update(Admin $user): bool
    {
        return $user->can('taxes.edit');
    }

    public function delete(Admin $user): bool
    {
        return $user->can('taxes.delete');
    }
}
