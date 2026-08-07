<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Purchase\GoodsReceiptRequest;
use App\Http\Requests\Purchase\PurchasePaymentRequest;
use App\Http\Requests\Purchase\PurchaseReturnRequest;
use App\Http\Requests\Purchase\StorePurchaseRequest;
use App\Http\Requests\Purchase\UpdatePurchaseRequest;
use App\Models\Admin;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\PurchasePayment;
use App\Models\PurchaseReturn;
use App\Models\Supplier;
use App\Models\Warehouse;
use App\Services\GoodsReceiptService;
use App\Services\PurchasePaymentService;
use App\Services\PurchaseReturnService;
use App\Services\PurchaseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PurchaseController extends Controller
{
    public function __construct(
        protected PurchaseService $purchaseService,
        protected GoodsReceiptService $goodsReceiptService,
        protected PurchasePaymentService $paymentService,
        protected PurchaseReturnService $returnService,
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'status', 'payment_status', 'supplier_id', 'warehouse_id', 'date_from', 'date_to']);
        $perPage = $request->get('per_page', 15);

        $purchases = app(\App\Repositories\PurchaseRepository::class)
            ->paginateWithFilters($filters, $perPage);

        $stats = app(\App\Repositories\PurchaseRepository::class)->getStats();

        return view('admin.purchases.index', [
            'purchases' => $purchases,
            'stats' => $stats,
            'suppliers' => Cache::remember('active_suppliers', 3600, fn() => Supplier::active()->orderBy('name')->get(['id', 'name', 'supplier_code'])),
            'warehouses' => Cache::remember('active_warehouses', 3600, fn() => Warehouse::active()->sorted()->get(['id', 'name', 'code'])),
            'filters' => $filters,
        ]);
    }

    public function create(): View
    {
        return view('admin.purchases.create', [
            'suppliers' => Supplier::active()->orderBy('name')->get(['id', 'name', 'supplier_code', 'currency']),
            'warehouses' => Warehouse::active()->sorted()->get(['id', 'name', 'code']),
            'products' => Product::with(['variants'])->select(['id', 'name', 'sku', 'barcode', 'cost_price', 'price'])->get(),
        ]);
    }

    public function store(StorePurchaseRequest $request): RedirectResponse
    {
        try {
            $admin = $request->user('admin');
            $purchase = $this->purchaseService->createPurchase($request->validated(), $admin);

            return redirect()
                ->route('admin.purchases.show', $purchase->id)
                ->with('success', "Purchase Order {$purchase->po_number} created successfully!");
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function show(Purchase $purchase): View
    {
        $purchase->load([
            'supplier',
            'warehouse',
            'items.product',
            'items.variant',
            'goodsReceipts.items.product',
            'goodsReceipts.receiver',
            'payments.creator',
            'returns.product',
            'returns.variant',
            'returns.creator',
            'creator',
            'approver',
        ]);

        return view('admin.purchases.show', [
            'purchase' => $purchase,
        ]);
    }

    public function edit(Purchase $purchase): View
    {
        if (!$purchase->isEditable()) {
            abort(403, 'Purchase order cannot be edited in current status.');
        }

        $purchase->load('items.product', 'items.variant');

        return view('admin.purchases.edit', [
            'purchase' => $purchase,
            'suppliers' => Supplier::active()->orderBy('name')->get(['id', 'name', 'supplier_code', 'currency']),
            'warehouses' => Warehouse::active()->sorted()->get(['id', 'name', 'code']),
            'products' => Product::with(['variants'])->select(['id', 'name', 'sku', 'barcode', 'cost_price', 'price'])->get(),
        ]);
    }

    public function update(UpdatePurchaseRequest $request, Purchase $purchase): RedirectResponse
    {
        if (!$purchase->isEditable()) {
            return redirect()->back()->with('error', 'Purchase order cannot be edited in current status.');
        }

        try {
            $this->purchaseService->updatePurchase($purchase->id, $request->validated());

            return redirect()
                ->route('admin.purchases.show', $purchase->id)
                ->with('success', "Purchase Order {$purchase->po_number} updated successfully!");
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function destroy(Purchase $purchase): RedirectResponse
    {
        if (!$purchase->isDeletable()) {
            return redirect()->back()->with('error', 'Only draft or cancelled purchase orders can be deleted.');
        }

        try {
            $purchase->delete();
            return redirect()
                ->route('admin.purchases.index')
                ->with('success', "Purchase Order {$purchase->po_number} deleted successfully!");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function approve(int $id): RedirectResponse
    {
        try {
            $admin = request()->user('admin');
            $purchase = $this->purchaseService->approve($id, $admin);

            return redirect()
                ->route('admin.purchases.show', $purchase->id)
                ->with('success', "Purchase Order {$purchase->po_number} approved successfully!");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function reject(int $id, Request $request): RedirectResponse
    {
        try {
            $admin = $request->user('admin');
            $this->purchaseService->reject($id, $admin);

            return redirect()
                ->route('admin.purchases.index')
                ->with('success', 'Purchase order rejected.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function markOrdered(int $id): RedirectResponse
    {
        try {
            $admin = request()->user('admin');
            $purchase = $this->purchaseService->markAsOrdered($id, $admin);

            return redirect()
                ->route('admin.purchases.show', $purchase->id)
                ->with('success', "Purchase Order {$purchase->po_number} marked as ordered!");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function cancel(int $id): RedirectResponse
    {
        try {
            $this->purchaseService->cancel($id);

            return redirect()
                ->route('admin.purchases.index')
                ->with('success', 'Purchase order cancelled.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function clone(int $id): RedirectResponse
    {
        try {
            $newPurchase = $this->purchaseService->clonePurchase($id);

            return redirect()
                ->route('admin.purchases.edit', $newPurchase->id)
                ->with('success', 'Purchase order cloned. Please review before saving.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function print(Purchase $purchase): View
    {
        $purchase->load(['supplier', 'warehouse', 'items.product', 'items.variant', 'creator']);

        return view('admin.purchases.print', compact('purchase'));
    }

    public function goodsReceipt(GoodsReceiptRequest $request, int $id): RedirectResponse
    {
        try {
            $admin = $request->user('admin');
            $type = $request->input('receipt_type');

            $receipt = match ($type) {
                'full' => $this->goodsReceiptService->receiveFull($id, $admin, $request->input('notes')),
                'remaining' => $this->goodsReceiptService->receiveRemaining($id, $admin, $request->input('notes')),
                'partial' => $this->goodsReceiptService->receivePartial($id, $admin, $request->input('items', []), $request->input('notes')),
                default => throw new \RuntimeException('Invalid receipt type.'),
            };

            return redirect()
                ->route('admin.purchases.show', $id)
                ->with('success', "Goods received successfully! GRN: {$receipt->grn_number}");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function addPayment(PurchasePaymentRequest $request, int $id): RedirectResponse
    {
        try {
            $admin = $request->user('admin');
            $this->paymentService->makePayment($id, $request->validated(), $admin);

            return redirect()
                ->route('admin.purchases.show', $id)
                ->with('success', 'Payment added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function returnGoods(PurchaseReturnRequest $request, int $id): RedirectResponse
    {
        try {
            $admin = $request->user('admin');
            $returns = $this->returnService->returnItems($id, $request->input('items'), $admin);

            return redirect()
                ->route('admin.purchases.show', $id)
                ->with('success', count($returns) . ' item(s) returned successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function getProducts(Request $request): JsonResponse
    {
        $search = $request->get('search', '');

        $products = Product::where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('sku', 'like', "%{$search}%")
                ->orWhere('barcode', 'like', "%{$search}%");
        })
            ->with('variants')
            ->take(20)
            ->get();

        $results = $products->flatMap(function ($product) {
            $items = [];

            if ($product->variants->isNotEmpty()) {
                foreach ($product->variants as $variant) {
                    $items[] = [
                        'id' => $product->id,
                        'variant_id' => $variant->id,
                        'text' => $product->name . ' - ' . $variant->name . ' (' . ($variant->sku ?? $product->sku) . ')',
                        'sku' => $variant->sku ?? $product->sku,
                        'price' => $variant->price ?? $product->cost_price ?? $product->price,
                        'barcode' => $variant->barcode ?? $product->barcode,
                    ];
                }
            } else {
                $items[] = [
                    'id' => $product->id,
                    'variant_id' => null,
                    'text' => $product->name . ' (' . $product->sku . ')',
                    'sku' => $product->sku,
                    'price' => $product->cost_price ?? $product->price,
                    'barcode' => $product->barcode,
                ];
            }

            return $items;
        });

        return response()->json($results);
    }

    public function reports(): View
    {
        return view('admin.purchases.reports.index');
    }

    public function purchaseReport(Request $request): View
    {
        $filters = $request->only(['search', 'status', 'date_from', 'date_to']);
        $purchases = $this->purchaseService->getReportData($filters);

        return view('admin.purchases.reports.purchase', compact('purchases'));
    }

    public function supplierReport(Request $request): View
    {
        $suppliers = Cache::remember('active_suppliers', 3600, fn() => Supplier::active()->orderBy('name')->get(['id', 'name']));
        $filters = $request->only(['supplier_id', 'date_from', 'date_to']);
        $purchases = $filters['supplier_id']
            ? $this->purchaseService->getSupplierReport($filters['supplier_id'], $filters)
            : $this->purchaseService->getReportData($filters);

        return view('admin.purchases.reports.supplier', compact('purchases', 'suppliers'));
    }

    public function paymentReport(Request $request): View
    {
        $filters = $request->only(['date_from', 'date_to', 'payment_method', 'supplier_id']);
        $payments = $this->purchaseService->getPaymentReport($filters);

        return view('admin.purchases.reports.payment', compact('payments'));
    }

    public function outstandingDueReport(Request $request): View
    {
        $suppliers = Cache::remember('active_suppliers', 3600, fn() => Supplier::active()->orderBy('name')->get(['id', 'name']));
        $filters = $request->only(['supplier_id', 'date_from', 'date_to']);
        $purchases = $this->purchaseService->getOutstandingReport($filters);

        return view('admin.purchases.reports.due', compact('purchases', 'suppliers'));
    }

    public function returnReport(Request $request): View
    {
        $filters = $request->only(['date_from', 'date_to', 'refund_status', 'supplier_id']);
        $returns = $this->purchaseService->getReturnReport($filters);

        return view('admin.purchases.reports.return', compact('returns'));
    }

    public function exportCsv(Request $request): \Illuminate\Http\Response
    {
        $filters = $request->only(['search', 'status', 'payment_status', 'date_from', 'date_to']);
        $purchases = app(\App\Repositories\PurchaseRepository::class)
            ->getReportData($filters)
            ->get();

        $filename = 'purchases-' . now()->format('Y-m-d-His') . '.csv';
        $handle = fopen('php://temp', 'w+');

        fputcsv($handle, [
            'PO Number', 'Supplier', 'Warehouse', 'Date', 'Status',
            'Payment Status', 'Items', 'Subtotal', 'Discount',
            'Tax', 'Shipping', 'Total', 'Paid', 'Due', 'Created At',
        ]);

        foreach ($purchases as $purchase) {
            fputcsv($handle, [
                $purchase->po_number,
                $purchase->supplier?->name,
                $purchase->warehouse?->name,
                $purchase->purchase_date?->format('Y-m-d'),
                $purchase->status->label(),
                $purchase->payment_status->label(),
                $purchase->items->count(),
                $purchase->subtotal,
                $purchase->discount_amount,
                $purchase->tax_amount,
                $purchase->shipping_cost,
                $purchase->total_amount,
                $purchase->paid_amount,
                $purchase->due_amount,
                $purchase->created_at?->format('Y-m-d H:i:s'),
            ]);
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return response($content, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }

    public function exportExcel(Request $request): \Illuminate\Http\Response
    {
        $filters = $request->only(['search', 'status', 'payment_status', 'date_from', 'date_to']);
        $purchases = app(\App\Repositories\PurchaseRepository::class)
            ->getReportData($filters)
            ->get();

        $html = '<table>';
        $html .= '<thead><tr>
            <th>PO Number</th><th>Supplier</th><th>Warehouse</th><th>Date</th>
            <th>Status</th><th>Payment</th><th>Items</th><th>Subtotal</th>
            <th>Discount</th><th>Tax</th><th>Shipping</th><th>Total</th>
            <th>Paid</th><th>Due</th><th>Created</th>
        </tr></thead><tbody>';

        foreach ($purchases as $purchase) {
            $html .= '<tr>';
            $html .= '<td>' . $purchase->po_number . '</td>';
            $html .= '<td>' . ($purchase->supplier?->name ?? '') . '</td>';
            $html .= '<td>' . ($purchase->warehouse?->name ?? '') . '</td>';
            $html .= '<td>' . ($purchase->purchase_date?->format('Y-m-d') ?? '') . '</td>';
            $html .= '<td>' . $purchase->status->label() . '</td>';
            $html .= '<td>' . $purchase->payment_status->label() . '</td>';
            $html .= '<td>' . $purchase->items->count() . '</td>';
            $html .= '<td>' . $purchase->subtotal . '</td>';
            $html .= '<td>' . $purchase->discount_amount . '</td>';
            $html .= '<td>' . $purchase->tax_amount . '</td>';
            $html .= '<td>' . $purchase->shipping_cost . '</td>';
            $html .= '<td>' . $purchase->total_amount . '</td>';
            $html .= '<td>' . $purchase->paid_amount . '</td>';
            $html .= '<td>' . $purchase->due_amount . '</td>';
            $html .= '<td>' . ($purchase->created_at?->format('Y-m-d H:i:s') ?? '') . '</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody></table>';

        return response($html, 200, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="purchases-' . now()->format('Y-m-d-His') . '.xls"',
        ]);
    }
}
