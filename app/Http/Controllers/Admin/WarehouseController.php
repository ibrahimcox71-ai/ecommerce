<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Warehouse\StoreWarehouseRequest;
use App\Http\Requests\Warehouse\UpdateWarehouseRequest;
use App\Models\Inventory;
use App\Models\Warehouse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class WarehouseController extends Controller
{
    public function index(Request $request): View
    {
        $warehouses = Warehouse::withCount('inventories')
            ->when($request->filled('search'), fn($q) => $q->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('code', 'like', "%{$request->search}%")
                  ->orWhere('city', 'like', "%{$request->search}%")
                  ->orWhere('state', 'like', "%{$request->search}%")
                  ->orWhere('manager_name', 'like', "%{$request->search}%");
            }))
            ->when($request->filled('status'), fn($q) => $q->where('status', $request->status === '1'))
            ->sorted()
            ->paginate($request->get('per_page', 15))
            ->withQueryString();

        return view('admin.warehouses.index', compact('warehouses'));
    }

    public function create(): View
    {
        return view('admin.warehouses.create');
    }

    public function store(StoreWarehouseRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->boolean('is_default')) {
            Warehouse::where('is_default', true)->update(['is_default' => false]);
        }

        $warehouse = Warehouse::create($data);
        $this->clearWarehouseCache();

        return redirect()
            ->route('admin.warehouses.index')
            ->with('success', "Warehouse '{$warehouse->name}' created successfully!");
    }

    public function show(Warehouse $warehouse): View
    {
        $warehouse->loadCount('inventories');

        $lowStockCount = $warehouse->inventories()
            ->whereRaw('(quantity - reserved_quantity) <= low_stock_threshold')
            ->whereRaw('(quantity - reserved_quantity) > 0')
            ->count();

        $outOfStockCount = $warehouse->inventories()
            ->whereRaw('(quantity - reserved_quantity) <= 0')
            ->count();

        $totalValue = Inventory::join('products', 'inventories.product_id', '=', 'products.id')
            ->where('inventories.warehouse_id', $warehouse->id)
            ->selectRaw('SUM(inventories.quantity * products.price) as total')
            ->value('total');

        $recentMovements = $warehouse->stockMovementsFrom()
            ->with(['product', 'causer'])
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.warehouses.show', compact(
            'warehouse', 'lowStockCount', 'outOfStockCount', 'totalValue', 'recentMovements'
        ));
    }

    public function edit(Warehouse $warehouse): View
    {
        return view('admin.warehouses.edit', compact('warehouse'));
    }

    public function update(UpdateWarehouseRequest $request, Warehouse $warehouse): RedirectResponse
    {
        $data = $request->validated();

        if ($request->boolean('is_default') && !$warehouse->is_default) {
            Warehouse::where('is_default', true)->update(['is_default' => false]);
        }

        $warehouse->update($data);
        $this->clearWarehouseCache();

        return redirect()
            ->route('admin.warehouses.index')
            ->with('success', "Warehouse '{$warehouse->name}' updated successfully!");
    }

    public function destroy(Warehouse $warehouse): RedirectResponse
    {
        if ($warehouse->inventories()->exists()) {
            return redirect()
                ->route('admin.warehouses.index')
                ->with('error', 'Cannot delete warehouse with inventory records. Please reassign inventory first.');
        }

        $name = $warehouse->name;
        $warehouse->delete();
        $this->clearWarehouseCache();

        return redirect()
            ->route('admin.warehouses.index')
            ->with('success', "Warehouse '{$name}' deleted successfully!");
    }

    public function bulkDelete(Request $request): RedirectResponse
    {
        $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['required', 'integer', 'exists:warehouses,id'],
        ]);

        $warehouses = Warehouse::whereIn('id', $request->ids)->get();
        $deleted = 0;
        $skipped = 0;

        foreach ($warehouses as $warehouse) {
            if ($warehouse->inventories()->exists()) {
                $skipped++;
                continue;
            }
            $warehouse->delete();
            $deleted++;
        }

        $this->clearWarehouseCache();

        $message = "{$deleted} warehouses deleted successfully!";
        if ($skipped > 0) {
            $message .= " {$skipped} warehouses skipped (have inventory records).";
        }

        return redirect()
            ->route('admin.warehouses.index')
            ->with($deleted > 0 ? 'success' : 'error', $message);
    }

    public function trashed(Request $request): View
    {
        $warehouses = Warehouse::onlyTrashed()
            ->when($request->filled('search'), fn($q) => $q->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('code', 'like', "%{$request->search}%");
            }))
            ->orderBy('deleted_at', 'desc')
            ->paginate($request->get('per_page', 15))
            ->withQueryString();

        return view('admin.warehouses.trashed', compact('warehouses'));
    }

    public function restore(int $id): RedirectResponse
    {
        $warehouse = Warehouse::onlyTrashed()->findOrFail($id);
        $warehouse->restore();
        $this->clearWarehouseCache();

        return redirect()
            ->route('admin.warehouses.trashed')
            ->with('success', "Warehouse '{$warehouse->name}' restored successfully!");
    }

    public function forceDelete(int $id): RedirectResponse
    {
        $warehouse = Warehouse::onlyTrashed()->findOrFail($id);
        $name = $warehouse->name;
        $warehouse->forceDelete();
        $this->clearWarehouseCache();

        return redirect()
            ->route('admin.warehouses.trashed')
            ->with('success', "Warehouse '{$name}' permanently deleted!");
    }

    public function bulkRestore(Request $request): RedirectResponse
    {
        $request->validate([
            'ids' => ['required', 'array', 'min:1'],
        ]);

        $validIds = Warehouse::onlyTrashed()->whereIn('id', $request->ids)->pluck('id')->toArray();
        $invalidIds = array_diff($request->ids, $validIds);

        if (!empty($invalidIds)) {
            throw ValidationException::withMessages([
                'ids' => 'The following IDs are not valid trashed warehouses: ' . implode(', ', $invalidIds),
            ]);
        }

        $restored = Warehouse::onlyTrashed()
            ->whereIn('id', $request->ids)
            ->restore();

        $this->clearWarehouseCache();

        return redirect()
            ->route('admin.warehouses.trashed')
            ->with('success', "{$restored} warehouses restored successfully!");
    }

    public function toggleStatus(Warehouse $warehouse): JsonResponse
    {
        $this->authorize('toggleStatus', $warehouse);
        $warehouse->update(['status' => !$warehouse->status]);
        $this->clearWarehouseCache();

        return response()->json([
            'success' => true,
            'status' => $warehouse->status,
            'message' => $warehouse->status ? 'Warehouse activated!' : 'Warehouse deactivated!',
        ]);
    }

    public function updateSort(Request $request): JsonResponse
    {
        $request->validate([
            'items' => ['required', 'array'],
            'items.*.id' => ['required', 'integer', 'exists:warehouses,id'],
            'items.*.sort_order' => ['required', 'integer', 'min:0'],
        ]);

        foreach ($request->items as $item) {
            Warehouse::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }

        $this->clearWarehouseCache();

        return response()->json(['success' => true, 'message' => 'Sort order updated!']);
    }

    public function dataTable(Request $request): JsonResponse
    {
        $query = Warehouse::withCount('inventories');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('code', 'like', "%{$request->search}%")
                  ->orWhere('manager_name', 'like', "%{$request->search}%");
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status === '1');
        }

        $total = $query->count();
        $sortColumn = $request->get('sort_column', 'sort_order');
        $sortDirection = $request->get('sort_direction', 'asc');
        $query->orderBy($sortColumn, $sortDirection);

        $perPage = $request->get('per_page', 15);
        $warehouses = $query->paginate($perPage);

        return response()->json([
            'draw' => $request->get('draw'),
            'recordsTotal' => $total,
            'recordsFiltered' => $warehouses->total(),
            'data' => $warehouses->items(),
            'current_page' => $warehouses->currentPage(),
            'last_page' => $warehouses->lastPage(),
            'from' => $warehouses->firstItem(),
            'to' => $warehouses->lastItem(),
        ]);
    }

    public function setDefault(Warehouse $warehouse): RedirectResponse
    {
        $this->authorize('manage', $warehouse);

        Warehouse::where('is_default', true)->update(['is_default' => false]);
        $warehouse->update(['is_default' => true]);
        $this->clearWarehouseCache();

        return redirect()
            ->route('admin.warehouses.index')
            ->with('success', "'{$warehouse->name}' is now the default warehouse!");
    }

    private function clearWarehouseCache(): void
    {
        Cache::forget('active_warehouses');
        Cache::forget('default_warehouse');
    }

    public function stats(): JsonResponse
    {
        $totalWarehouses = Warehouse::count();
        $activeWarehouses = Warehouse::where('status', true)->count();
        $defaultWarehouse = Warehouse::where('is_default', true)->first();

        return response()->json([
            'success' => true,
            'data' => [
                'total' => $totalWarehouses,
                'active' => $activeWarehouses,
                'inactive' => $totalWarehouses - $activeWarehouses,
                'default' => $defaultWarehouse ? $defaultWarehouse->name : null,
            ],
        ]);
    }

    public function searchSuggestions(Request $request): JsonResponse
    {
        $request->validate(['search' => ['required', 'string', 'min:1']]);

        $warehouses = Warehouse::active()
            ->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('code', 'like', "%{$request->search}%");
            })
            ->limit(10)
            ->get(['id', 'name', 'code', 'city']);

        return response()->json($warehouses);
    }
}
