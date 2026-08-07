<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use App\Services\PaymentService;
use App\Services\ShippingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(
        protected PaymentService $paymentService,
        protected OrderService $orderService,
        protected ShippingService $shippingService
    ) {}

    public function index(Request $request): View
    {
        $query = Order::with(['user', 'items', 'payment'])
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('invoice_number', 'like', "%{$search}%");
            });
        }

        $orders = $query->paginate(20);
        $statusCounts = $this->getStatusCounts();

        return view('admin.orders.index', compact('orders', 'statusCounts'));
    }

    public function show(Order $order): View
    {
        $order->load(['user', 'items', 'payment', 'transactions', 'coupon']);

        return view('admin.orders.show', compact('order'));
    }

    public function markPaid(Order $order, Request $request): RedirectResponse
    {
        $this->paymentService->markAsPaid(
            $order,
            $request->input('reference'),
            $request->input('gateway_response', [])
        );

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Payment marked as paid.');
    }

    public function markFailed(Order $order, Request $request): RedirectResponse
    {
        $this->paymentService->markAsFailed(
            $order,
            $request->input('reason', 'Marked as failed by admin')
        );

        return redirect()->route('admin.orders.show', $order)
            ->with('error', 'Payment marked as failed.');
    }

    public function refund(Order $order, Request $request): RedirectResponse
    {
        $amount = $request->filled('amount') ? (float) $request->amount : null;

        $this->paymentService->refund($order, $amount);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Order refunded successfully.');
    }

    public function updateStatus(Order $order, Request $request): RedirectResponse
    {
        $validStatuses = ['pending', 'confirmed', 'processing', 'packing', 'shipping', 'delivered', 'cancelled', 'returned'];
        $status = $request->input('status');

        if (!in_array($status, $validStatuses)) {
            return back()->with('error', 'Invalid status.');
        }

        $updateData = ['status' => $status];

        $timestampMap = [
            'confirmed' => 'confirmed_at',
            'packing' => 'packing_at',
            'shipping' => 'shipping_at',
            'delivered' => 'delivered_at',
            'cancelled' => 'cancelled_at',
            'returned' => 'returned_at',
        ];

        if (isset($timestampMap[$status])) {
            $updateData[$timestampMap[$status]] = now();
        }

        if ($status === 'cancelled') {
            $updateData['cancel_reason'] = $request->input('cancel_reason');
        }

        if ($status === 'shipping' && $request->filled('tracking_number')) {
            $updateData['tracking_number'] = $request->tracking_number;
            $updateData['carrier'] = $request->carrier;
            $updateData['tracking_url'] = $this->shippingService->buildTrackingUrl(
                $request->carrier, $request->tracking_number
            );
        }

        $order->update($updateData);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', "Order status updated to {$status}.");
    }

    public function updateTracking(Order $order, Request $request): RedirectResponse
    {
        $this->shippingService->updateTracking(
            $order,
            $request->input('tracking_number'),
            $request->input('carrier'),
            $request->input('tracking_url')
        );

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Tracking information updated.');
    }

    protected function getStatusCounts(): array
    {
        $statusCounts = Order::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $paymentCounts = Order::selectRaw('payment_status, COUNT(*) as count')
            ->groupBy('payment_status')
            ->pluck('count', 'payment_status')
            ->toArray();

        return [
            'all' => array_sum($statusCounts),
            'pending' => $statusCounts['pending'] ?? 0,
            'confirmed' => $statusCounts['confirmed'] ?? 0,
            'processing' => $statusCounts['processing'] ?? 0,
            'packing' => $statusCounts['packing'] ?? 0,
            'shipping' => $statusCounts['shipping'] ?? 0,
            'delivered' => $statusCounts['delivered'] ?? 0,
            'cancelled' => $statusCounts['cancelled'] ?? 0,
            'returned' => $statusCounts['returned'] ?? 0,
            'refunded' => $statusCounts['refunded'] ?? 0,
            'payment_pending' => $paymentCounts['pending'] ?? 0,
            'payment_paid' => $paymentCounts['paid'] ?? 0,
            'payment_failed' => $paymentCounts['failed'] ?? 0,
        ];
    }
}
