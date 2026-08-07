<?php

namespace App\Http\Controllers\Admin\Permission;

use App\Http\Controllers\Controller;
use App\Http\Requests\Permission\StorePermissionRequest;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct(
        protected PermissionService $permissionService
    ) {
    }

    public function index(Request $request)
    {
        $permissions = Permission::where('guard_name', 'admin')
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->when($request->group, function ($query, $group) {
                $query->where('name', 'like', $group . '.%');
            })
            ->orderBy('name')
            ->paginate($request->get('per_page', 50));

        $grouped = $this->permissionService->getGroupedPermissions();

        return view('admin.permissions.index', compact('permissions', 'grouped'));
    }

    public function create()
    {
        $groups = \App\Enums\PermissionGroup::cases();
        $types = \App\Enums\PermissionGroup::permissionTypes();

        return view('admin.permissions.create', compact('groups', 'types'));
    }

    public function store(StorePermissionRequest $request)
    {
        Permission::create([
            'name' => $request->name,
            'guard_name' => 'admin',
        ]);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission created successfully.');
    }

    public function edit(Permission $permission)
    {
        $groups = \App\Enums\PermissionGroup::cases();
        $types = \App\Enums\PermissionGroup::permissionTypes();

        return view('admin.permissions.edit', compact('permission', 'groups', 'types'));
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:permissions,name,' . $permission->id . ',id,guard_name,admin'],
        ]);

        $permission->update(['name' => $request->name]);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission updated successfully.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate(['ids' => ['required', 'array']]);

        Permission::whereIn('id', $request->ids)
            ->where('guard_name', 'admin')
            ->delete();

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Selected permissions deleted successfully.');
    }

    public function generateAll()
    {
        $names = $this->permissionService->generateAllPermissionNames();
        $created = 0;

        foreach ($names as $name) {
            Permission::firstOrCreate(
                ['name' => $name, 'guard_name' => 'admin'],
                ['name' => $name, 'guard_name' => 'admin']
            );
            $created++;
        }

        return redirect()->route('admin.permissions.index')
            ->with('success', $created . ' permissions generated successfully.');
    }
}
