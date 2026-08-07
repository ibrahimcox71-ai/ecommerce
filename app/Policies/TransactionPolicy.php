<?php

namespace App\Policies;

use App\Models\Admin;

class TransactionPolicy extends BasePolicy
{
    public function viewAny(Admin $user): bool
    {
        return $user->can('transactions.view');
    }

    public function view(Admin $user): bool
    {
        return $user->can('transactions.view');
    }

    public function create(Admin $user): bool
    {
        return $user->can('transactions.create');
    }

    public function export(Admin $user): bool
    {
        return $user->can('transactions.export');
    }
}
