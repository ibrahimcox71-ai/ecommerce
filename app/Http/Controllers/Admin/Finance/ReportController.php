<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\ChartOfAccount;
use App\Services\AccountingService;
use App\Services\FinanceReportService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function __construct(
        protected AccountingService $accountingService,
        protected FinanceReportService $reportService,
    ) {}

    public function index(): View
    {
        return view('admin.finance.reports.index');
    }

    public function profitLoss(Request $request): View
    {
        $filters = $request->only(['date_from', 'date_to']);
        $report = $this->reportService->profitLossReport(
            $filters['date_from'] ?? now()->startOfMonth()->format('Y-m-d'),
            $filters['date_to'] ?? now()->endOfMonth()->format('Y-m-d')
        );

        return view('admin.finance.reports.profit-loss', compact('report', 'filters'));
    }

    public function balanceSheet(Request $request): View
    {
        $asOfDate = $request->get('as_of_date', now()->format('Y-m-d'));
        $accounts = $this->accountingService->getBalanceSheet($asOfDate);

        $assets = collect($accounts)->filter(fn($a) => in_array($a['type'], ['asset', 'contra_asset']));
        $liabilities = collect($accounts)->filter(fn($a) => in_array($a['type'], ['liability', 'contra_liability']));
        $equity = collect($accounts)->filter(fn($a) => in_array($a['type'], ['equity', 'contra_equity']));

        return view('admin.finance.reports.balance-sheet', compact('assets', 'liabilities', 'equity', 'asOfDate'));
    }

    public function trialBalance(Request $request): View
    {
        $filters = $request->only(['date_from', 'date_to']);
        $accounts = $this->accountingService->getTrialBalance(
            $filters['date_from'] ?? null,
            $filters['date_to'] ?? null
        );

        return view('admin.finance.reports.trial-balance', compact('accounts', 'filters'));
    }

    public function cashFlow(Request $request): View
    {
        $filters = $request->only(['date_from', 'date_to']);
        $report = $this->reportService->cashFlowReport(
            $filters['date_from'] ?? now()->startOfMonth()->format('Y-m-d'),
            $filters['date_to'] ?? now()->endOfMonth()->format('Y-m-d')
        );

        return view('admin.finance.reports.cash-flow', compact('report', 'filters'));
    }

    public function taxSummary(Request $request): View
    {
        $filters = $request->only(['date_from', 'date_to']);
        $report = $this->reportService->taxSummaryReport(
            $filters['date_from'] ?? null,
            $filters['date_to'] ?? null
        );

        return view('admin.finance.reports.tax-summary', compact('report', 'filters'));
    }

    public function accountsPayable(): View
    {
        $report = $this->reportService->accountsPayableReport();

        return view('admin.finance.reports.accounts-payable', compact('report'));
    }

    public function accountsReceivable(): View
    {
        $report = $this->reportService->accountsReceivableReport();

        return view('admin.finance.reports.accounts-receivable', compact('report'));
    }
}
