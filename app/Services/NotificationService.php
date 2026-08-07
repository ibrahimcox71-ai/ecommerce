<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    public function send(User $user, string $type, array $data, ?string $title = null): Notification
    {
        return Notification::create([
            'type' => $type,
            'notifiable_type' => get_class($user),
            'notifiable_id' => $user->id,
            'data' => array_merge([
                'title' => $title ?? $this->getDefaultTitle($type),
            ], $data),
        ]);
    }

    public function orderStatusChanged(User $user, string $orderNumber, string $status): Notification
    {
        return $this->send($user, 'order_status', [
            'title' => "Order #{$orderNumber} is now {$status}",
            'order_number' => $orderNumber,
            'status' => $status,
            'icon' => 'shopping-bag',
            'color' => 'primary',
        ]);
    }

    public function orderConfirmed(User $user, string $orderNumber): Notification
    {
        return $this->send($user, 'order_confirmed', [
            'title' => "Order #{$orderNumber} has been confirmed!",
            'order_number' => $orderNumber,
            'icon' => 'check-circle',
            'color' => 'success',
        ]);
    }

    public function orderShipped(User $user, string $orderNumber, ?string $trackingNumber = null): Notification
    {
        $data = [
            'title' => "Order #{$orderNumber} has been shipped!",
            'order_number' => $orderNumber,
            'icon' => 'truck',
            'color' => 'info',
        ];

        if ($trackingNumber) {
            $data['tracking_number'] = $trackingNumber;
        }

        return $this->send($user, 'order_shipped', $data);
    }

    public function orderDelivered(User $user, string $orderNumber): Notification
    {
        return $this->send($user, 'order_delivered', [
            'title' => "Order #{$orderNumber} has been delivered!",
            'order_number' => $orderNumber,
            'icon' => 'check-double',
            'color' => 'success',
        ]);
    }

    public function reviewApproved(User $user, string $productName): Notification
    {
        return $this->send($user, 'review_approved', [
            'title' => "Your review for {$productName} has been approved!",
            'product_name' => $productName,
            'icon' => 'star',
            'color' => 'warning',
        ]);
    }

    public function welcome(User $user): Notification
    {
        return $this->send($user, 'welcome', [
            'title' => 'Welcome to ' . config('app.name') . '!',
            'message' => 'Thank you for creating an account. Start shopping now!',
            'icon' => 'gift',
            'color' => 'primary',
        ]);
    }

    protected function getDefaultTitle(string $type): string
    {
        return match ($type) {
            'order_status' => 'Order status updated',
            'order_confirmed' => 'Order confirmed',
            'order_shipped' => 'Order shipped',
            'order_delivered' => 'Order delivered',
            'review_approved' => 'Review approved',
            'welcome' => 'Welcome!',
            default => 'Notification',
        };
    }
}
