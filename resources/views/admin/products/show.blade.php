<x-layouts.admin-layout title="{{ $product->name }}">

    @push('styles')
        @vite(['resources/sass/product.scss'])
    @endpush

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">{{ $product->name }}</h4>
            <p class="text-muted small mb-0">
                <span class="badge bg-{{ $product->status->color() }} bg-opacity-10 text-{{ $product->status->color() }}">
                    {{ $product->status->label() }}
                </span>
                <span class="ms-2">SKU: <code>{{ $product->sku }}</code></span>
                @if($product->product_type)
                    <span class="ms-2 badge bg-info bg-opacity-10 text-info">{{ ucfirst($product->product_type) }}</span>
                @endif
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
            <a href="{{ route('admin.products.duplicate', $product->id) }}" class="btn btn-outline-secondary">
                <i class="fas fa-copy me-1"></i> Duplicate
            </a>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="row g-4">
        {{-- Left Column --}}
        <div class="col-lg-8">

            {{-- Product Info Card --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="fw-semibold mb-0"><i class="fas fa-box me-2"></i>Product Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            @if($product->thumbnail)
                                <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}"
                                     class="img-thumbnail" style="width: 100%;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                     style="width: 100%; aspect-ratio: 1;">
                                    <i class="fas fa-box fa-3x text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-9">
                            <table class="table table-sm">
                                <tr>
                                    <td class="text-muted" style="width: 150px;">Name</td>
                                    <td class="fw-semibold">{{ $product->name }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Slug</td>
                                    <td><code>{{ $product->slug }}</code></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Category</td>
                                    <td>{{ $product->category?->name ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Sub Category</td>
                                    <td>{{ $product->subCategory?->name ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Child Category</td>
                                    <td>{{ $product->childCategory?->name ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Brand</td>
                                    <td>{{ $product->brand?->name ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Barcode</td>
                                    <td>{{ $product->barcode ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Currency</td>
                                    <td>{{ $product->currency ?? config('ecommerce.currency') }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Product Type</td>
                                    <td>
                                        <span class="badge bg-{{ $product->product_type === 'variable' ? 'primary' : ($product->product_type === 'digital' ? 'info' : 'secondary') }}">
                                            {{ ucfirst($product->product_type) }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Description --}}
            @if($product->short_description || $product->description)
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="fw-semibold mb-0"><i class="fas fa-align-left me-2"></i>Description</h6>
                    </div>
                    <div class="card-body">
                        @if($product->short_description)
                            <p class="text-muted">{{ $product->short_description }}</p>
                            @if($product->description)<hr>@endif
                        @endif
                        @if($product->description)
                            <div>{!! strip_tags($product->description, '<p><br><b><strong><i><em><u><ol><ul><li><a><img><table><tr><td><th><h1><h2><h3><h4><h5><h6><blockquote><pre><code><hr><span><div><sub><sup>') !!}</div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Gallery --}}
            @if($product->images->count() > 0)
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="fw-semibold mb-0"><i class="fas fa-images me-2"></i>Gallery ({{ $product->images->count() }})</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-2">
                            @foreach($product->images as $image)
                                <div class="col-auto">
                                    <div class="position-relative">
                                        <img src="{{ $image->image_url }}" alt="{{ $image->alt_text ?? $product->name }}"
                                             class="rounded" style="width: 100px; height: 100px; object-fit: cover;">
                                        @if($image->is_primary)
                                            <span class="badge bg-success position-absolute top-0 start-0 mt-1 ms-1" style="font-size: 8px;">Primary</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- Variants --}}
            @if($product->variants->count() > 0)
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="fw-semibold mb-0"><i class="fas fa-layer-group me-2"></i>Variants ({{ $product->variants->count() }})</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Variant</th>
                                        <th>SKU</th>
                                        <th>Price</th>
                                        <th>Cost</th>
                                        <th>Stock</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($product->variants as $variant)
                                        <tr>
                                            <td>
                                                @if($variant->image)
                                                    <img src="{{ $variant->image_url }}" class="rounded" style="width: 32px; height: 32px; object-fit: cover;">
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $variant->name }}
                                                @if($variant->attributeValues->count() > 0)
                                                    <small class="text-muted d-block">
                                                        @foreach($variant->attributeValues as $av)
                                                            <span class="badge bg-light text-dark me-1">{{ $av->attributeValue?->value ?? $av->attribute?->name }}</span>
                                                        @endforeach
                                                    </small>
                                                @endif
                                            </td>
                                            <td><code>{{ $variant->sku }}</code></td>
                                            <td>
                                                @if($variant->price)
                                                    {{ config('ecommerce.currency_symbol') }}{{ number_format($variant->price, 2) }}
                                                @else
                                                    <span class="text-muted">Inherit</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($variant->cost_price)
                                                    {{ config('ecommerce.currency_symbol') }}{{ number_format($variant->cost_price, 2) }}
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($variant->unlimited_stock)
                                                    <span class="text-success"><i class="fas fa-infinity"></i></span>
                                                @else
                                                    {{ $variant->stock }}
                                                @endif
                                            </td>
                                            <td>
                                                @if($variant->status)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-secondary">Inactive</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Stock History Timeline --}}
            @if($stockHistory && $stockHistory->count() > 0)
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="fw-semibold mb-0"><i class="fas fa-history me-2"></i>Stock History</h6>
                    </div>
                    <div class="card-body">
                        <div class="stock-timeline">
                            @foreach($stockHistory as $entry)
                                <div class="timeline-item {{ $entry->quantity > 0 ? 'timeline-in' : 'timeline-out' }}">
                                    <div class="timeline-marker">
                                        <i class="fas {{ $entry->quantity > 0 ? 'fa-arrow-down' : 'fa-arrow-up' }}"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <strong>{{ $entry->quantity > 0 ? '+' : '' }}{{ $entry->quantity }}</strong>
                                                <span class="text-muted ms-2">{{ $entry->reference_type ?? 'Manual Adjustment' }}</span>
                                                @if($entry->reference)
                                                    <span class="text-muted ms-1">({{ $entry->reference }})</span>
                                                @endif
                                            </div>
                                            <small class="text-muted">{{ $entry->created_at->format('M d, H:i') }}</small>
                                        </div>
                                        @if($entry->notes)
                                            <small class="text-muted d-block mt-1">{{ $entry->notes }}</small>
                                        @endif
                                        <small class="text-muted d-block">
                                            Balance: {{ $entry->current_quantity ?? '—' }}
                                        </small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- Schema Preview --}}
            @if($product->schema_markup)
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="fw-semibold mb-0"><i class="fas fa-code me-2"></i>Schema Markup Preview</h6>
                    </div>
                    <div class="card-body">
                        <pre class="mb-0" style="max-height: 300px; overflow-y: auto;"><code>{{ $product->schema_markup }}</code></pre>
                    </div>
                </div>
            @endif

            {{-- Activity Log --}}
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="fw-semibold mb-0"><i class="fas fa-history me-2"></i>Activity Log</h6>
                </div>
                <div class="card-body">
                    @if($activityLogs->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($activityLogs as $log)
                                <div class="list-group-item px-0 py-2 border-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="badge bg-light text-dark me-2" style="width: 6px; height: 6px; padding: 0; border-radius: 50%; display: inline-block;"></span>
                                            {{ $log->description }}
                                            @if($log->properties)
                                                <button type="button" class="btn btn-sm btn-link p-0 ms-1" data-bs-toggle="tooltip" title="{{ json_encode($log->properties, JSON_PRETTY_PRINT) }}">
                                                    <i class="fas fa-info-circle text-muted"></i>
                                                </button>
                                            @endif
                                        </div>
                                        <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                                    </div>
                                    @if($log->causer)
                                        <small class="text-muted ms-0">by {{ $log->causer->name ?? 'System' }}</small>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-3">
                            {{ $activityLogs->links() }}
                        </div>
                    @else
                        <p class="text-muted mb-0">No activity recorded yet.</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right Column --}}
        <div class="col-lg-4">

            {{-- Price & Profit --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="fw-semibold mb-0"><i class="fas fa-dollar-sign me-2"></i>Pricing Overview</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="text-center p-3 bg-light rounded">
                                <div class="h4 mb-1 text-success">{{ config('ecommerce.currency_symbol') }}{{ number_format($product->current_price, 2) }}</div>
                                <small class="text-muted">Sale Price</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-3 bg-light rounded">
                                <div class="h4 mb-1">{{ config('ecommerce.currency_symbol') }}{{ number_format($product->price, 2) }}</div>
                                <small class="text-muted">Base Price</small>
                            </div>
                        </div>
                        @if($product->cost_price > 0)
                            <div class="col-6">
                                <div class="text-center p-3 bg-light rounded">
                                    <div class="h4 mb-1">{{ config('ecommerce.currency_symbol') }}{{ number_format($product->cost_price, 2) }}</div>
                                    <small class="text-muted">Cost Price</small>
                                </div>
                            </div>
                            @php
                                $marginColor = $product->profit_margin > 30 ? 'success' : ($product->profit_margin > 15 ? 'warning' : 'danger');
                            @endphp
                            <div class="col-6">
                                <div class="text-center p-3 bg-{{ $marginColor }} bg-opacity-10 rounded">
                                    <div class="h4 mb-1 text-{{ $marginColor }}">{{ $product->profit_margin }}%</div>
                                    <small class="text-muted">Margin</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center p-3 bg-success bg-opacity-10 rounded">
                                    <div class="h4 mb-1 text-success">+{{ config('ecommerce.currency_symbol') }}{{ number_format($product->profit, 2) }}</div>
                                    <small class="text-muted">Profit</small>
                                </div>
                            </div>
                        @endif
                        @if($product->tax > 0)
                            <div class="col-6">
                                <div class="text-center p-3 bg-info bg-opacity-10 rounded">
                                    <div class="h4 mb-1 text-info">{{ config('ecommerce.currency_symbol') }}{{ number_format($product->price_after_tax - $product->current_price, 2) }}</div>
                                    <small class="text-muted">Tax ({{ $product->tax }}% {{ $product->tax_type }})</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center p-3 bg-primary bg-opacity-10 rounded">
                                    <div class="h4 mb-1 text-primary">{{ config('ecommerce.currency_symbol') }}{{ number_format($product->price_after_tax, 2) }}</div>
                                    <small class="text-muted">After Tax</small>
                                </div>
                            </div>
                        @endif
                        @if($product->discount > 0 && $product->has_discount)
                            <div class="col-6">
                                <div class="text-center p-3 bg-warning bg-opacity-10 rounded">
                                    <div class="h4 mb-1 text-warning">-{{ $product->discount_percentage }}%</div>
                                    <small class="text-muted">Discount</small>
                                </div>
                            </div>
                            @if($product->discount_start)
                                <div class="col-6">
                                    <div class="text-center p-3 bg-light rounded">
                                        <small class="text-muted">Until {{ $product->discount_end?->format('M d, Y') ?? 'Forever' }}</small>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            {{-- Stock --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="fw-semibold mb-0"><i class="fas fa-boxes me-2"></i>Stock</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Stock</span>
                        <span class="fw-semibold">
                            @if($product->unlimited_stock)
                                <span class="text-success"><i class="fas fa-infinity"></i> Unlimited</span>
                            @else
                                {{ $product->stock }}
                            @endif
                        </span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Total (incl. variants)</span>
                        <span class="fw-semibold">
                            @if($product->total_stock !== null)
                                {{ $product->total_stock }}
                            @else
                                <span class="text-success"><i class="fas fa-infinity"></i></span>
                            @endif
                        </span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Min Stock</span>
                        <span class="fw-semibold">{{ $product->min_stock ?: '—' }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Low Stock Threshold</span>
                        <span class="fw-semibold">{{ $product->low_stock_threshold ?: '—' }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Stock Value</span>
                        <span class="fw-semibold">{{ config('ecommerce.currency_symbol') }}{{ number_format($product->stock_value, 2) }}</span>
                    </div>
                    @if($product->is_low_stock)
                        <div class="alert alert-warning mt-3 mb-0 py-2">
                            <i class="fas fa-exclamation-triangle me-1"></i> Low stock alert! Only {{ $product->stock }} remaining.
                        </div>
                    @elseif($product->is_out_of_stock)
                        <div class="alert alert-danger mt-3 mb-0 py-2">
                            <i class="fas fa-times-circle me-1"></i> Out of stock!
                        </div>
                    @elseif($product->is_below_min_stock)
                        <div class="alert alert-warning mt-3 mb-0 py-2">
                            <i class="fas fa-exclamation-circle me-1"></i> Below minimum stock level!
                        </div>
                    @endif
                </div>
            </div>

            {{-- Flags --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="fw-semibold mb-0"><i class="fas fa-flag me-2"></i>Product Flags</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        @if($product->featured)
                            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25">
                                <i class="fas fa-star me-1"></i> Featured
                            </span>
                        @endif
                        @if($product->trending)
                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25">
                                <i class="fas fa-fire me-1"></i> Trending
                            </span>
                        @endif
                        @if($product->best_seller)
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">
                                <i class="fas fa-trophy me-1"></i> Best Seller
                            </span>
                        @endif
                        @if($product->is_new_arrival)
                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25">
                                <i class="fas fa-star me-1"></i> New Arrival
                            </span>
                        @endif
                        @if($product->has_discount)
                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25">
                                <i class="fas fa-tag me-1"></i> On Sale
                            </span>
                        @endif
                        @if($product->is_virtual)
                            <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25">
                                <i class="fas fa-download me-1"></i> Digital
                            </span>
                        @endif
                        @if($product->tags && count($product->tags) > 0)
                            @foreach($product->tags as $tag)
                                <span class="badge bg-light text-dark">{{ $tag }}</span>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            {{-- Inventory by Warehouse --}}
            @if($product->inventories->count() > 0)
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="fw-semibold mb-0"><i class="fas fa-warehouse me-2"></i>Warehouse Inventory</h6>
                    </div>
                    <div class="card-body">
                        @foreach($product->inventories as $inventory)
                            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                <div>
                                    <strong>{{ $inventory->warehouse->name }}</strong>
                                    @if($inventory->warehouse->is_default)
                                        <span class="badge bg-primary ms-1" style="font-size: 8px;">Default</span>
                                    @endif
                                </div>
                                <span class="badge bg-light text-dark">{{ $inventory->quantity }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Shipping --}}
            @if($product->weight || $product->length)
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="fw-semibold mb-0"><i class="fas fa-truck me-2"></i>Shipping Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Weight</span>
                            <span>{{ $product->weight ? $product->weight . ' ' . ($product->weight_unit ?? 'kg') : '—' }}</span>
                        </div>
                        @if($product->length || $product->width || $product->height)
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Dimensions</span>
                                <span>{{ $product->length ?? 0 }} × {{ $product->width ?? 0 }} × {{ $product->height ?? 0 }} {{ $product->dimension_unit ?? 'cm' }}</span>
                            </div>
                        @endif
                        @if($product->warranty_type !== 'no_warranty' && $product->warranty_type)
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Warranty</span>
                                <span>{{ ucfirst($product->warranty_type) }} {{ $product->warranty_period ? "({$product->warranty_period} months)" : '' }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Order Limits --}}
            @if($product->min_order_quantity > 1 || $product->max_order_quantity)
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="fw-semibold mb-0"><i class="fas fa-shopping-cart me-2"></i>Order Limits</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Min Order</span>
                            <span>{{ $product->min_order_quantity ?? 1 }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Max Order</span>
                            <span>{{ $product->max_order_quantity ?? 'No limit' }}</span>
                        </div>
                    </div>
                </div>
            @endif

            {{-- SEO --}}
            @if($product->meta_title || $product->meta_description || $product->meta_keywords || $product->canonical_url)
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="fw-semibold mb-0"><i class="fas fa-search me-2"></i>SEO</h6>
                    </div>
                    <div class="card-body">
                        @if($product->meta_title)
                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">Meta Title</small>
                                <div class="p-2 bg-light rounded">{{ $product->meta_title }}</div>
                            </div>
                        @endif
                        @if($product->meta_description)
                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">Meta Description</small>
                                <div class="p-2 bg-light rounded">{{ $product->meta_description }}</div>
                            </div>
                        @endif
                        @if($product->meta_keywords)
                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">Meta Keywords</small>
                                <div>
                                    @foreach(explode(',', $product->meta_keywords) as $keyword)
                                        <span class="badge bg-light text-dark me-1">{{ trim($keyword) }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if($product->canonical_url)
                            <div>
                                <small class="text-muted d-block mb-1">Canonical URL</small>
                                <div class="p-2 bg-light rounded"><code>{{ $product->canonical_url }}</code></div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Reviews Summary --}}
            @if($product->review_count > 0)
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="fw-semibold mb-0"><i class="fas fa-star me-2"></i>Reviews</h6>
                    </div>
                    <div class="card-body text-center">
                        <div class="h2 mb-0">{{ number_format($product->average_rating, 1) }}</div>
                        <div class="text-warning">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star{{ $i <= round($product->average_rating) ? '' : '-o' }}"></i>
                            @endfor
                        </div>
                        <small class="text-muted">{{ $product->review_count }} review(s)</small>
                    </div>
                </div>
            @endif

            {{-- Quick Actions --}}
            <div class="card">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-1"></i> Edit Product
                        </a>
                        <a href="{{ route('admin.products.duplicate', $product->id) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-copy me-1"></i> Duplicate Product
                        </a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this product?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="fas fa-trash me-1"></i> Delete Product
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layouts.admin-layout>

@push('scripts')
@vite(['resources/js/product.js'])
<script>
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(el) {
        return new bootstrap.Tooltip(el);
    });
});
</script>
@endpush
