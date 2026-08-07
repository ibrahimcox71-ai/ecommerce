<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function __construct(
        protected OrderRepository $orderRepository
    ) {}

    public function index(): View
    {
        return view('admin.orders.reports.index');
    }

    public function sales(Request $request): View
    {
        $dateFrom = $request->get('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->get('date_to', now()->format('Y-m-d'));

        $report = $this->orderRepository->getSalesReport($dateFrom, $dateTo);

        return view('admin.orders.reports.sales', compact('report', 'dateFrom', 'dateTo'));
    }

    public function daily(): View
    {
        $daily = $this->orderRepository->getDailyOrders(30);
        return view('admin.orders.reports.daily', compact('daily'));
    }

    public function monthly(): View
    {
        $monthly = $this->orderRepository->getMonthlyOrders(12);
        return view('admin.orders.reports.monthly', compact('monthly'));
    }

    public function topCustomers(): View
    {
        $customers = $this->orderRepository->getTopCustomers(10);
        return view('admin.orders.reports.top-customers', compact('customers'));
    }

    public function topProducts(): View
    {
        $products = $this->orderRepository->getTopProducts(10);
        return view('admin.orders.reports.top-products', compact('products'));
    }

    public function cancelled(Request $request): View
    {
        $cancelled = $this->orderRepository->getCancelledOrders(
            $request->get('date_from'),
            $request->get('date_to')
        );
        return view('admin.orders.reports.cancelled', compact('cancelled'));
    }

    public function returned(Request $request): View
    {
        $returned = $this->orderRepository->getReturnedOrders(
            $request->get('date_from'),
            $request->get('date_to')
        );
        return view('admin.orders.reports.returned', compact('returned'));
    }
}
