<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Services\FinanceDashboardService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        protected FinanceDashboardService $dashboardService,
    ) {}

    public function index(): View
    {
        $overview = $this->dashboardService->getOverview();
        $chartData = $this->dashboardService->getRevenueExpenseChart();
        $recentTransactions = $this->dashboardService->getRecentTransactions(10);
        $expenseByCategory = $this->dashboardService->getExpenseByCategory();

        return view('admin.finance.dashboard', compact(
            'overview',
            'chartData',
            'recentTransactions',
            'expenseByCategory'
        ));
    }

    public function chartData(Request $request): \Illuminate\Http\JsonResponse
    {
        $period = $request->get('period', 'monthly');
        $data = $this->dashboardService->getRevenueExpenseChart($period);

        return response()->json($data);
    }
}
