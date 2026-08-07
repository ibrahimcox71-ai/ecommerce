<?php

namespace App\Policies;

use App\Models\Admin;

class BudgetPolicy extends BasePolicy
{
    public function viewAny(Admin $user): bool
    {
        return $user->can('budgets.view');
    }

    public function view(Admin $user): bool
    {
        return $user->can('budgets.view');
    }

    public function create(Admin $user): bool
    {
        return $user->can('budgets.create');
    }

    public function update(Admin $user): bool
    {
        return $user->can('budgets.edit');
    }

    public function delete(Admin $user): bool
    {
        return $user->can('budgets.delete');
    }
}
