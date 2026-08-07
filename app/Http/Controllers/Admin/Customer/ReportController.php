<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function __construct(
        protected CustomerService $customerService
    ) {}

    public function index(): View
    {
        $stats = $this->customerService->getStats();
        $topCustomers = $this->customerService->getTopCustomers(10);
        $highestSpending = $this->customerService->getHighestSpendingCustomers(10);
        $inactiveCustomers = $this->customerService->getInactiveCustomers(90);
        $growthData = $this->customerService->getGrowthData(
            now()->subYear()->startOfMonth()->toDateString(),
            now()->toDateString(),
            'month'
        );

        return view('admin.customers.reports.index', compact(
            'stats',
            'topCustomers',
            'highestSpending',
            'inactiveCustomers',
            'growthData'
        ));
    }

    public function topCustomers(Request $request): JsonResponse
    {
        $limit = $request->get('limit', 10);
        return response()->json($this->customerService->getTopCustomers($limit));
    }

    public function highestSpending(Request $request): JsonResponse
    {
        $limit = $request->get('limit', 10);
        return response()->json($this->customerService->getHighestSpendingCustomers($limit));
    }

    public function inactive(Request $request): JsonResponse
    {
        $days = $request->get('days', 90);
        return response()->json($this->customerService->getInactiveCustomers($days));
    }

    public function growth(Request $request): JsonResponse
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'group_by' => 'nullable|in:day,week,month',
        ]);

        return response()->json(
            $this->customerService->getGrowthData(
                $request->start_date,
                $request->end_date,
                $request->get('group_by', 'month')
            )
        );
    }

    public function exportCsv(Request $request): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $filters = $request->only(['search', 'status', 'customer_type', 'customer_group_id', 'date_from', 'date_to']);
        $customers = Customer::with(['group', 'user'])
            ->when($filters['search'] ?? null, fn($q, $v) => $q->search($v))
            ->when($filters['status'] ?? null, fn($q, $v) => $q->where('status', $v))
            ->when($filters['customer_type'] ?? null, fn($q, $v) => $q->where('customer_type', $v))
            ->when($filters['customer_group_id'] ?? null, fn($q, $v) => $q->where('customer_group_id', $v))
            ->when($filters['date_from'] ?? null, fn($q, $v) => $q->whereDate('created_at', '>=', $v))
            ->when($filters['date_to'] ?? null, fn($q, $v) => $q->whereDate('created_at', '<=', $v))
            ->orderBy('created_at', 'desc')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="customers-export.csv"',
        ];

        $callback = function () use ($customers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'ID', 'Name', 'Email', 'Phone', 'Type', 'Company',
                'Group', 'City', 'Status', 'Reward Points',
                'Wallet Balance', 'Referral Code', 'Total Orders',
                'Total Spend', 'Created At',
            ]);

            foreach ($customers as $customer) {
                $address = $customer->addresses()->first();
                fputcsv($file, [
                    $customer->id,
                    $customer->name,
                    $customer->email,
                    $customer->phone,
                    $customer->customer_type->label(),
                    $customer->company_name ?? 'N/A',
                    $customer->group?->name ?? 'N/A',
                    $address?->city ?? 'N/A',
                    $customer->status,
                    $customer->reward_points,
                    $customer->wallet_balance,
                    $customer->referral_code,
                    $customer->total_orders,
                    number_format($customer->total_spend, 2),
                    $customer->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
