<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class OrderExportService
{
    public function exportCsv(array $filters = []): StreamedResponse
    {
        $orders = $this->getExportData($filters);

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="orders-' . now()->format('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($orders) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Order #', 'Invoice #', 'Customer', 'Email', 'Phone',
                'Items', 'Subtotal', 'Shipping', 'Tax', 'Discount',
                'Total', 'Paid', 'Due', 'Payment Status', 'Order Status',
                'Payment Method', 'Shipping Method', 'Carrier', 'Tracking #',
                'Order Origin', 'Date', 'Delivery Date',
            ]);

            foreach ($orders as $order) {
                $addr = $order->shipping_address ?? [];
                fputcsv($file, [
                    $order->order_number,
                    $order->invoice_number,
                    $addr['name'] ?? ($order->user?->name ?? 'Guest'),
                    $addr['email'] ?? ($order->user?->email ?? ''),
                    $addr['phone'] ?? '',
                    $order->items->sum('quantity'),
                    number_format($order->subtotal, 2),
                    number_format($order->shipping_cost, 2),
                    number_format($order->tax_amount, 2),
                    number_format($order->coupon_discount, 2),
                    number_format($order->total, 2),
                    number_format($order->paid_amount, 2),
                    number_format($order->getDueAmount(), 2),
                    ucfirst($order->payment_status),
                    ucfirst($order->status),
                    $order->payment?->methodLabel() ?? '—',
                    $order->shipping_method ?? '—',
                    $order->carrier ?? '—',
                    $order->tracking_number ?? '—',
                    $order->order_origin,
                    $order->created_at->format('Y-m-d H:i'),
                    $order->estimated_delivery?->format('Y-m-d') ?? '—',
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function exportExcel(array $filters = []): StreamedResponse
    {
        $orders = $this->getExportData($filters);

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="orders-' . now()->format('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($orders) {
            $file = fopen('php://output', 'w');

            fwrite($file, "\xEF\xBB\xBF");

            fputcsv($file, [
                'Order #', 'Invoice #', 'Customer Name', 'Email', 'Phone',
                'Product Name', 'SKU', 'Quantity', 'Unit Price', 'Item Total',
                'Order Subtotal', 'Shipping', 'Tax', 'Discount', 'Order Total',
                'Paid Amount', 'Due Amount', 'Payment Status', 'Order Status',
                'Payment Method', 'Shipping Method', 'Carrier', 'Tracking #',
                'Origin', 'Order Date', 'Delivery Date',
            ]);

            foreach ($orders as $order) {
                $addr = $order->shipping_address ?? [];
                $base = [
                    $order->order_number,
                    $order->invoice_number,
                    $addr['name'] ?? ($order->user?->name ?? 'Guest'),
                    $addr['email'] ?? ($order->user?->email ?? ''),
                    $addr['phone'] ?? '',
                ];

                if ($order->items->isNotEmpty()) {
                    foreach ($order->items as $item) {
                        fputcsv($file, array_merge($base, [
                            $item->product_name,
                            $item->product_sku ?? '—',
                            $item->quantity,
                            number_format($item->unit_price, 2),
                            number_format($item->subtotal, 2),
                            number_format($order->subtotal, 2),
                            number_format($order->shipping_cost, 2),
                            number_format($order->tax_amount, 2),
                            number_format($order->coupon_discount, 2),
                            number_format($order->total, 2),
                            number_format($order->paid_amount, 2),
                            number_format($order->getDueAmount(), 2),
                            ucfirst($order->payment_status),
                            ucfirst($order->status),
                            $order->payment?->methodLabel() ?? '—',
                            $order->shipping_method ?? '—',
                            $order->carrier ?? '—',
                            $order->tracking_number ?? '—',
                            $order->order_origin,
                            $order->created_at->format('Y-m-d H:i'),
                            $order->estimated_delivery?->format('Y-m-d') ?? '—',
                        ]));
                    }
                } else {
                    fputcsv($file, array_merge($base, [
                        '—', '—', 0, 0, 0,
                        number_format($order->subtotal, 2),
                        number_format($order->shipping_cost, 2),
                        number_format($order->tax_amount, 2),
                        number_format($order->coupon_discount, 2),
                        number_format($order->total, 2),
                        number_format($order->paid_amount, 2),
                        number_format($order->getDueAmount(), 2),
                        ucfirst($order->payment_status),
                        ucfirst($order->status),
                        $order->payment?->methodLabel() ?? '—',
                        $order->shipping_method ?? '—',
                        $order->carrier ?? '—',
                        $order->tracking_number ?? '—',
                        $order->order_origin,
                        $order->created_at->format('Y-m-d H:i'),
                        $order->estimated_delivery?->format('Y-m-d') ?? '—',
                    ]));
                }
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function exportPdf(Order $order): \Barryvdh\DomPDF\PDF
    {
        $order->load(['items', 'payment', 'user']);

        $data = [
            'order' => $order,
            'store' => [
                'name' => config('app.name'),
                'address' => config('ecommerce.store_address', ''),
                'phone' => config('ecommerce.store_phone', ''),
                'email' => config('ecommerce.store_email', ''),
            ],
        ];

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.orders.pdf', $data);
        $pdf->setPaper('a4');

        return $pdf;
    }

    protected function getExportData(array $filters = [])
    {
        $query = Order::with(['items', 'payment', 'user:id,name,email']);

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (!empty($filters['payment_status'])) {
            $query->where('payment_status', $filters['payment_status']);
        }
        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }
        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        $query->latest();

        return $query->get();
    }
}
