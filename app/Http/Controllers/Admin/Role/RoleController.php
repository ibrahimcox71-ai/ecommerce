<?php

namespace App\Http\Controllers\Admin\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Services\PermissionService;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct(
        protected RoleService $roleService,
        protected PermissionService $permissionService
    ) {
    }

    public function index(Request $request)
    {
        $roles = $this->roleService->list(
            perPage: $request->get('per_page', 10),
            filters: $request->only(['search'])
        );

        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $groupedPermissions = $this->permissionService->getGroupedPermissions();

        return view('admin.roles.create', compact('groupedPermissions'));
    }

    public function store(StoreRoleRequest $request)
    {
        $this->roleService->create($request->validated());

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role created successfully.');
    }

    public function show(Role $role)
    {
        $role->load('permissions');

        return view('admin.roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        $groupedPermissions = $this->permissionService->getGroupedPermissions();
        $rolePermissions = $this->permissionService->getPermissionsForRole($role->id);

        return view('admin.roles.edit', compact('role', 'groupedPermissions', 'rolePermissions'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $this->roleService->update($role, $request->validated());

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        if ($role->name === 'super-admin') {
            return back()->with('error', 'The Super Admin role cannot be deleted.');
        }

        $this->roleService->delete($role);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate(['ids' => ['required', 'array']]);

        $this->roleService->bulkDelete($request->ids);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Selected roles deleted successfully.');
    }
}
