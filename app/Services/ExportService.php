<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportService
{
    public function exportCsv(array $filters = []): StreamedResponse
    {
        $products = $this->getExportData($filters);

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="products-export-' . now()->format('Y-m-d-His') . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($products) {
            $handle = fopen('php://output', 'w');

            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, [
                'ID',
                'Name',
                'SKU',
                'Barcode',
                'Product Type',
                'Category',
                'Sub Category',
                'Brand',
                'Price',
                'Cost Price',
                'Sale Price',
                'Tax (%)',
                'Currency',
                'Discount',
                'Discount Type',
                'Stock',
                'Low Stock Threshold',
                'Status',
                'Featured',
                'Trending',
                'Best Seller',
                'Weight',
                'Weight Unit',
                'SEO Title',
                'Meta Description',
                'Meta Keywords',
                'Tags',
                'Created At',
                'Updated At',
            ]);

            foreach ($products as $product) {
                fputcsv($handle, [
                    $product->id,
                    $product->name,
                    $product->sku,
                    $product->barcode,
                    $product->product_type,
                    $product->category?->name ?? '',
                    $product->subCategory?->name ?? '',
                    $product->brand?->name ?? '',
                    $product->price,
                    $product->cost_price,
                    $product->current_price,
                    $product->tax,
                    $product->currency,
                    $product->discount,
                    $product->discount_type,
                    $product->unlimited_stock ? 'Unlimited' : $product->stock,
                    $product->low_stock_threshold,
                    $product->status?->label() ?? '',
                    $product->featured ? 'Yes' : 'No',
                    $product->trending ? 'Yes' : 'No',
                    $product->best_seller ? 'Yes' : 'No',
                    $product->weight,
                    $product->weight_unit,
                    $product->meta_title,
                    $product->meta_description,
                    $product->meta_keywords,
                    is_array($product->tags) ? implode(', ', $product->tags) : '',
                    $product->created_at?->format('Y-m-d H:i:s'),
                    $product->updated_at?->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($handle);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    public function exportExcel(array $filters = []): StreamedResponse
    {
        $products = $this->getExportData($filters);

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="products-export-' . now()->format('Y-m-d-His') . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($products) {
            $handle = fopen('php://output', 'w');

            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, [
                'ID',
                'Name',
                'SKU',
                'Barcode',
                'Product Type',
                'Category',
                'Sub Category',
                'Child Category',
                'Brand',
                'Price',
                'Cost Price',
                'Sale Price',
                'Profit',
                'Profit Margin %',
                'Tax (%)',
                'Price After Tax',
                'Currency',
                'Discount',
                'Discount Type',
                'Stock',
                'Unlimited Stock',
                'Low Stock Threshold',
                'Min Stock',
                'Status',
                'Featured',
                'Trending',
                'Best Seller',
                'New Arrival',
                'Weight',
                'Weight Unit',
                'Length',
                'Width',
                'Height',
                'SEO Title',
                'Meta Description',
                'Meta Keywords',
                'Canonical URL',
                'Tags',
                'Min Order Qty',
                'Max Order Qty',
                'Product Type',
                'Warranty Type',
                'Warranty Period',
                'Short Description',
                'Created At',
                'Updated At',
            ]);

            foreach ($products as $product) {
                fputcsv($handle, [
                    $product->id,
                    $product->name,
                    $product->sku,
                    $product->barcode,
                    $product->product_type,
                    $product->category?->name ?? '',
                    $product->subCategory?->name ?? '',
                    $product->childCategory?->name ?? '',
                    $product->brand?->name ?? '',
                    $product->price,
                    $product->cost_price,
                    $product->current_price,
                    $product->profit,
                    $product->profit_margin,
                    $product->tax,
                    $product->price_after_tax,
                    $product->currency,
                    $product->discount,
                    $product->discount_type,
                    $product->unlimited_stock ? 'Unlimited' : $product->stock,
                    $product->unlimited_stock ? 'Yes' : 'No',
                    $product->low_stock_threshold,
                    $product->min_stock,
                    $product->status?->label() ?? '',
                    $product->featured ? 'Yes' : 'No',
                    $product->trending ? 'Yes' : 'No',
                    $product->best_seller ? 'Yes' : 'No',
                    $product->is_new_arrival ? 'Yes' : 'No',
                    $product->weight,
                    $product->weight_unit,
                    $product->length,
                    $product->width,
                    $product->height,
                    $product->meta_title,
                    $product->meta_description,
                    $product->meta_keywords,
                    $product->canonical_url,
                    is_array($product->tags) ? implode(', ', $product->tags) : '',
                    $product->min_order_quantity,
                    $product->max_order_quantity,
                    $product->product_type,
                    $product->warranty_type,
                    $product->warranty_period,
                    $product->short_description,
                    $product->created_at?->format('Y-m-d H:i:s'),
                    $product->updated_at?->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($handle);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    protected function getExportData(array $filters = []): Collection
    {
        return app(ProductRepository::class)->getExportQuery($filters)->get();
    }
}
