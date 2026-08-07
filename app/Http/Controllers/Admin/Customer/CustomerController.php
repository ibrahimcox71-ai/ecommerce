<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Services\CustomerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function __construct(
        protected CustomerService $customerService
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->only([
            'search', 'status', 'customer_type', 'customer_group_id',
            'city', 'date_from', 'date_to', 'per_page',
        ]);
        $customers = $this->customerService->paginateWithFilters($filters);
        $stats = $this->customerService->getStats();
        $groups = CustomerGroup::active()->sorted()->get();

        return view('admin.customers.index', compact('customers', 'stats', 'groups'));
    }

    public function create(): View
    {
        $groups = CustomerGroup::active()->sorted()->get();
        return view('admin.customers.create', compact('groups'));
    }

    public function store(StoreCustomerRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $this->customerService->uploadAvatar($request->file('avatar'));
        }

        $customer = $this->customerService->createCustomer($data);

        return redirect()
            ->route('admin.customers.show', $customer->id)
            ->with('success', "Customer '{$customer->name}' created successfully!");
    }

    public function show(Customer $customer): View
    {
        $customer->load(['group', 'addresses', 'user']);
        $loginHistories = $customer->user?->loginHistories()->latest()->take(20)->get() ?? collect();

        return view('admin.customers.show', compact('customer', 'loginHistories'));
    }

    public function edit(Customer $customer): View
    {
        $customer->load('addresses');
        $groups = CustomerGroup::active()->sorted()->get();
        return view('admin.customers.edit', compact('customer', 'groups'));
    }

    public function update(UpdateCustomerRequest $request, Customer $customer): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            $this->customerService->deleteAvatar($customer->avatar);
            $data['avatar'] = $this->customerService->uploadAvatar($request->file('avatar'));
        } elseif ($request->boolean('remove_avatar')) {
            $this->customerService->deleteAvatar($customer->avatar);
            $data['avatar'] = null;
        }
        unset($data['remove_avatar']);

        $customer = $this->customerService->updateCustomer($customer->id, $data);

        return redirect()
            ->route('admin.customers.show', $customer->id)
            ->with('success', "Customer '{$customer->name}' updated successfully!");
    }

    public function destroy(Customer $customer): RedirectResponse
    {
        $name = $customer->name;
        $customer->delete();

        return redirect()
            ->route('admin.customers.index')
            ->with('success', "Customer '{$name}' deleted successfully!");
    }

    public function bulkDelete(Request $request): RedirectResponse
    {
        $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['required', 'integer', 'exists:customers,id'],
        ]);

        $result = $this->customerService->bulkDelete($request->ids);

        return redirect()
            ->route('admin.customers.index')
            ->with('success', "{$result['deleted']} customers deleted successfully!");
    }

    public function trashed(Request $request): View
    {
        $filters = $request->only(['search', 'per_page']);
        $customers = $this->customerService->trashedPaginate($filters);

        return view('admin.customers.trashed', compact('customers'));
    }

    public function restore(int $id): RedirectResponse
    {
        $customer = Customer::onlyTrashed()->findOrFail($id);
        $customer->restore();

        return redirect()
            ->route('admin.customers.trashed')
            ->with('success', "Customer '{$customer->name}' restored successfully!");
    }

    public function forceDelete(int $id): RedirectResponse
    {
        $customer = Customer::onlyTrashed()->findOrFail($id);
        $name = $customer->name;
        $this->customerService->deleteAvatar($customer->avatar);
        $customer->forceDelete();

        return redirect()
            ->route('admin.customers.trashed')
            ->with('success', "Customer '{$name}' permanently deleted!");
    }

    public function bulkRestore(Request $request): RedirectResponse
    {
        $request->validate([
            'ids' => ['required', 'array', 'min:1'],
        ]);

        $validIds = Customer::onlyTrashed()->whereIn('id', $request->ids)->pluck('id')->toArray();
        $invalidIds = array_diff($request->ids, $validIds);

        if (!empty($invalidIds)) {
            throw ValidationException::withMessages([
                'ids' => 'Invalid trashed IDs: ' . implode(', ', $invalidIds),
            ]);
        }

        $restored = $this->customerService->bulkRestore($request->ids);

        return redirect()
            ->route('admin.customers.trashed')
            ->with('success', "{$restored} customers restored successfully!");
    }

    public function bulkForceDelete(Request $request): RedirectResponse
    {
        $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['required', 'integer', 'exists:customers,id'],
        ]);

        $deleted = $this->customerService->bulkForceDelete($request->ids);

        return redirect()
            ->route('admin.customers.trashed')
            ->with('success', "{$deleted} customers permanently deleted!");
    }

    public function toggleStatus(Customer $customer): JsonResponse
    {
        $result = $this->customerService->toggleStatus($customer->id);

        return response()->json([
            'success' => true,
            'status' => $result['status'],
            'message' => $result['message'],
        ]);
    }

    public function removeAvatar(Customer $customer): RedirectResponse
    {
        $this->customerService->deleteAvatar($customer->avatar);
        $customer->update(['avatar' => null]);

        return redirect()
            ->back()
            ->with('success', 'Avatar removed successfully!');
    }

    public function dataTable(Request $request): JsonResponse
    {
        $query = Customer::with(['group', 'user'])->withCount('addresses');

        if ($request->filled('search')) {
            $query->search($request->search);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('customer_type')) {
            $query->where('customer_type', $request->customer_type);
        }
        if ($request->filled('customer_group_id')) {
            $query->where('customer_group_id', $request->customer_group_id);
        }

        $total = $query->count();
        $sortColumn = $request->get('sort_column', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortColumn, $sortDirection);

        $perPage = $request->get('per_page', 15);
        $customers = $query->paginate($perPage);

        return response()->json([
            'draw' => $request->get('draw'),
            'recordsTotal' => $total,
            'recordsFiltered' => $customers->total(),
            'data' => $customers->items(),
            'current_page' => $customers->currentPage(),
            'last_page' => $customers->lastPage(),
            'from' => $customers->firstItem(),
            'to' => $customers->lastItem(),
        ]);
    }

    public function searchSuggestions(Request $request): JsonResponse
    {
        $request->validate(['q' => 'required|string|min:2']);

        return response()->json($this->customerService->searchSuggestions($request->q));
    }

    public function stats(): JsonResponse
    {
        return response()->json($this->customerService->getStats());
    }

    public function loginHistory(Customer $customer): View
    {
        $loginHistories = $customer->user?->loginHistories()->latest()->paginate(50) ?? collect();

        return view('admin.customers.login-history', compact('customer', 'loginHistories'));
    }
}
