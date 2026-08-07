<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Expense;

class ExpensePolicy extends BasePolicy
{
    public function viewAny(Admin $user): bool
    {
        return $user->can('expenses.view');
    }

    public function view(Admin $user): bool
    {
        return $user->can('expenses.view');
    }

    public function create(Admin $user): bool
    {
        return $user->can('expenses.create');
    }

    public function update(Admin $user, Expense $expense): bool
    {
        if (!$expense->isEditable()) {
            return false;
        }
        return $user->can('expenses.edit');
    }

    public function delete(Admin $user, Expense $expense): bool
    {
        return $user->can('expenses.delete') && $expense->isEditable();
    }

    public function approve(Admin $user, Expense $expense): bool
    {
        return $user->can('expenses.approve') && $expense->isApprovable();
    }

    public function export(Admin $user): bool
    {
        return $user->can('expenses.export');
    }
}
