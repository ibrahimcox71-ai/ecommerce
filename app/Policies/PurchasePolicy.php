<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Purchase;

class PurchasePolicy extends BasePolicy
{
    public function viewAny(Admin $user): bool
    {
        return $user->can('purchases.view');
    }

    public function view(Admin $user, Purchase $purchase): bool
    {
        return $user->can('purchases.view');
    }

    public function create(Admin $user): bool
    {
        return $user->can('purchases.create');
    }

    public function update(Admin $user, Purchase $purchase): bool
    {
        if (!$purchase->isEditable()) {
            return false;
        }
        return $user->can('purchases.edit');
    }

    public function delete(Admin $user, Purchase $purchase): bool
    {
        return $user->can('purchases.delete') && $purchase->isDeletable();
    }

    public function approve(Admin $user, Purchase $purchase): bool
    {
        return $user->can('purchases.approve') && $purchase->isApprovable();
    }

    public function receive(Admin $user, Purchase $purchase): bool
    {
        return $user->can('purchases.receive') && $purchase->isReceivable();
    }

    public function purchaseReturn(Admin $user, Purchase $purchase): bool
    {
        return $user->can('purchases.return') && in_array($purchase->status->value, ['completed', 'partially_received']);
    }

    public function export(Admin $user): bool
    {
        return $user->can('purchases.export');
    }

    public function manage(Admin $user): bool
    {
        return $user->can('purchases.manage');
    }
}
