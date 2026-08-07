<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Supplier\BulkUpdateStatusRequest;
use App\Http\Requests\Supplier\StoreSupplierRequest;
use App\Http\Requests\Supplier\UpdateSupplierRequest;
use App\Models\Supplier;
use App\Services\SupplierService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class SupplierController extends Controller
{
    public function __construct(
        protected SupplierService $supplierService
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'status', 'country', 'city', 'date_from', 'date_to', 'per_page']);
        $suppliers = $this->supplierService->paginateWithFilters($filters);
        $stats = $this->supplierService->getStats();

        return view('admin.suppliers.index', compact('suppliers', 'stats'));
    }

    public function create(): View
    {
        return view('admin.suppliers.create');
    }

    public function store(StoreSupplierRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('logo')) {
            $data['logo'] = $this->supplierService->uploadImage($request->file('logo'));
        }

        $supplier = $this->supplierService->createSupplier($data);

        return redirect()
            ->route('admin.suppliers.index')
            ->with('success', "Supplier '{$supplier->name}' created successfully!");
    }

    public function show(Supplier $supplier): View
    {
        $supplier->loadCount('products');
        $supplier->load('activityLogs.causer');

        return view('admin.suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier): View
    {
        $supplier->loadCount('products');
        return view('admin.suppliers.edit', compact('supplier'));
    }

    public function update(UpdateSupplierRequest $request, Supplier $supplier): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('logo')) {
            $this->supplierService->deleteImage($supplier->logo);
            $data['logo'] = $this->supplierService->uploadImage($request->file('logo'));
        } elseif ($request->boolean('remove_logo')) {
            $this->supplierService->deleteImage($supplier->logo);
            $data['logo'] = null;
        }
        unset($data['remove_logo']);

        $supplier = $this->supplierService->updateSupplier($supplier->id, $data);

        return redirect()
            ->route('admin.suppliers.index')
            ->with('success', "Supplier '{$supplier->name}' updated successfully!");
    }

    public function destroy(Supplier $supplier): RedirectResponse
    {
        if ($supplier->products()->exists()) {
            return redirect()
                ->route('admin.suppliers.index')
                ->with('error', 'Cannot delete supplier with assigned products. Please remove product associations first.');
        }

        $name = $supplier->name;
        $this->supplierService->deleteImage($supplier->logo);
        $supplier->delete();

        return redirect()
            ->route('admin.suppliers.index')
            ->with('success', "Supplier '{$name}' deleted successfully!");
    }

    public function bulkDelete(Request $request): RedirectResponse
    {
        $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['required', 'integer', 'exists:suppliers,id'],
        ]);

        $result = $this->supplierService->bulkDelete($request->ids);
        $deleted = $result['deleted'];
        $skipped = $result['skipped'];

        $message = "{$deleted} suppliers deleted successfully!";
        if (!empty($skipped)) {
            $message .= ' Skipped: ' . implode(', ', $skipped) . ' (have assigned products).';
        }

        return redirect()
            ->route('admin.suppliers.index')
            ->with($deleted > 0 ? 'success' : 'error', $message);
    }

    public function trashed(Request $request): View
    {
        $filters = $request->only(['search', 'per_page']);
        $suppliers = $this->supplierService->trashedPaginate($filters);

        return view('admin.suppliers.trashed', compact('suppliers'));
    }

    public function restore(int $id): RedirectResponse
    {
        $supplier = Supplier::onlyTrashed()->findOrFail($id);
        $supplier->restore();

        return redirect()
            ->route('admin.suppliers.trashed')
            ->with('success', "Supplier '{$supplier->name}' restored successfully!");
    }

    public function forceDelete(int $id): RedirectResponse
    {
        $supplier = Supplier::onlyTrashed()->findOrFail($id);
        $name = $supplier->name;

        $this->supplierService->deleteImage($supplier->logo);
        $supplier->forceDelete();

        return redirect()
            ->route('admin.suppliers.trashed')
            ->with('success', "Supplier '{$name}' permanently deleted!");
    }

    public function bulkRestore(Request $request): RedirectResponse
    {
        $request->validate([
            'ids' => ['required', 'array', 'min:1'],
        ]);

        $validIds = Supplier::onlyTrashed()->whereIn('id', $request->ids)->pluck('id')->toArray();
        $invalidIds = array_diff($request->ids, $validIds);

        if (!empty($invalidIds)) {
            throw ValidationException::withMessages([
                'ids' => 'The following IDs are not valid trashed suppliers: ' . implode(', ', $invalidIds),
            ]);
        }

        $restored = $this->supplierService->bulkRestore($request->ids);

        return redirect()
            ->route('admin.suppliers.trashed')
            ->with('success', "{$restored} suppliers restored successfully!");
    }

    public function bulkUpdateStatus(BulkUpdateStatusRequest $request): RedirectResponse
    {
        $updated = $this->supplierService->bulkUpdateStatus($request->ids, $request->status);

        return redirect()
            ->route('admin.suppliers.index')
            ->with('success', "{$updated} suppliers status updated to '{$request->status}'!");
    }

    public function bulkForceDelete(Request $request): RedirectResponse
    {
        $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['required', 'integer', 'exists:suppliers,id'],
        ]);

        $deleted = $this->supplierService->bulkForceDelete($request->ids);

        return redirect()
            ->route('admin.suppliers.trashed')
            ->with('success', "{$deleted} suppliers permanently deleted!");
    }

    public function toggleStatus(Supplier $supplier): JsonResponse
    {
        $newStatus = $supplier->status === 'active' ? 'inactive' : 'active';
        $supplier->update(['status' => $newStatus]);

        return response()->json([
            'success' => true,
            'status' => $newStatus,
            'message' => $newStatus === 'active' ? 'Supplier activated!' : 'Supplier deactivated!',
        ]);
    }

    public function removeImage(Supplier $supplier): RedirectResponse
    {
        $this->supplierService->deleteImage($supplier->logo);
        $supplier->update(['logo' => null]);

        return redirect()
            ->back()
            ->with('success', 'Logo removed successfully!');
    }

    public function dataTable(Request $request): JsonResponse
    {
        $query = Supplier::withCount('products');

        if ($request->filled('search')) {
            $query->search($request->search);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('country')) {
            $query->where('country', $request->country);
        }
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        $total = $query->count();

        $sortColumn = $request->get('sort_column', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortColumn, $sortDirection);

        $perPage = $request->get('per_page', 15);
        $suppliers = $query->paginate($perPage);

        return response()->json([
            'draw' => $request->get('draw'),
            'recordsTotal' => $total,
            'recordsFiltered' => $suppliers->total(),
            'data' => $suppliers->items(),
            'current_page' => $suppliers->currentPage(),
            'last_page' => $suppliers->lastPage(),
            'from' => $suppliers->firstItem(),
            'to' => $suppliers->lastItem(),
        ]);
    }

    public function checkDeletable(Supplier $supplier): JsonResponse
    {
        return response()->json($this->supplierService->checkDeletable($supplier->id));
    }

    public function stats(): JsonResponse
    {
        return response()->json($this->supplierService->getStats());
    }

    public function searchSuggestions(Request $request): JsonResponse
    {
        $request->validate(['q' => 'required|string|min:2']);

        return response()->json($this->supplierService->searchSuggestions($request->q));
    }
}
