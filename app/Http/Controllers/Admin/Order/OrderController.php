<?php

namespace App\Http\Controllers\Admin\Order;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Warehouse;
use App\Repositories\OrderRepository;
use App\Services\NotificationService;
use App\Services\OrderExportService;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(
        protected OrderService $orderService,
        protected OrderRepository $orderRepository,
        protected OrderExportService $exportService,
        protected NotificationService $notificationService
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->only([
            'status', 'payment_status', 'search', 'date_from', 'date_to',
            'order_origin', 'carrier', 'sort', 'sort_dir', 'per_page',
        ]);

        $orders = $this->orderRepository->getAll($filters);
        $statusCounts = Order::getStatusCounts();

        return view('admin.orders.index', compact('orders', 'statusCounts', 'filters'));
    }

    public function show(Order $order): View
    {
        $order = $this->orderRepository->findById($order->id);

        if (!$order) {
            abort(404);
        }

        $allowedTransitions = $this->orderService->getAllowedTransitions($order);
        $timeline = $this->orderService->getOrderTimeline($order);

        return view('admin.orders.show', compact('order', 'allowedTransitions', 'timeline'));
    }

    public function create(Request $request): View
    {
        $customers = User::where('status', true)->orderBy('name')->get(['id', 'name', 'email', 'phone']);
        $products = Product::where('status', 'active')->orderBy('name')->get(['id', 'name', 'sku', 'price', 'thumbnail']);
        $warehouses = Warehouse::active()->get(['id', 'name']);

        $selectedCustomer = null;
        if ($request->filled('customer_id')) {
            $selectedCustomer = User::find($request->customer_id);
        }

        return view('admin.orders.create', compact('customers', 'products', 'warehouses', 'selectedCustomer'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'shipping_method' => 'nullable|string|max:100',
            'shipping_cost' => 'nullable|numeric|min:0',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'tax_amount' => 'nullable|numeric|min:0',
            'coupon_discount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
            'payment_method' => 'nullable|string|max:50',
            'shipping_address.name' => 'required_without:user_id|string|max:255',
            'shipping_address.email' => 'nullable|email|max:255',
            'shipping_address.phone' => 'nullable|string|max:20',
            'shipping_address.address_line1' => 'required_without:user_id|string|max:255',
            'shipping_address.city' => 'required_without:user_id|string|max:100',
            'shipping_address.state' => 'nullable|string|max:100',
            'shipping_address.zip' => 'nullable|string|max:20',
            'shipping_address.country' => 'nullable|string|max:100',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'nullable|exists:products,id',
            'items.*.product_name' => 'required|string|max:255',
            'items.*.product_sku' => 'nullable|string|max:100',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0',
            'items.*.subtotal' => 'required|numeric|min:0',
        ]);

        $validated['order_origin'] = 'manual';

        if (!$request->filled('shipping_address.name') && $request->filled('user_id')) {
            $customer = User::find($request->user_id);
            $validated['shipping_address'] = [
                'name' => $customer->name,
                'email' => $customer->email,
                'phone' => $customer->phone ?? '',
                'address_line1' => '',
                'city' => '',
                'state' => '',
                'zip' => '',
                'country' => 'US',
            ];
        }

        try {
            $order = $this->orderService->createFromData($validated, auth()->guard('admin')->id());

            if ($order->user) {
                $this->notificationService->send(
                    $order->user,
                    'new_order',
                    [
                        'title' => "New order #{$order->order_number} has been created",
                        'order_number' => $order->order_number,
                        'total' => $order->total,
                        'icon' => 'shopping-bag',
                        'color' => 'primary',
                    ]
                );
            }

            return redirect()->route('admin.orders.show', $order)
                ->with('success', "Order #{$order->order_number} created successfully.");
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to create order: ' . $e->getMessage());
        }
    }

    public function edit(Order $order): View
    {
        if (!$order->isEditable()) {
            abort(403, 'This order cannot be edited.');
        }

        $order->load(['items', 'payment', 'user:id,name,email,phone']);
        $customers = User::where('status', true)->orderBy('name')->get(['id', 'name', 'email', 'phone']);
        $products = Product::where('status', 'active')->orderBy('name')->get(['id', 'name', 'sku', 'price', 'thumbnail']);

        return view('admin.orders.edit', compact('order', 'customers', 'products'));
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        if (!$order->isEditable()) {
            return back()->with('error', 'This order cannot be edited.');
        }

        $validated = $request->validate([
            'shipping_method' => 'nullable|string|max:100',
            'shipping_cost' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
            'tracking_number' => 'nullable|string|max:100',
            'tracking_url' => 'nullable|url|max:500',
            'carrier' => 'nullable|string|max:100',
            'cancel_reason' => 'nullable|string|max:500',
            'shipping_address.name' => 'nullable|string|max:255',
            'shipping_address.email' => 'nullable|email|max:255',
            'shipping_address.phone' => 'nullable|string|max:20',
            'shipping_address.address_line1' => 'nullable|string|max:255',
            'shipping_address.city' => 'nullable|string|max:100',
            'shipping_address.state' => 'nullable|string|max:100',
            'shipping_address.zip' => 'nullable|string|max:20',
            'shipping_address.country' => 'nullable|string|max:100',
            'items' => 'nullable|array',
            'items.*.product_name' => 'required_with:items|string|max:255',
            'items.*.quantity' => 'required_with:items|integer|min:1',
            'items.*.unit_price' => 'required_with:items|numeric|min:0',
            'items.*.subtotal' => 'required_with:items|numeric|min:0',
        ]);

        try {
            $order = $this->orderService->updateOrder($order, $validated);
            $this->orderRepository->clearCache($order->id);

            return redirect()->route('admin.orders.show', $order)
                ->with('success', 'Order updated successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to update order: ' . $e->getMessage());
        }
    }

    public function destroy(Order $order): RedirectResponse
    {
        if (!$order->isDeletable()) {
            return back()->with('error', 'Only pending or cancelled orders can be deleted.');
        }

        $order->items()->delete();
        $order->payment()?->delete();
        $order->transactions()?->delete();
        $order->delete();

        $this->orderRepository->clearCache($order->id);

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order deleted successfully.');
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $request->validate([
            'status' => 'required|string|in:' . implode(',', array_column(OrderStatus::cases(), 'value')),
            'cancel_reason' => 'required_if:status,cancelled|string|max:500',
        ]);

        $newStatus = OrderStatus::from($request->status);

        if (!$this->orderService->canTransition($order, $newStatus)) {
            return back()->with('error', "Cannot transition from '{$order->status}' to '{$newStatus->value}'.");
        }

        try {
            $order = $this->orderService->transition(
                $order,
                $newStatus,
                $request->cancel_reason,
                auth()->guard('admin')->id()
            );

            if ($request->filled('tracking_number')) {
                $order = $this->orderService->updateTracking(
                    $order,
                    $request->tracking_number,
                    $request->carrier,
                    $request->tracking_url,
                    $request->estimated_delivery
                );
            }

            $this->orderRepository->clearCache($order->id);

            if ($order->user) {
                $this->notifyCustomer($order, $newStatus);
            }

            return back()->with('success', "Order status updated to {$newStatus->label()}.");
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function updateTracking(Request $request, Order $order): RedirectResponse
    {
        $request->validate([
            'tracking_number' => 'required|string|max:100',
            'carrier' => 'nullable|string|max:100',
            'tracking_url' => 'nullable|url|max:500',
            'estimated_delivery' => 'nullable|date',
        ]);

        $order = $this->orderService->updateTracking(
            $order,
            $request->tracking_number,
            $request->carrier,
            $request->tracking_url,
            $request->estimated_delivery
        );

        $this->orderRepository->clearCache($order->id);

        if ($order->user) {
            $this->notificationService->orderShipped(
                $order->user,
                $order->order_number,
                $request->tracking_number
            );
        }

        return back()->with('success', 'Tracking information updated.');
    }

    public function markPaid(Request $request, Order $order): RedirectResponse
    {
        $request->validate(['reference' => 'nullable|string|max:100']);

        try {
            $order = $this->orderService->markPaid(
                $order,
                $request->reference,
                auth()->guard('admin')->id()
            );

            $this->orderRepository->clearCache($order->id);

            if ($order->user) {
                $this->notificationService->send(
                    $order->user,
                    'payment_received',
                    [
                        'title' => "Payment received for order #{$order->order_number}",
                        'order_number' => $order->order_number,
                        'amount' => $order->total,
                        'icon' => 'credit-card',
                        'color' => 'success',
                    ]
                );
            }

            return back()->with('success', 'Payment marked as paid.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function markPartialPaid(Request $request, Order $order): RedirectResponse
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'reference' => 'nullable|string|max:100',
        ]);

        try {
            $order = $this->orderService->markPartialPaid(
                $order,
                $request->amount,
                $request->reference,
                auth()->guard('admin')->id()
            );

            $this->orderRepository->clearCache($order->id);

            return back()->with('success', 'Partial payment recorded.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function markFailed(Request $request, Order $order): RedirectResponse
    {
        $order->update(['payment_status' => 'failed']);
        $order->payment()?->update(['payment_status' => 'failed']);

        $this->orderRepository->clearCache($order->id);

        return back()->with('success', 'Payment marked as failed.');
    }

    public function refund(Request $request, Order $order): RedirectResponse
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01|max:' . $order->paid_amount,
            'reason' => 'nullable|string|max:500',
        ]);

        try {
            $order = $this->orderService->refund(
                $order,
                $request->amount,
                $request->reason,
                auth()->guard('admin')->id()
            );

            $this->orderRepository->clearCache($order->id);

            return back()->with('success', 'Refund processed successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function duplicate(Order $order): RedirectResponse
    {
        try {
            $newOrder = $this->orderService->duplicateOrder(
                $order,
                auth()->guard('admin')->id()
            );

            return redirect()->route('admin.orders.show', $newOrder)
                ->with('success', "Order duplicated as #{$newOrder->order_number}.");
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to duplicate order: ' . $e->getMessage());
        }
    }

    public function print(Order $order): View
    {
        $order->load(['items', 'payment', 'user']);
        return view('admin.orders.print', compact('order'));
    }

    public function invoice(Order $order): View
    {
        $order->load(['items', 'payment']);
        return view('admin.orders.invoice', compact('order'));
    }

    public function exportCsv(Request $request): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        return $this->exportService->exportCsv($request->only([
            'status', 'payment_status', 'date_from', 'date_to',
        ]));
    }

    public function exportExcel(Request $request): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        return $this->exportService->exportExcel($request->only([
            'status', 'payment_status', 'date_from', 'date_to',
        ]));
    }

    public function getProducts(Request $request): \Illuminate\Http\JsonResponse
    {
        $term = $request->get('q', '');
        $products = Product::where('status', 'active')
            ->where(function ($q) use ($term) {
                $q->where('name', 'LIKE', "%{$term}%")
                  ->orWhere('sku', 'LIKE', "%{$term}%")
                  ->orWhere('barcode', 'LIKE', "%{$term}%");
            })
            ->limit(20)
            ->get(['id', 'name', 'sku', 'price', 'thumbnail', 'tax']);

        return response()->json($products);
    }

    public function getCustomers(Request $request): \Illuminate\Http\JsonResponse
    {
        $term = $request->get('q', '');
        $customers = User::where(function ($q) use ($term) {
            $q->where('name', 'LIKE', "%{$term}%")
              ->orWhere('email', 'LIKE', "%{$term}%")
              ->orWhere('phone', 'LIKE', "%{$term}%");
        })
        ->limit(20)
        ->get(['id', 'name', 'email', 'phone']);

        return response()->json($customers);
    }

    protected function notifyCustomer(Order $order, OrderStatus $status): void
    {
        match ($status) {
            OrderStatus::Confirmed => $this->notificationService->orderConfirmed($order->user, $order->order_number),
            OrderStatus::Shipping => $this->notificationService->orderShipped($order->user, $order->order_number, $order->tracking_number),
            OrderStatus::Delivered => $this->notificationService->orderDelivered($order->user, $order->order_number),
            OrderStatus::Cancelled => $this->notificationService->send(
                $order->user,
                'order_cancelled',
                [
                    'title' => "Order #{$order->order_number} has been cancelled",
                    'order_number' => $order->order_number,
                    'icon' => 'x-circle',
                    'color' => 'danger',
                ]
            ),
            default => null,
        };
    }
}
