<?php

namespace App\Services;

use App\Models\Order;

class ShippingService
{
    protected array $rates = [
        'free' => ['label' => 'Free Shipping', 'cost' => 0, 'estimate' => '7-12 business days'],
        'standard' => ['label' => 'Standard Shipping', 'cost' => 5.99, 'estimate' => '5-7 business days'],
        'express' => ['label' => 'Express Shipping', 'cost' => 12.99, 'estimate' => '2-3 business days'],
        'overnight' => ['label' => 'Overnight Shipping', 'cost' => 24.99, 'estimate' => '1 business day'],
    ];

    public function getRates(array $items = [], ?string $method = null): array
    {
        $totalQty = array_sum(array_column($items, 'quantity'));

        $rates = $this->rates;
        if ($totalQty > 5) {
            $rates['standard']['cost'] = 9.99;
            $rates['express']['cost'] = 19.99;
        }

        if ($method) {
            return $rates[$method] ?? $rates['standard'];
        }

        return $rates;
    }

    public function assignTrackingNumber(Order $order, ?string $carrier = null): Order
    {
        $trackingNumber = generateTrackingNumber();
        $carrier = $carrier ?? 'UPS';

        $order->update([
            'tracking_number' => $trackingNumber,
            'carrier' => $carrier,
            'tracking_url' => $this->buildTrackingUrl($carrier, $trackingNumber),
        ]);

        return $order->fresh();
    }

    public function updateTracking(Order $order, string $trackingNumber, string $carrier, ?string $url = null): Order
    {
        $order->update([
            'tracking_number' => $trackingNumber,
            'carrier' => $carrier,
            'tracking_url' => $url ?? $this->buildTrackingUrl($carrier, $trackingNumber),
        ]);

        return $order->fresh();
    }

    public function buildTrackingUrl(?string $carrier, ?string $trackingNumber): ?string
    {
        if (!$trackingNumber || !$carrier) {
            return null;
        }

        return match (strtolower($carrier)) {
            'ups' => "https://www.ups.com/track?tracknum={$trackingNumber}",
            'fedex' => "https://www.fedex.com/fedextrack/?trknbr={$trackingNumber}",
            'usps' => "https://tools.usps.com/go/TrackConfirmAction?tLabels={$trackingNumber}",
            'dhl' => "https://www.dhl.com/en/express/tracking.html?AWB={$trackingNumber}",
            default => null,
        };
    }
}
