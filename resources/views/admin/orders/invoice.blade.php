<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice {{ $order->invoice_number ?? $order->order_number }} - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', -apple-system, sans-serif;
            font-size: 12px;
            color: #1e293b;
            background: #fff;
        }
        .invoice-box {
            max-width: 210mm;
            margin: 0 auto;
            padding: 30px;
        }
        .invoice-header {
            border-bottom: 3px solid #2563eb;
            padding-bottom: 20px;
            margin-bottom: 25px;
        }
        .invoice-header .brand {
            font-size: 28px;
            font-weight: 800;
            color: #2563eb;
            letter-spacing: -0.5px;
        }
        .invoice-title {
            font-size: 32px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: 2px;
        }
        .barcode {
            font-family: 'Libre Barcode 39', monospace;
            font-size: 28px;
            letter-spacing: 2px;
        }
        .section-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #64748b;
            margin-bottom: 6px;
        }
        table.invoice-items {
            width: 100%;
            border-collapse: collapse;
        }
        table.invoice-items th {
            background: #f8fafc;
            padding: 10px 12px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            border-bottom: 2px solid #e2e8f0;
        }
        table.invoice-items td {
            padding: 10px 12px;
            border-bottom: 1px solid #f1f5f9;
        }
        table.invoice-items tfoot td {
            border-bottom: none;
            padding: 6px 12px;
        }
        .summary-line {
            border-top: 2px solid #2563eb;
        }
        .qr-placeholder {
            width: 80px;
            height: 80px;
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px dashed #cbd5e1;
            font-size: 10px;
            color: #94a3b8;
        }
        @media print {
            body { padding: 0; }
            .invoice-box { padding: 15px; }
            .no-print { display: none !important; }
        }
        .watermark {
            position: fixed;
            bottom: 20px;
            right: 20px;
            opacity: 0.04;
            font-size: 60px;
            font-weight: 900;
            color: #2563eb;
            pointer-events: none;
            z-index: -1;
        }
    </style>
</head>
<body>
    <div class="watermark">{{ config('app.name') }}</div>

    <div class="invoice-box">
        <div class="no-print text-center mb-3">
            <button class="btn btn-primary btn-sm" onclick="window.print()"><i class="fas fa-print me-1"></i>Print Invoice</button>
            <button class="btn btn-outline-secondary btn-sm" onclick="window.close()">Close</button>
        </div>

        <div class="invoice-header d-flex justify-content-between align-items-start">
            <div>
                <div class="brand">{{ config('app.name') }}</div>
                <small class="text-muted">{{ config('ecommerce.store_address', '123 Store Street') }}</small><br>
                <small class="text-muted">{{ config('ecommerce.store_phone', '') }}</small>
            </div>
            <div class="text-end">
                <div class="invoice-title">INVOICE</div>
                <div class="barcode text-muted mt-1" style="font-size: 22px;">{{ $order->invoice_number ?? $order->order_number }}</div>
                <small class="text-muted d-block mt-1">
                    Invoice #: <strong>{{ $order->invoice_number ?? 'N/A' }}</strong>
                </small>
                <small class="text-muted d-block">
                    Order #: <strong>{{ $order->order_number }}</strong>
                </small>
                <small class="text-muted d-block">
                    Date: {{ ($order->invoice_at ?? $order->created_at)->format('M d, Y') }}
                </small>
            </div>
        </div>

        <div class="row g-5 mb-4">
            <div class="col-5">
                <div class="section-title">Bill To</div>
                @php $billing = $order->billing_address ?? $order->shipping_address ?? [] @endphp
                <p class="mb-0 fw-semibold">{{ $billing['name'] ?? '—' }}</p>
                <small>{{ $billing['email'] ?? '' }}</small><br>
                <small>{{ $billing['phone'] ?? '' }}</small><br>
                <small>{{ $billing['address_line1'] ?? '' }}</small><br>
                @if($billing['address_line2'] ?? false)<small>{{ $billing['address_line2'] }}</small><br>@endif
                <small>{{ ($billing['city'] ?? '') }}{{ ($billing['state'] ?? '') ? ', ' . $billing['state'] : '' }} {{ $billing['zip'] ?? '' }}</small>
            </div>
            <div class="col-4">
                <div class="section-title">Ship To</div>
                @php $shipping = $order->shipping_address ?? [] @endphp
                @if($shipping && ($shipping['address_line1'] ?? false))
                    <p class="mb-0 fw-semibold">{{ $shipping['name'] ?? '—' }}</p>
                    <small>{{ $shipping['address_line1'] ?? '' }}</small><br>
                    @if($shipping['address_line2'] ?? false)<small>{{ $shipping['address_line2'] }}</small><br>@endif
                    <small>{{ ($shipping['city'] ?? '') }}{{ ($shipping['state'] ?? '') ? ', ' . $shipping['state'] : '' }} {{ $shipping['zip'] ?? '' }}</small>
                @else
                    <small class="text-muted">Same as billing</small>
                @endif
            </div>
            <div class="col-3 text-end">
                <div class="section-title">Payment</div>
                <small class="d-block">Method: <strong>{{ $order->payment?->methodLabel() ?? '—' }}</strong></small>
                <small class="d-block">Status: <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : ($order->payment_status === 'pending' ? 'warning' : 'danger') }}">{{ ucfirst($order->payment_status) }}</span></small>
                <small class="d-block">Shipping: {{ ucfirst($order->shipping_method ?? 'Standard') }}</small>
                <div class="mt-2">
                    <div class="qr-placeholder ms-auto" style="width: 60px; height: 60px;">
                        <small>QR</small>
                    </div>
                </div>
            </div>
        </div>

        <table class="invoice-items">
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 40%;">Description</th>
                    <th style="width: 10%;">SKU</th>
                    <th style="width: 10%;" class="text-center">Qty</th>
                    <th style="width: 15%;" class="text-end">Unit Price</th>
                    <th style="width: 20%;" class="text-end">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <span class="fw-semibold">{{ $item->product_name }}</span>
                        @if($item->discount > 0)
                            <br><small class="text-success">Discount: -{{ config('ecommerce.currency_symbol', '$') }}{{ number_format($item->discount, 2) }}</small>
                        @endif
                    </td>
                    <td>{{ $item->product_sku ?? '—' }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-end">{{ config('ecommerce.currency_symbol', '$') }}{{ number_format($item->unit_price, 2) }}</td>
                    <td class="text-end fw-semibold">{{ config('ecommerce.currency_symbol', '$') }}{{ number_format($item->subtotal, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr><td colspan="5" class="text-end text-muted">Subtotal</td><td class="text-end">{{ config('ecommerce.currency_symbol', '$') }}{{ number_format($order->subtotal, 2) }}</td></tr>
                @if($order->coupon_discount > 0)
                    <tr><td colspan="5" class="text-end text-muted">Discount</td><td class="text-end text-success">-{{ config('ecommerce.currency_symbol', '$') }}{{ number_format($order->coupon_discount, 2) }}</td></tr>
                @endif
                <tr><td colspan="5" class="text-end text-muted">Shipping ({{ ucfirst($order->shipping_method ?? 'Standard') }})</td><td class="text-end">{{ config('ecommerce.currency_symbol', '$') }}{{ number_format($order->shipping_cost, 2) }}</td></tr>
                <tr><td colspan="5" class="text-end text-muted">Tax ({{ $order->tax_rate }}%)</td><td class="text-end">{{ config('ecommerce.currency_symbol', '$') }}{{ number_format($order->tax_amount, 2) }}</td></tr>
                <tr class="summary-line"><td colspan="5" class="text-end fw-bold fs-5">Total</td><td class="text-end fw-bold fs-5 text-primary">{{ config('ecommerce.currency_symbol', '$') }}{{ number_format($order->total, 2) }}</td></tr>
                <tr><td colspan="5" class="text-end text-muted">Paid</td><td class="text-end text-success fw-semibold">{{ config('ecommerce.currency_symbol', '$') }}{{ number_format($order->paid_amount, 2) }}</td></tr>
                @if($order->getDueAmount() > 0)
                    <tr><td colspan="5" class="text-end text-muted fw-semibold">Due</td><td class="text-end text-danger fw-bold">{{ config('ecommerce.currency_symbol', '$') }}{{ number_format($order->getDueAmount(), 2) }}</td></tr>
                @endif
            </tfoot>
        </table>

        <div class="row mt-4">
            <div class="col-6">
                @if($order->notes)
                    <small class="fw-semibold">Notes:</small>
                    <p class="text-muted small mb-0">{{ $order->notes }}</p>
                @endif
            </div>
            <div class="col-6 text-end">
                <div class="barcode text-muted" style="font-size: 18px;">{{ $order->invoice_number ?? $order->order_number }}</div>
            </div>
        </div>

        <div class="mt-4 pt-3 text-center border-top text-muted small">
            <p class="mb-0">{{ config('app.name') }} &mdash; Thank you for your business!</p>
            <small>Invoice generated on {{ now()->format('M d, Y h:i A') }}</small>
        </div>
    </div>
</body>
</html>
