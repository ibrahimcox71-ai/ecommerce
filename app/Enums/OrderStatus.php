<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case Processing = 'processing';
    case Packing = 'packing';
    case ReadyToShip = 'ready_to_ship';
    case Shipping = 'shipping';
    case OutForDelivery = 'out_for_delivery';
    case Delivered = 'delivered';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
    case Returned = 'returned';
    case Refunded = 'refunded';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Confirmed => 'Confirmed',
            self::Processing => 'Processing',
            self::Packing => 'Packed',
            self::ReadyToShip => 'Ready To Ship',
            self::Shipping => 'Shipped',
            self::OutForDelivery => 'Out For Delivery',
            self::Delivered => 'Delivered',
            self::Completed => 'Completed',
            self::Cancelled => 'Cancelled',
            self::Returned => 'Returned',
            self::Refunded => 'Refunded',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Pending => 'warning',
            self::Confirmed => 'info',
            self::Processing => 'primary',
            self::Packing => 'secondary',
            self::ReadyToShip => 'dark',
            self::Shipping => 'dark',
            self::OutForDelivery => 'info',
            self::Delivered => 'success',
            self::Completed => 'success',
            self::Cancelled => 'danger',
            self::Returned => 'warning',
            self::Refunded => 'secondary',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Pending => 'bg-warning text-dark',
            self::Confirmed => 'bg-info',
            self::Processing => 'bg-primary',
            self::Packing => 'bg-secondary',
            self::ReadyToShip => 'bg-dark',
            self::Shipping => 'bg-dark',
            self::OutForDelivery => 'bg-info',
            self::Delivered => 'bg-success',
            self::Completed => 'bg-success',
            self::Cancelled => 'bg-danger',
            self::Returned => 'bg-warning text-dark',
            self::Refunded => 'bg-secondary',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Pending => 'bi-clock',
            self::Confirmed => 'bi-check-circle',
            self::Processing => 'bi-arrow-repeat',
            self::Packing => 'bi-box-seam',
            self::ReadyToShip => 'bi-truck',
            self::Shipping => 'bi-truck',
            self::OutForDelivery => 'bi-geo-alt',
            self::Delivered => 'bi-check-all',
            self::Completed => 'bi-check-all',
            self::Cancelled => 'bi-x-circle',
            self::Returned => 'bi-arrow-counterclockwise',
            self::Refunded => 'bi-cash-stack',
        };
    }
}
