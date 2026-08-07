<?php

namespace App\Services;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserService
{
    public function list(int $perPage = 10, array $filters = [])
    {
        $query = Admin::query();

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('email', 'like', '%' . $filters['search'] . '%');
            });
        }

        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['role'])) {
            $query->whereHas('roles', function ($q) use ($filters) {
                $q->where('name', $filters['role']);
            });
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function create(array $data): Admin
    {
        $admin = Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'] ?? null,
            'status' => $data['status'] ?? true,
            'role' => 'admin',
        ]);

        if (!empty($data['roles'])) {
            $roles = Role::whereIn('id', $data['roles'])
                ->where('guard_name', 'admin')
                ->get();
            $admin->syncRoles($roles);
        }

        if (!empty($data['permissions'])) {
            $admin->syncPermissions($data['permissions']);
        }

        return $admin;
    }

    public function update(Admin $admin, array $data): Admin
    {
        $admin->name = $data['name'] ?? $admin->name;
        $admin->email = $data['email'] ?? $admin->email;
        $admin->phone = $data['phone'] ?? $admin->phone;

        if (isset($data['status'])) {
            $admin->status = $data['status'];
        }

        if (!empty($data['password'])) {
            $admin->password = Hash::make($data['password']);
        }

        $admin->save();

        if (isset($data['roles'])) {
            $roles = Role::whereIn('id', $data['roles'])
                ->where('guard_name', 'admin')
                ->get();
            $admin->syncRoles($roles);
        }

        if (isset($data['permissions'])) {
            $admin->syncPermissions($data['permissions']);
        }

        return $admin;
    }

    public function delete(Admin $admin): void
    {
        $admin->delete();
    }

    public function restore(int $id): void
    {
        Admin::withTrashed()->findOrFail($id)->restore();
    }

    public function forceDelete(int $id): void
    {
        Admin::withTrashed()->findOrFail($id)->forceDelete();
    }

    public function bulkDelete(array $ids): void
    {
        Admin::whereIn('id', $ids)->delete();
    }

    public function bulkRestore(array $ids): void
    {
        Admin::withTrashed()->whereIn('id', $ids)->restore();
    }

    public function toggleStatus(Admin $admin): Admin
    {
        $admin->status = !$admin->status;
        $admin->save();

        return $admin;
    }
}
