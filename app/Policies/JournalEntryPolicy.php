<?php

namespace App\Policies;

use App\Models\Admin;

class JournalEntryPolicy extends BasePolicy
{
    public function viewAny(Admin $user): bool
    {
        return $user->can('journals.view');
    }

    public function view(Admin $user): bool
    {
        return $user->can('journals.view');
    }

    public function create(Admin $user): bool
    {
        return $user->can('journals.create');
    }

    public function update(Admin $user): bool
    {
        return $user->can('journals.edit');
    }

    public function delete(Admin $user): bool
    {
        return $user->can('journals.delete');
    }

    public function post(Admin $user): bool
    {
        return $user->can('journals.approve');
    }
}
