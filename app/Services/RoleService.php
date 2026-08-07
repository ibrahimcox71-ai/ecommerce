<?php

namespace App\Services;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleService
{
    public function list(int $perPage = 10, array $filters = [])
    {
        $query = Role::where('guard_name', 'admin');

        if (!empty($filters['search'])) {
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        }

        return $query->orderBy('name')->paginate($perPage);
    }

    public function create(array $data): Role
    {
        $role = Role::create([
            'name' => $data['name'],
            'guard_name' => 'admin',
        ]);

        if (!empty($data['permissions'])) {
            $permissions = Permission::whereIn('id', $data['permissions'])
                ->where('guard_name', 'admin')
                ->pluck('name')
                ->toArray();

            $role->syncPermissions($permissions);
        }

        return $role;
    }

    public function update(Role $role, array $data): Role
    {
        $role->update([
            'name' => $data['name'],
        ]);

        if (isset($data['permissions'])) {
            $permissions = Permission::whereIn('id', $data['permissions'])
                ->where('guard_name', 'admin')
                ->pluck('name')
                ->toArray();

            $role->syncPermissions($permissions);
        }

        return $role;
    }

    public function delete(Role $role): void
    {
        $role->delete();
    }

    public function bulkDelete(array $ids): void
    {
        Role::whereIn('id', $ids)->where('guard_name', 'admin')->delete();
    }
}
