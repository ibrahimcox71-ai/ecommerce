<?php

namespace App\Services;

use App\Enums\PermissionGroup;
use Spatie\Permission\Models\Permission;

class PermissionService
{
    public function getAllPermissions(): array
    {
        $groups = [];

        foreach (PermissionGroup::cases() as $group) {
            $permissions = Permission::where('name', 'like', $group->value . '.%')
                ->where('guard_name', 'admin')
                ->get()
                ->groupBy(function ($permission) use ($group) {
                    return $group->value;
                });

            if ($permissions->isNotEmpty()) {
                $groups[$group->label()] = $permissions->first();
            }
        }

        return $groups;
    }

    public function getGroupedPermissions(): array
    {
        $grouped = [];

        foreach (PermissionGroup::cases() as $group) {
            $permissions = Permission::where('name', 'like', $group->value . '.%')
                ->where('guard_name', 'admin')
                ->get();

            if ($permissions->isNotEmpty()) {
                $grouped[] = [
                    'group' => $group,
                    'permissions' => $permissions,
                ];
            }
        }

        return $grouped;
    }

    public function getPermissionsForRole(int $roleId): array
    {
        return Permission::select('permissions.*')
            ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->where('role_has_permissions.role_id', $roleId)
            ->pluck('name')
            ->toArray();
    }

    public function buildPermissionName(PermissionGroup $group, string $type): string
    {
        return $group->value . '.' . $type;
    }

    public function generateAllPermissionNames(): array
    {
        $names = [];

        foreach (PermissionGroup::cases() as $group) {
            foreach (PermissionGroup::permissionTypes() as $type) {
                $names[] = $this->buildPermissionName($group, $type);
            }
        }

        return $names;
    }

    public function roleHasPermission(string $roleName, string $permission): bool
    {
        $role = \Spatie\Permission\Models\Role::findByName($roleName, 'admin');

        return $role->hasPermissionTo($permission);
    }
}
