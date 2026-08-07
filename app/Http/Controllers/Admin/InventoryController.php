<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\StockAdjustmentRequest;
use App\Models\Inventory;
use App\Models\InventoryLog;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\StockMovement;
use App\Models\Warehouse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class InventoryController extends Controller
{
    public function index(Request $request): View
    {
        $query = Inventory::with(['product', 'variant', 'warehouse'])
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where(function ($sq) use ($request) {
                    $sq->whereHas('product', function ($pq) use ($request) {
                        $pq->where('name', 'like', "%{$request->search}%")
                          ->orWhere('sku', 'like', "%{$request->search}%")
                          ->orWhere('barcode', 'like', "%{$request->search}%");
                    })->orWhereHas('variant', function ($vq) use ($request) {
                        $vq->where('sku', 'like', "%{$request->search}%")
                          ->orWhere('barcode', 'like', "%{$request->search}%")
                          ->orWhere('name', 'like', "%{$request->search}%");
                    });
                });
            })
            ->when($request->filled('warehouse_id'), fn($q) => $q->where('warehouse_id', $request->warehouse_id))
            ->when($request->filled('category_id'), function ($q) use ($request) {
                $q->whereHas('product', fn($pq) => $pq->where('category_id', $request->category_id));
            })
            ->when($request->filled('brand_id'), function ($q) use ($request) {
                $q->whereHas('product', fn($pq) => $pq->where('brand_id', $request->brand_id));
            })
            ->when($request->filled('stock_status'), function ($q) use ($request) {
                match ($request->stock_status) {
                    'low' => $q->lowStock(),
                    'out' => $q->outOfStock(),
                    'in' => $q->inStock(),
                    'overstock' => $q->whereColumn('quantity', '>', 'maximum_stock')->where('maximum_stock', '>', 0),
                    default => null,
                };
            });

        return view('admin.inventories.index', [
            'inventories' => $query->paginate($request->get('per_page', 15))->withQueryString(),
            'warehouses' => Cache::remember('active_warehouses', 3600, fn() => Warehouse::active()->sorted()->get()),
            'lowStockCount' => Inventory::lowStock()->count(),
            'outOfStockCount' => Inventory::outOfStock()->count(),
            'totalProducts' => Product::count(),
            'totalStockValue' => $this->getTotalStockValue(),
        ]);
    }

    public function stockIn(): View
    {
        return view('admin.inventories.stock-in', [
            'warehouses' => Cache::remember('active_warehouses', 3600, fn() => Warehouse::active()->sorted()->get()),
        ]);
    }

    public function stockInStore(StockAdjustmentRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $query = Inventory::where('product_id', $data['product_id'])
            ->where('warehouse_id', $data['warehouse_id']);

        if (isset($data['product_variant_id'])) {
            $query->where('product_variant_id', $data['product_variant_id']);
        } else {
            $query->whereNull('product_variant_id');
        }

        $inventory = $query->firstOrCreate([], [
            'quantity' => 0,
            'reserved_quantity' => 0,
            'incoming_stock' => 0,
            'damaged_stock' => 0,
            'returned_stock' => 0,
            'low_stock_threshold' => 10,
        ]);

        $inventory->add(
            $data['quantity'],
            $data['reason'] ?? 'Stock In',
            null,
            $data['note'] ?? null,
        );

        StockMovement::create([
            'product_id' => $data['product_id'],
            'product_variant_id' => $data['product_variant_id'] ?? null,
            'from_warehouse_id' => null,
            'to_warehouse_id' => $data['warehouse_id'],
            'movement_type' => 'stock_in',
            'quantity' => $data['quantity'],
            'quantity_before' => $inventory->quantity - $data['quantity'],
            'quantity_after' => $inventory->quantity,
            'reference_number' => StockMovement::generateReferenceNumber(),
            'reason' => $data['reason'] ?? 'Stock In',
            'notes' => $data['note'] ?? null,
            'causer_type' => auth()->guard('admin')->check() ? \App\Models\Admin::class : null,
            'causer_id' => auth()->guard('admin')->id(),
        ]);

        return redirect()
            ->route('admin.inventories.index')
            ->with('success', "Stock added successfully! (+{$data['quantity']})");
    }

    public function stockOut(): View
    {
        return view('admin.inventories.stock-out', [
            'warehouses' => Cache::remember('active_warehouses', 3600, fn() => Warehouse::active()->sorted()->get()),
        ]);
    }

    public function stockOutStore(StockAdjustmentRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $query = Inventory::where('product_id', $data['product_id'])
            ->where('warehouse_id', $data['warehouse_id']);

        if (isset($data['product_variant_id'])) {
            $query->where('product_variant_id', $data['product_variant_id']);
        } else {
            $query->whereNull('product_variant_id');
        }

        $inventory = $query->first();

        if (!$inventory) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'No inventory record found for this product in the selected warehouse.');
        }

        $success = $inventory->subtract(
            $data['quantity'],
            $data['reason'] ?? 'Stock Out',
            null,
            $data['note'] ?? null,
        );

        if (!$success) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', "Insufficient stock! Available: {$inventory->quantity}");
        }

        StockMovement::create([
            'product_id' => $data['product_id'],
            'product_variant_id' => $data['product_variant_id'] ?? null,
            'from_warehouse_id' => $data['warehouse_id'],
            'to_warehouse_id' => null,
            'movement_type' => 'stock_out',
            'quantity' => $data['quantity'],
            'quantity_before' => $inventory->quantity + $data['quantity'],
            'quantity_after' => $inventory->quantity,
            'reference_number' => StockMovement::generateReferenceNumber(),
            'reason' => $data['reason'] ?? 'Stock Out',
            'notes' => $data['note'] ?? null,
            'causer_type' => auth()->guard('admin')->check() ? \App\Models\Admin::class : null,
            'causer_id' => auth()->guard('admin')->id(),
        ]);

        return redirect()
            ->route('admin.inventories.index')
            ->with('success', "Stock removed successfully! (-{$data['quantity']})");
    }

    public function lowStock(Request $request): View
    {
        $query = Inventory::with(['product', 'variant', 'warehouse'])
            ->whereRaw('(quantity - reserved_quantity) <= low_stock_threshold')
            ->whereRaw('(quantity - reserved_quantity) >= 0')
            ->when($request->filled('warehouse_id'), fn($q) => $q->where('warehouse_id', $request->warehouse_id))
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->whereHas('product', fn($pq) => $pq->where('name', 'like', "%{$request->search}%")
                    ->orWhere('sku', 'like', "%{$request->search}%"));
            })
            ->orderByRaw('(quantity - reserved_quantity) ASC');

        return view('admin.inventories.low-stock', [
            'inventories' => $query->paginate($request->get('per_page', 15))->withQueryString(),
            'warehouses' => Warehouse::active()->sorted()->get(),
            'lowStockCount' => Inventory::lowStock()->count(),
            'outOfStockCount' => Inventory::outOfStock()->count(),
        ]);
    }

    public function history(Request $request): View
    {
        $query = InventoryLog::with(['product', 'variant', 'warehouse', 'causer'])
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->whereHas('product', fn($pq) => $pq->where('name', 'like', "%{$request->search}%")
                    ->orWhere('sku', 'like', "%{$request->search}%")
                    ->orWhere('barcode', 'like', "%{$request->search}%"));
            })
            ->when($request->filled('warehouse_id'), fn($q) => $q->where('warehouse_id', $request->warehouse_id))
            ->when($request->filled('change_type'), function ($q) use ($request) {
                $q->when($request->change_type === 'increase', fn($q) => $q->where('quantity_change', '>', 0));
                $q->when($request->change_type === 'decrease', fn($q) => $q->where('quantity_change', '<', 0));
            })
            ->when($request->filled('reference_type'), fn($q) => $q->where('reference_type', $request->reference_type))
            ->when($request->filled('date_from'), fn($q) => $q->whereDate('created_at', '>=', $request->date_from))
            ->when($request->filled('date_to'), fn($q) => $q->whereDate('created_at', '<=', $request->date_to));

        return view('admin.inventories.history', [
            'logs' => $query->latest()->paginate($request->get('per_page', 15))->withQueryString(),
            'warehouses' => Warehouse::active()->sorted()->get(),
        ]);
    }

    public function reports(Request $request): View
    {
        $warehouseId = $request->warehouse_id;

        $stockValueQuery = Inventory::select(
            'warehouse_id',
            DB::raw('SUM(quantity * COALESCE((SELECT price FROM products WHERE products.id = inventories.product_id), 0)) as stock_value'),
            DB::raw('SUM(quantity) as total_quantity'),
            DB::raw('COUNT(*) as total_items'),
        );

        if ($warehouseId) {
            $stockValueQuery->where('warehouse_id', $warehouseId);
        }

        $stockValueSummary = $stockValueQuery->groupBy('warehouse_id')
            ->with('warehouse')
            ->get();

        $movementSummary = InventoryLog::select(
            DB::raw("CASE WHEN quantity_change > 0 THEN 'in' ELSE 'out' END as movement_type"),
            DB::raw('SUM(ABS(quantity_change)) as total_quantity'),
            DB::raw('COUNT(*) as total_transactions'),
        )
            ->when($warehouseId, fn($q) => $q->where('warehouse_id', $warehouseId))
            ->when($request->filled('date_from'), fn($q) => $q->whereDate('created_at', '>=', $request->date_from))
            ->when($request->filled('date_to'), fn($q) => $q->whereDate('created_at', '<=', $request->date_to))
            ->groupBy('movement_type')
            ->get();

        $lowStockCount = Inventory::lowStock()->count();
        $outOfStockCount = Inventory::outOfStock()->count();
        $totalInventoryValue = $this->getTotalStockValue();

        $stockSummaryByWarehouse = Warehouse::active()->sorted()->get()->map(function ($w) {
            $inventory = Inventory::where('warehouse_id', $w->id);
            return [
                'warehouse' => $w->name,
                'total_items' => $inventory->count(),
                'total_quantity' => $inventory->sum('quantity'),
                'low_stock' => (clone $inventory)->lowStock()->count(),
                'out_of_stock' => (clone $inventory)->outOfStock()->count(),
                'value' => Inventory::join('products', 'inventories.product_id', '=', 'products.id')
                    ->where('inventories.warehouse_id', $w->id)
                    ->selectRaw('SUM(inventories.quantity * products.price) as total')
                    ->value('total') ?? 0,
            ];
        });

        return view('admin.inventories.reports', [
            'warehouses' => Warehouse::active()->sorted()->get(),
            'stockValueSummary' => $stockValueSummary,
            'movementSummary' => $movementSummary,
            'lowStockCount' => $lowStockCount,
            'outOfStockCount' => $outOfStockCount,
            'totalInventoryValue' => $totalInventoryValue,
            'stockSummaryByWarehouse' => $stockSummaryByWarehouse,
        ]);
    }

    public function alerts(): View
    {
        $lowStockItems = Inventory::with(['product', 'variant', 'warehouse'])
            ->lowStock()
            ->orderByRaw('(quantity - reserved_quantity) ASC')
            ->limit(50)
            ->get();

        $outOfStockItems = Inventory::with(['product', 'variant', 'warehouse'])
            ->outOfStock()
            ->orderBy('updated_at', 'desc')
            ->limit(50)
            ->get();

        $overstockItems = Inventory::with(['product', 'variant', 'warehouse'])
            ->whereColumn('quantity', '>', 'maximum_stock')
            ->where('maximum_stock', '>', 0)
            ->orderByRaw('(quantity - maximum_stock) DESC')
            ->limit(20)
            ->get();

        $needsReorder = Inventory::with(['product', 'variant', 'warehouse'])
            ->where('reorder_level', '>', 0)
            ->whereRaw('(quantity - reserved_quantity) <= reorder_level')
            ->whereRaw('(quantity - reserved_quantity) > 0')
            ->orderByRaw('(quantity - reserved_quantity) ASC')
            ->limit(20)
            ->get();

        return view('admin.inventories.alerts', [
            'lowStockItems' => $lowStockItems,
            'outOfStockItems' => $outOfStockItems,
            'overstockItems' => $overstockItems,
            'needsReorder' => $needsReorder,
            'lowStockCount' => Inventory::lowStock()->count(),
            'outOfStockCount' => Inventory::outOfStock()->count(),
        ]);
    }

    public function getProductByBarcode(Request $request): JsonResponse
    {
        $request->validate(['barcode' => ['required', 'string', 'max:255']]);

        $product = Product::where('barcode', $request->barcode)->first();

        if ($product) {
            return response()->json([
                'success' => true,
                'type' => 'product',
                'data' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'sku' => $product->sku,
                    'barcode' => $product->barcode,
                    'stock' => $product->stock,
                    'price' => $product->price,
                    'image' => $product->thumbnail_url,
                ],
            ]);
        }

        $variant = ProductVariant::where('barcode', $request->barcode)->with('product')->first();

        if ($variant) {
            return response()->json([
                'success' => true,
                'type' => 'variant',
                'data' => [
                    'id' => $variant->id,
                    'product_id' => $variant->product_id,
                    'name' => $variant->product->name . ' - ' . $variant->name,
                    'sku' => $variant->sku,
                    'barcode' => $variant->barcode,
                    'stock' => $variant->stock,
                    'price' => $variant->price,
                ],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No product or variant found with this barcode.',
        ]);
    }

    public function getProducts(Request $request): JsonResponse
    {
        $request->validate([
            'search' => ['required', 'string', 'min:1'],
        ]);

        $products = Product::where(function ($q) use ($request) {
            $q->where('name', 'like', "%{$request->search}%")
              ->orWhere('sku', 'like', "%{$request->search}%")
              ->orWhere('barcode', 'like', "%{$request->search}%");
        })->limit(20)->get(['id', 'name', 'sku', 'barcode', 'price', 'thumbnail']);

        $variants = ProductVariant::with('product')
            ->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('sku', 'like', "%{$request->search}%")
                  ->orWhere('barcode', 'like', "%{$request->search}%");
            })->limit(20)->get(['id', 'product_id', 'name', 'sku', 'barcode', 'price']);

        $results = collect();

        foreach ($products as $product) {
            $results->push([
                'id' => $product->id,
                'variant_id' => null,
                'text' => "{$product->name} ({$product->sku})",
                'barcode' => $product->barcode,
                'type' => 'product',
                'price' => $product->price,
            ]);
        }

        foreach ($variants as $variant) {
            $results->push([
                'id' => $variant->product_id,
                'variant_id' => $variant->id,
                'text' => "{$variant->product->name} - {$variant->name} ({$variant->sku})",
                'barcode' => $variant->barcode,
                'type' => 'variant',
                'price' => $variant->price ?? $variant->product->price,
            ]);
        }

        return response()->json($results->take(20));
    }

    public function dashboardData(): JsonResponse
    {
        $lowStock = Inventory::lowStock()->count();
        $outOfStock = Inventory::outOfStock()->count();
        $totalItems = Inventory::sum('quantity');
        $totalReserved = Inventory::sum('reserved_quantity');
        $totalValue = $this->getTotalStockValue();

        $recentMovements = StockMovement::with(['product', 'fromWarehouse', 'toWarehouse'])
            ->latest()
            ->limit(10)
            ->get()
            ->map(fn($m) => [
                'id' => $m->id,
                'reference' => $m->reference_number,
                'type' => $m->movement_type,
                'product' => $m->product?->name,
                'quantity' => $m->quantity,
                'from' => $m->fromWarehouse?->name,
                'to' => $m->toWarehouse?->name,
                'date' => $m->created_at->diffForHumans(),
            ]);

        $stockByWarehouse = Warehouse::active()->get()->map(fn($w) => [
            'name' => $w->name,
            'total' => Inventory::where('warehouse_id', $w->id)->sum('quantity'),
            'value' => Inventory::join('products', 'inventories.product_id', '=', 'products.id')
                ->where('inventories.warehouse_id', $w->id)
                ->selectRaw('SUM(inventories.quantity * products.price) as total')
                ->value('total') ?? 0,
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'low_stock' => $lowStock,
                'out_of_stock' => $outOfStock,
                'total_items' => $totalItems,
                'total_reserved' => $totalReserved,
                'total_value' => $totalValue,
                'recent_movements' => $recentMovements,
                'stock_by_warehouse' => $stockByWarehouse,
            ],
        ]);
    }

    public function exportCsv(Request $request)
    {
        $inventories = Inventory::with(['product', 'variant', 'warehouse'])
            ->when($request->filled('warehouse_id'), fn($q) => $q->where('warehouse_id', $request->warehouse_id))
            ->get();

        $filename = 'inventory-export-' . now()->format('Y-m-d-His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function () use ($inventories) {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'Product', 'SKU', 'Barcode', 'Warehouse', 'Quantity',
                'Reserved', 'Available', 'Incoming', 'Damaged', 'Returned',
                'Min Stock', 'Max Stock', 'Reorder Level', 'Status',
            ]);

            foreach ($inventories as $inv) {
                $productName = $inv->variant
                    ? ($inv->variant->product->name ?? '') . ' - ' . $inv->variant->name
                    : ($inv->product->name ?? 'Deleted');
                $sku = $inv->variant?->sku ?? $inv->product?->sku ?? '';
                $barcode = $inv->variant?->barcode ?? $inv->product?->barcode ?? '';
                $available = $inv->quantity - $inv->reserved_quantity;
                $status = $available <= 0 ? 'Out of Stock' : ($available <= $inv->low_stock_threshold ? 'Low Stock' : 'In Stock');

                fputcsv($file, [
                    $productName,
                    $sku,
                    $barcode,
                    $inv->warehouse?->name ?? '',
                    $inv->quantity,
                    $inv->reserved_quantity,
                    $available,
                    $inv->incoming_stock,
                    $inv->damaged_stock,
                    $inv->returned_stock,
                    $inv->minimum_stock,
                    $inv->maximum_stock,
                    $inv->reorder_level,
                    $status,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportExcel(Request $request)
    {
        $inventories = Inventory::with(['product', 'variant', 'warehouse'])
            ->when($request->filled('warehouse_id'), fn($q) => $q->where('warehouse_id', $request->warehouse_id))
            ->get();

        $filename = 'inventory-export-' . now()->format('Y-m-d-His') . '.xls';
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function () use ($inventories) {
            echo '<table border="1">';
            echo '<thead><tr>
                <th>Product</th><th>SKU</th><th>Barcode</th><th>Warehouse</th>
                <th>Quantity</th><th>Reserved</th><th>Available</th><th>Incoming</th>
                <th>Damaged</th><th>Returned</th><th>Min Stock</th><th>Max Stock</th>
                <th>Reorder Level</th><th>Status</th>
            </tr></thead><tbody>';

            foreach ($inventories as $inv) {
                $productName = $inv->variant
                    ? ($inv->variant->product->name ?? '') . ' - ' . $inv->variant->name
                    : ($inv->product->name ?? 'Deleted');
                $available = $inv->quantity - $inv->reserved_quantity;
                $status = $available <= 0 ? 'Out of Stock' : ($available <= $inv->low_stock_threshold ? 'Low Stock' : 'In Stock');

                echo '<tr>';
                echo '<td>' . htmlspecialchars($productName) . '</td>';
                echo '<td>' . htmlspecialchars($inv->variant?->sku ?? $inv->product?->sku ?? '') . '</td>';
                echo '<td>' . htmlspecialchars($inv->variant?->barcode ?? $inv->product?->barcode ?? '') . '</td>';
                echo '<td>' . htmlspecialchars($inv->warehouse?->name ?? '') . '</td>';
                echo '<td>' . $inv->quantity . '</td>';
                echo '<td>' . $inv->reserved_quantity . '</td>';
                echo '<td>' . $available . '</td>';
                echo '<td>' . $inv->incoming_stock . '</td>';
                echo '<td>' . $inv->damaged_stock . '</td>';
                echo '<td>' . $inv->returned_stock . '</td>';
                echo '<td>' . $inv->minimum_stock . '</td>';
                echo '<td>' . $inv->maximum_stock . '</td>';
                echo '<td>' . $inv->reorder_level . '</td>';
                echo '<td>' . $status . '</td>';
                echo '</tr>';
            }

            echo '</tbody></table>';
        };

        return response()->stream($callback, 200, $headers);
    }

    private function getTotalStockValue(): float
    {
        return (float) Inventory::join('products', 'inventories.product_id', '=', 'products.id')
            ->select(DB::raw('SUM(inventories.quantity * products.price) as total'))
            ->value('total') ?? 0;
    }
}
