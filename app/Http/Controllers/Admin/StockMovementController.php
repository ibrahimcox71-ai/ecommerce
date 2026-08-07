<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\DirectAdjustmentRequest;
use App\Http\Requests\Inventory\StockMovementRequest;
use App\Http\Requests\Inventory\StockTransferRequest;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\StockMovement;
use App\Models\Warehouse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StockMovementController extends Controller
{
    public function index(Request $request): View
    {
        $movements = StockMovement::with(['product', 'variant', 'fromWarehouse', 'toWarehouse', 'causer'])
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where(function ($sq) use ($request) {
                    $sq->whereHas('product', fn($pq) => $pq->where('name', 'like', "%{$request->search}%")
                        ->orWhere('sku', 'like', "%{$request->search}%"))
                      ->orWhere('reference_number', 'like', "%{$request->search}%")
                      ->orWhere('reason', 'like', "%{$request->search}%");
                });
            })
            ->when($request->filled('movement_type'), fn($q) => $q->where('movement_type', $request->movement_type))
            ->when($request->filled('warehouse_id'), function ($q) use ($request) {
                $q->where(function ($wq) use ($request) {
                    $wq->where('from_warehouse_id', $request->warehouse_id)
                       ->orWhere('to_warehouse_id', $request->warehouse_id);
                });
            })
            ->when($request->filled('date_from'), fn($q) => $q->whereDate('created_at', '>=', $request->date_from))
            ->when($request->filled('date_to'), fn($q) => $q->whereDate('created_at', '<=', $request->date_to))
            ->latest()
            ->paginate($request->get('per_page', 15))
            ->withQueryString();

        return view('admin.stock-movements.index', [
            'movements' => $movements,
            'warehouses' => Warehouse::active()->sorted()->get(),
            'movementTypes' => [
                'stock_in' => 'Stock In',
                'stock_out' => 'Stock Out',
                'adjustment' => 'Adjustment',
                'transfer' => 'Transfer',
                'return' => 'Return',
                'damage' => 'Damage',
                'lost' => 'Lost',
            ],
        ]);
    }

    public function create(): View
    {
        return view('admin.stock-movements.create', [
            'warehouses' => Warehouse::active()->sorted()->get(),
            'movementTypes' => [
                'stock_in' => 'Stock In',
                'stock_out' => 'Stock Out',
                'adjustment' => 'Stock Adjustment',
                'transfer' => 'Warehouse Transfer',
                'return' => 'Return Stock',
                'damage' => 'Damage Stock',
                'lost' => 'Lost Stock',
            ],
        ]);
    }

    public function store(StockMovementRequest $request): RedirectResponse
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();

            $movement = $this->processMovement($data);

            DB::commit();

            return redirect()
                ->route('admin.stock-movements.index')
                ->with('success', "Stock movement '{$movement->reference_number}' recorded successfully!");
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function transfer(StockTransferRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['movement_type'] = 'transfer';

        try {
            DB::beginTransaction();

            $movement = $this->processMovement($data);

            DB::commit();

            return redirect()
                ->route('admin.stock-movements.index')
                ->with('success', "Stock transferred successfully! Reference: {$movement->reference_number}");
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function adjust(DirectAdjustmentRequest $request): RedirectResponse
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();

            $query = Inventory::where('product_id', $request->product_id)
                ->where('warehouse_id', $request->warehouse_id);

            if ($request->product_variant_id) {
                $query->where('product_variant_id', $request->product_variant_id);
            } else {
                $query->whereNull('product_variant_id');
            }

            $inventory = $query->firstOrFail();
            $oldQty = $inventory->quantity;
            $diff = $request->quantity - $oldQty;

            $inventory->update([
                'quantity' => $request->quantity,
                'last_stock_adjustment' => 'Manual Adjustment',
                'last_stock_update' => now(),
            ]);

            $inventory->logChange(
                'adjustment',
                $diff,
                $request->reason ?? 'Manual Stock Adjustment',
                null,
                $request->notes
            );

            StockMovement::create([
                'product_id' => $request->product_id,
                'product_variant_id' => $request->product_variant_id,
                'from_warehouse_id' => $request->warehouse_id,
                'to_warehouse_id' => null,
                'movement_type' => 'adjustment',
                'quantity' => abs($diff),
                'quantity_before' => $oldQty,
                'quantity_after' => $request->quantity,
                'reference_number' => StockMovement::generateReferenceNumber(),
                'reason' => $request->reason ?? 'Manual Stock Adjustment',
                'notes' => $request->notes,
                'causer_type' => auth()->guard('admin')->check() ? \App\Models\Admin::class : null,
                'causer_id' => auth()->guard('admin')->id(),
            ]);

            DB::commit();

            return redirect()
                ->route('admin.inventories.index')
                ->with('success', "Stock adjusted from {$oldQty} to {$request->quantity}.");
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function show(StockMovement $stockMovement): View
    {
        $stockMovement->load(['product', 'variant', 'fromWarehouse', 'toWarehouse', 'causer']);

        return view('admin.stock-movements.show', [
            'movement' => $stockMovement,
        ]);
    }

    private function processMovement(array $data): StockMovement
    {
        $type = $data['movement_type'];
        $quantity = $data['quantity'];

        $fromInventory = null;
        $toInventory = null;

        if (isset($data['from_warehouse_id'])) {
            $fromInventory = $this->getInventory(
                $data['product_id'],
                $data['product_variant_id'] ?? null,
                $data['from_warehouse_id']
            );
        }

        if (isset($data['to_warehouse_id'])) {
            $toInventory = $this->getOrCreateInventory(
                $data['product_id'],
                $data['product_variant_id'] ?? null,
                $data['to_warehouse_id']
            );
        }

        $fromQtyBefore = $fromInventory?->quantity ?? 0;
        $toQtyBefore = $toInventory?->quantity ?? 0;

        switch ($type) {
            case 'stock_in':
                $toInventory?->add($quantity, $data['reason'] ?? 'Stock In', null, $data['notes'] ?? null);
                break;

            case 'stock_out':
                if ($fromInventory && $fromInventory->quantity < $quantity) {
                    throw new \Exception("Insufficient stock in source warehouse. Available: {$fromInventory->quantity}");
                }
                $fromInventory?->subtract($quantity, $data['reason'] ?? 'Stock Out', null, $data['notes'] ?? null);
                break;

            case 'transfer':
                if ($fromInventory && $fromInventory->quantity < $quantity) {
                    throw new \Exception("Insufficient stock for transfer. Available: {$fromInventory->quantity}");
                }
                $fromInventory?->subtract($quantity, 'Warehouse Transfer', null, $data['notes'] ?? null);
                $toInventory?->add($quantity, 'Warehouse Transfer', null, $data['notes'] ?? null);
                break;

            case 'return':
                $toInventory?->add($quantity, $data['reason'] ?? 'Return', null, $data['notes'] ?? null);
                break;

            case 'damage':
                if ($fromInventory && $fromInventory->quantity < $quantity) {
                    throw new \Exception("Insufficient stock. Available: {$fromInventory->quantity}");
                }
                $fromInventory?->subtract($quantity, $data['reason'] ?? 'Damaged', null, $data['notes'] ?? null);
                $fromInventory?->increment('damaged_stock', $quantity);
                break;

            case 'lost':
                if ($fromInventory && $fromInventory->quantity < $quantity) {
                    throw new \Exception("Insufficient stock. Available: {$fromInventory->quantity}");
                }
                $fromInventory?->subtract($quantity, $data['reason'] ?? 'Lost', null, $data['notes'] ?? null);
                break;

            case 'adjustment':
                $fromInventory?->update([
                    'last_stock_adjustment' => $data['reason'] ?? 'Adjustment',
                    'last_stock_update' => now(),
                ]);
                $diff = $quantity - $fromQtyBefore;
                if ($diff > 0) {
                    $fromInventory?->increment('quantity', $diff);
                } elseif ($diff < 0) {
                    $fromInventory?->decrement('quantity', abs($diff));
                }
                break;
        }

        $fromQtyAfter = $fromInventory?->quantity ?? 0;
        $toQtyAfter = $toInventory?->quantity ?? 0;

        return StockMovement::create([
            'product_id' => $data['product_id'],
            'product_variant_id' => $data['product_variant_id'] ?? null,
            'from_warehouse_id' => $data['from_warehouse_id'] ?? null,
            'to_warehouse_id' => $data['to_warehouse_id'] ?? null,
            'movement_type' => $type,
            'quantity' => $quantity,
            'quantity_before' => $type === 'transfer' ? $fromQtyBefore : ($fromQtyBefore ?: $toQtyBefore),
            'quantity_after' => $type === 'transfer' ? $fromQtyAfter : ($fromQtyAfter ?: $toQtyAfter),
            'reference_number' => StockMovement::generateReferenceNumber(),
            'reason' => $data['reason'] ?? null,
            'notes' => $data['notes'] ?? null,
            'causer_type' => auth()->guard('admin')->check() ? \App\Models\Admin::class : null,
            'causer_id' => auth()->guard('admin')->id(),
        ]);
    }

    private function getInventory(int $productId, ?int $variantId, int $warehouseId): ?Inventory
    {
        $query = Inventory::where('product_id', $productId)->where('warehouse_id', $warehouseId);

        if ($variantId) {
            $query->where('product_variant_id', $variantId);
        } else {
            $query->whereNull('product_variant_id');
        }

        return $query->first();
    }

    private function getOrCreateInventory(int $productId, ?int $variantId, int $warehouseId): Inventory
    {
        $query = Inventory::where('product_id', $productId)->where('warehouse_id', $warehouseId);

        if ($variantId) {
            $query->where('product_variant_id', $variantId);
        } else {
            $query->whereNull('product_variant_id');
        }

        return $query->firstOrCreate([], [
            'quantity' => 0,
            'reserved_quantity' => 0,
            'incoming_stock' => 0,
            'damaged_stock' => 0,
            'returned_stock' => 0,
            'low_stock_threshold' => 10,
        ]);
    }

    public function getWarehouseStock(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'warehouse_id' => ['required', 'integer', 'exists:warehouses,id'],
            'product_variant_id' => ['nullable', 'integer', 'exists:product_variants,id'],
        ]);

        $inventory = $this->getInventory(
            $request->product_id,
            $request->product_variant_id,
            $request->warehouse_id
        );

        return response()->json([
            'success' => true,
            'data' => [
                'quantity' => $inventory?->quantity ?? 0,
                'available' => ($inventory?->quantity ?? 0) - ($inventory?->reserved_quantity ?? 0),
                'reserved' => $inventory?->reserved_quantity ?? 0,
            ],
        ]);
    }

    public function getRecentMovements(Request $request): JsonResponse
    {
        $movements = StockMovement::with(['product', 'fromWarehouse', 'toWarehouse'])
            ->when($request->filled('product_id'), fn($q) => $q->where('product_id', $request->product_id))
            ->when($request->filled('warehouse_id'), function ($q) use ($request) {
                $q->where(function ($wq) use ($request) {
                    $wq->where('from_warehouse_id', $request->warehouse_id)
                       ->orWhere('to_warehouse_id', $request->warehouse_id);
                });
            })
            ->latest()
            ->limit($request->get('limit', 20))
            ->get()
            ->map(function ($m) {
                return [
                    'id' => $m->id,
                    'reference' => $m->reference_number,
                    'type' => $m->movement_type,
                    'product' => $m->product?->name,
                    'quantity' => $m->quantity,
                    'from' => $m->fromWarehouse?->name,
                    'to' => $m->toWarehouse?->name,
                    'date' => $m->created_at->format('M d, H:i'),
                    'reason' => $m->reason,
                ];
            });

        return response()->json(['success' => true, 'data' => $movements]);
    }
}
