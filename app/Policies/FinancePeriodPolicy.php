<?php

namespace App\Policies;

use App\Models\Admin;

class FinancePeriodPolicy extends BasePolicy
{
    public function viewAny(Admin $user): bool
    {
        return $user->can('periods.view');
    }

    public function view(Admin $user): bool
    {
        return $user->can('periods.view');
    }

    public function create(Admin $user): bool
    {
        return $user->can('periods.create');
    }

    public function update(Admin $user): bool
    {
        return $user->can('periods.edit');
    }

    public function delete(Admin $user): bool
    {
        return $user->can('periods.delete');
    }

    public function close(Admin $user): bool
    {
        return $user->can('periods.approve');
    }
}
