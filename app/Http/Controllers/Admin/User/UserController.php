<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\Admin;
use App\Services\PermissionService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService,
        protected PermissionService $permissionService
    ) {
    }

    public function index(Request $request)
    {
        $users = $this->userService->list(
            perPage: $request->get('per_page', 10),
            filters: $request->only(['search', 'status', 'role'])
        );

        $roles = Role::where('guard_name', 'admin')->orderBy('name')->get();

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::where('guard_name', 'admin')->orderBy('name')->get();
        $groupedPermissions = $this->permissionService->getGroupedPermissions();

        return view('admin.users.create', compact('roles', 'groupedPermissions'));
    }

    public function store(StoreUserRequest $request)
    {
        $this->userService->create($request->validated());

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function show(Admin $user)
    {
        $user->load(['roles', 'permissions', 'loginHistories' => function ($q) {
            $q->latest()->limit(20);
        }]);

        return view('admin.users.show', compact('user'));
    }

    public function edit(Admin $user)
    {
        $roles = Role::where('guard_name', 'admin')->orderBy('name')->get();
        $groupedPermissions = $this->permissionService->getGroupedPermissions();
        $userRoles = $user->roles->pluck('id')->toArray();
        $userPermissions = $user->getPermissionNames()->toArray();

        return view('admin.users.edit', compact('user', 'roles', 'groupedPermissions', 'userRoles', 'userPermissions'));
    }

    public function update(UpdateUserRequest $request, Admin $user)
    {
        $this->userService->update($user, $request->validated());

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(Admin $user)
    {
        if ($user->hasRole('super-admin')) {
            return back()->with('error', 'The Super Admin cannot be deleted.');
        }

        if ($user->id === auth('admin')->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $this->userService->delete($user);

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    public function restore($id)
    {
        $this->userService->restore($id);

        return back()->with('success', 'User restored successfully.');
    }

    public function forceDelete($id)
    {
        if (Admin::withTrashed()->find($id)->hasRole('super-admin')) {
            return back()->with('error', 'The Super Admin cannot be permanently deleted.');
        }

        $this->userService->forceDelete($id);

        return back()->with('success', 'User permanently deleted.');
    }

    public function toggleStatus(Admin $user)
    {
        if ($user->hasRole('super-admin') && $user->id !== auth('admin')->id()) {
            return response()->json(['success' => false, 'message' => 'Cannot modify Super Admin status.']);
        }

        $this->userService->toggleStatus($user);

        return response()->json([
            'success' => true,
            'message' => 'User status updated successfully.',
            'status' => $user->status,
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $request->validate(['ids' => ['required', 'array']]);
        $this->userService->bulkDelete($request->ids);

        return redirect()->route('admin.users.index')
            ->with('success', 'Selected users deleted successfully.');
    }

    public function bulkRestore(Request $request)
    {
        $request->validate(['ids' => ['required', 'array']]);
        $this->userService->bulkRestore($request->ids);

        return back()->with('success', 'Selected users restored successfully.');
    }

    public function bulkAssignRole(Request $request)
    {
        $request->validate([
            'ids' => ['required', 'array'],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $role = Role::findById($request->role_id, 'admin');
        Admin::whereIn('id', $request->ids)->each(fn ($user) => $user->assignRole($role));

        return redirect()->route('admin.users.index')
            ->with('success', 'Role assigned to selected users successfully.');
    }

    public function loginHistory(Admin $user)
    {
        $histories = $user->loginHistories()->latest()->paginate(15);

        return view('admin.users.login-history', compact('user', 'histories'));
    }

    public function resetPassword(Request $request, Admin $user)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password reset successfully for ' . $user->name);
    }
}
