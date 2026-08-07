<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\Review;
use Illuminate\Console\Command;

class MarkVerifiedPurchases extends Command
{
    protected $signature = 'reviews:mark-verified';
    protected $description = 'Mark reviews as verified for completed orders';

    public function handle(): int
    {
        $orders = Order::whereNotNull('delivered_at')
            ->whereDoesntHave('items.product.reviews', function ($q) {
                $q->where('is_verified', true);
            })
            ->with('items.product.reviews')
            ->get();

        $count = 0;

        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                if ($item->product) {
                    $updated = Review::where('product_id', $item->product->id)
                        ->where('user_id', $order->user_id)
                        ->where('is_verified', false)
                        ->update([
                            'is_verified' => true,
                            'verified_at' => now(),
                        ]);
                    $count += $updated;
                }
            }
        }

        $this->info("{$count} reviews marked as verified purchase.");
        return Command::SUCCESS;
    }
}
