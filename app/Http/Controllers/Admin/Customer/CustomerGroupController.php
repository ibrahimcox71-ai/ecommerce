<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreCustomerGroupRequest;
use App\Http\Requests\Customer\UpdateCustomerGroupRequest;
use App\Models\CustomerGroup;
use App\Services\CustomerGroupService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CustomerGroupController extends Controller
{
    public function __construct(
        protected CustomerGroupService $groupService
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'status', 'per_page']);
        $groups = $this->groupService->paginateWithFilters($filters);
        $stats = $this->groupService->getStats();

        return view('admin.customers.groups.index', compact('groups', 'stats'));
    }

    public function create(): View
    {
        return view('admin.customers.groups.create');
    }

    public function store(StoreCustomerGroupRequest $request): RedirectResponse
    {
        $group = $this->groupService->createGroup($request->validated());

        return redirect()
            ->route('admin.customers.groups.index')
            ->with('success', "Group '{$group->name}' created successfully!");
    }

    public function edit(CustomerGroup $customerGroup): View
    {
        $customerGroup->loadCount('customers');
        return view('admin.customers.groups.edit', compact('customerGroup'));
    }

    public function update(UpdateCustomerGroupRequest $request, CustomerGroup $customerGroup): RedirectResponse
    {
        $group = $this->groupService->updateGroup($customerGroup->id, $request->validated());

        return redirect()
            ->route('admin.customers.groups.index')
            ->with('success', "Group '{$group->name}' updated successfully!");
    }

    public function destroy(CustomerGroup $customerGroup): RedirectResponse
    {
        if ($customerGroup->customers()->exists()) {
            return redirect()
                ->route('admin.customers.groups.index')
                ->with('error', 'Cannot delete group with customers. Please reassign customers first.');
        }

        $name = $customerGroup->name;
        $customerGroup->delete();

        return redirect()
            ->route('admin.customers.groups.index')
            ->with('success', "Group '{$name}' deleted successfully!");
    }

    public function bulkDelete(Request $request): RedirectResponse
    {
        $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['required', 'integer', 'exists:customer_groups,id'],
        ]);

        $result = $this->groupService->bulkDelete($request->ids);
        $message = "{$result['deleted']} groups deleted successfully!";
        if (!empty($result['skipped'])) {
            $message .= ' Skipped: ' . implode(', ', $result['skipped']) . ' (have customers).';
        }

        return redirect()
            ->route('admin.customers.groups.index')
            ->with($result['deleted'] > 0 ? 'success' : 'error', $message);
    }

    public function trashed(Request $request): View
    {
        $filters = $request->only(['search', 'per_page']);
        $groups = $this->groupService->trashedPaginate($filters);

        return view('admin.customers.groups.trashed', compact('groups'));
    }

    public function restore(int $id): RedirectResponse
    {
        $group = CustomerGroup::onlyTrashed()->findOrFail($id);
        $group->restore();

        return redirect()
            ->route('admin.customers.groups.trashed')
            ->with('success', "Group '{$group->name}' restored successfully!");
    }

    public function forceDelete(int $id): RedirectResponse
    {
        $group = CustomerGroup::onlyTrashed()->findOrFail($id);
        $name = $group->name;
        $group->forceDelete();

        return redirect()
            ->route('admin.customers.groups.trashed')
            ->with('success', "Group '{$name}' permanently deleted!");
    }

    public function bulkRestore(Request $request): RedirectResponse
    {
        $request->validate(['ids' => ['required', 'array', 'min:1']]);

        $validIds = CustomerGroup::onlyTrashed()->whereIn('id', $request->ids)->pluck('id')->toArray();
        $invalidIds = array_diff($request->ids, $validIds);

        if (!empty($invalidIds)) {
            throw ValidationException::withMessages([
                'ids' => 'Invalid trashed IDs: ' . implode(', ', $invalidIds),
            ]);
        }

        $restored = $this->groupService->bulkRestore($request->ids);

        return redirect()
            ->route('admin.customers.groups.trashed')
            ->with('success', "{$restored} groups restored successfully!");
    }

    public function bulkForceDelete(Request $request): RedirectResponse
    {
        $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['required', 'integer', 'exists:customer_groups,id'],
        ]);

        $deleted = $this->groupService->bulkForceDelete($request->ids);

        return redirect()
            ->route('admin.customers.groups.trashed')
            ->with('success', "{$deleted} groups permanently deleted!");
    }

    public function toggleStatus(CustomerGroup $customerGroup): JsonResponse
    {
        $customerGroup->update(['status' => !$customerGroup->status]);

        return response()->json([
            'success' => true,
            'status' => $customerGroup->status,
            'message' => $customerGroup->status ? 'Group activated!' : 'Group deactivated!',
        ]);
    }

    public function searchSuggestions(Request $request): JsonResponse
    {
        $request->validate(['q' => 'required|string|min:2']);

        return response()->json($this->groupService->searchSuggestions($request->q));
    }

    public function stats(): JsonResponse
    {
        return response()->json($this->groupService->getStats());
    }
}
