<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderReturn;
use App\Services\NotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReturnController extends Controller
{
    public function __construct(
        protected NotificationService $notificationService
    ) {}

    public function index(Request $request): View
    {
        $query = OrderReturn::with(['order', 'orderItem', 'creator', 'approver']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('return_number', 'LIKE', "%{$search}%")
                  ->orWhereHas('order', fn($oq) => $oq->where('order_number', 'LIKE', "%{$search}%"));
            });
        }

        $returns = $query->latest()->paginate(config('ecommerce.pagination.admin_per_page', 20));

        return view('admin.orders.returns.index', compact('returns'));
    }

    public function show(OrderReturn $return): View
    {
        $return->load(['order.items', 'order.payment', 'orderItem', 'creator', 'approver']);
        return view('admin.orders.returns.show', compact('return'));
    }

    public function approve(OrderReturn $return): RedirectResponse
    {
        if (!$return->isPending()) {
            return back()->with('error', 'Return is not pending approval.');
        }

        $return->update([
            'status' => 'approved',
            'approved_by' => auth()->guard('admin')->id(),
            'approved_at' => now(),
        ]);

        $return->order->update(['status' => 'returned', 'returned_at' => now()]);

        if ($return->order->user) {
            $this->notificationService->send(
                $return->order->user,
                'return_approved',
                [
                    'title' => "Return #{$return->return_number} has been approved",
                    'order_number' => $return->order->order_number,
                    'return_number' => $return->return_number,
                    'icon' => 'check-circle',
                    'color' => 'success',
                ]
            );
        }

        return back()->with('success', 'Return approved successfully.');
    }

    public function reject(Request $request, OrderReturn $return): RedirectResponse
    {
        if (!$return->isPending()) {
            return back()->with('error', 'Return is not pending.');
        }

        $data = ['status' => 'rejected', 'rejected_at' => now()];

        if ($request->filled('rejection_reason')) {
            $data['rejection_reason'] = $request->rejection_reason;
        }

        $return->update($data);

        if ($return->order->user) {
            $this->notificationService->send(
                $return->order->user,
                'return_rejected',
                [
                    'title' => "Return #{$return->return_number} has been rejected",
                    'order_number' => $return->order->order_number,
                    'return_number' => $return->return_number,
                    'reason' => $request->rejection_reason,
                    'icon' => 'x-circle',
                    'color' => 'danger',
                ]
            );
        }

        return back()->with('success', 'Return rejected.');
    }

    public function processRefund(Request $request, OrderReturn $return): RedirectResponse
    {
        if (!$return->isApproved()) {
            return back()->with('error', 'Return must be approved before processing refund.');
        }

        $amount = $request->filled('refund_amount') ? $request->refund_amount : $return->refund_amount;

        $return->update([
            'refund_status' => 'refunded',
            'refund_amount' => $amount,
            'refunded_at' => now(),
        ]);

        $return->order->update([
            'payment_status' => 'refunded',
            'paid_amount' => max(0, $return->order->paid_amount - $amount),
        ]);

        if ($return->order->user) {
            $this->notificationService->send(
                $return->order->user,
                'refund_processed',
                [
                    'title' => "Refund of \${$amount} has been processed for return #{$return->return_number}",
                    'order_number' => $return->order->order_number,
                    'amount' => $amount,
                    'icon' => 'cash-stack',
                    'color' => 'success',
                ]
            );
        }

        return back()->with('success', 'Refund processed successfully.');
    }
}
