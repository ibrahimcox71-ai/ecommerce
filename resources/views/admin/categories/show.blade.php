<x-layouts.admin-layout title="Category Details">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">{{ $category->name }}</h4>
            <p class="text-muted small mb-0">
                <x-admin.category.status-badge :status="$category->status" />
                @if($category->category_code)
                    <span class="badge bg-light text-dark border ms-2">{{ $category->category_code }}</span>
                @endif
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-primary">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            {{-- Basic Info --}}
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Basic Information</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <dl class="mb-0">
                                <dt class="text-muted small">Name</dt>
                                <dd class="fw-semibold">{{ $category->name }}</dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl class="mb-0">
                                <dt class="text-muted small">Slug</dt>
                                <dd><code>{{ $category->slug }}</code></dd>
                            </dl>
                        </div>
                        @if($category->category_code)
                        <div class="col-md-6">
                            <dl class="mb-0">
                                <dt class="text-muted small">Category Code</dt>
                                <dd><span class="badge bg-light text-dark border">{{ $category->category_code }}</span></dd>
                            </dl>
                        </div>
                        @endif
                        <div class="col-md-6">
                            <dl class="mb-0">
                                <dt class="text-muted small">Sort Order</dt>
                                <dd>#{{ $category->sort_order }}</dd>
                            </dl>
                        </div>
                    </div>

                    @if($category->short_description)
                        <hr>
                        <dl class="mb-0">
                            <dt class="text-muted small">Short Description</dt>
                            <dd>{{ $category->short_description }}</dd>
                        </dl>
                    @endif

                    @if($category->description)
                        <hr>
                        <dl class="mb-0">
                            <dt class="text-muted small">Full Description</dt>
                            <dd class="text-pre-wrap">{{ $category->description }}</dd>
                        </dl>
                    @endif
                </div>
            </div>

            {{-- Display Settings --}}
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Display Settings</h6>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-6 col-md-4">
                            <span class="badge bg-{{ $category->featured ? 'success' : 'secondary' }} bg-opacity-10 text-{{ $category->featured ? 'success' : 'secondary' }} me-2 mb-2 p-2">
                                <i class="fas fa-star me-1"></i> Featured
                            </span>
                        </div>
                        <div class="col-6 col-md-4">
                            <span class="badge bg-{{ $category->popular ? 'success' : 'secondary' }} bg-opacity-10 text-{{ $category->popular ? 'success' : 'secondary' }} me-2 mb-2 p-2">
                                <i class="fas fa-fire me-1"></i> Popular
                            </span>
                        </div>
                        <div class="col-6 col-md-4">
                            <span class="badge bg-{{ $category->show_on_homepage ? 'success' : 'secondary' }} bg-opacity-10 text-{{ $category->show_on_homepage ? 'success' : 'secondary' }} me-2 mb-2 p-2">
                                <i class="fas fa-home me-1"></i> Homepage
                            </span>
                        </div>
                        <div class="col-6 col-md-4">
                            <span class="badge bg-{{ $category->show_in_mega_menu ? 'success' : 'secondary' }} bg-opacity-10 text-{{ $category->show_in_mega_menu ? 'success' : 'secondary' }} me-2 mb-2 p-2">
                                <i class="fas fa-bars me-1"></i> Mega Menu
                            </span>
                        </div>
                        <div class="col-6 col-md-4">
                            <span class="badge bg-{{ $category->show_in_mobile_menu ? 'success' : 'secondary' }} bg-opacity-10 text-{{ $category->show_in_mobile_menu ? 'success' : 'secondary' }} me-2 mb-2 p-2">
                                <i class="fas fa-mobile me-1"></i> Mobile Menu
                            </span>
                        </div>
                        <div class="col-6 col-md-4">
                            <span class="badge bg-{{ $category->show_in_sidebar ? 'success' : 'secondary' }} bg-opacity-10 text-{{ $category->show_in_sidebar ? 'success' : 'secondary' }} me-2 mb-2 p-2">
                                <i class="fas fa-th-list me-1"></i> Sidebar
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Products --}}
            <div class="card mb-4">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">Products ({{ $category->product_count }})</h6>
                    @if($category->product_count > 0)
                        <a href="{{ route('admin.products.index', ['category' => $category->id]) }}" class="btn btn-sm btn-outline-primary">
                            View All
                        </a>
                    @endif
                </div>
                <div class="card-body p-0">
                    @php $recentProducts = $category->products()->latest()->take(5)->get(); @endphp
                    @if($recentProducts->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 ps-4">Product</th>
                                        <th class="border-0 text-end">Price</th>
                                        <th class="border-0 text-center">Stock</th>
                                        <th class="border-0 text-end pe-4">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentProducts as $product)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    @if($product->featured_image)
                                                        <img src="{{ asset('storage/' . $product->featured_image) }}"
                                                             alt="{{ $product->name }}" class="rounded me-2"
                                                             style="width: 40px; height: 40px; object-fit: cover;" loading="lazy">
                                                    @endif
                                                    <span class="small">{{ $product->name }}</span>
                                                </div>
                                            </td>
                                            <td class="text-end small">{{ config('ecommerce.currency_symbol', '$') }}{{ number_format($product->price, 2) }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-{{ $product->stock > 10 ? 'success' : ($product->stock > 0 ? 'warning' : 'danger') }}">
                                                    {{ $product->stock ?? 0 }}
                                                </span>
                                            </td>
                                            <td class="text-end pe-4">
                                                @if($product->status === 'active')
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
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-box-open fa-2x mb-2"></i>
                            <p class="mb-0">No products in this category</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Activity Log --}}
            <div class="card">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Activity Log</h6>
                </div>
                <div class="card-body p-0">
                    @php $logs = $category->activityLogs()->latest()->take(10)->get(); @endphp
                    @if($logs->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 ps-4">Action</th>
                                        <th class="border-0">Details</th>
                                        <th class="border-0 pe-4 text-end">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($logs as $log)
                                        <tr>
                                            <td class="ps-4">
                                                <span class="badge bg-{{ str_contains($log->description, 'created') ? 'success' : (str_contains($log->description, 'updated') ? 'info' : (str_contains($log->description, 'restored') ? 'primary' : 'warning')) }}">
                                                    {{ $log->description }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($log->properties)
                                                    @foreach($log->properties as $key => $value)
                                                        <small class="text-muted me-1">{{ $key }}: {{ is_array($value) ? json_encode($value) : $value }}</small>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td class="pe-4 text-end text-muted small">
                                                {{ $log->created_at->format('M d, Y H:i') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-history fa-2x mb-2"></i>
                            <p class="mb-0">No activity recorded yet</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            {{-- Image & Status --}}
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Media Overview</h6>
                </div>
                <div class="card-body">
                    @if($category->image)
                        <div class="mb-3">
                            <label class="text-muted small">Category Image</label>
                            <img src="{{ $category->image_url }}" alt="{{ $category->name }}"
                                 class="img-fluid rounded w-100" style="max-height: 200px; object-fit: cover;" loading="lazy">
                        </div>
                    @endif
                    @if($category->thumbnail)
                        <div class="mb-3">
                            <label class="text-muted small">Thumbnail</label>
                            <img src="{{ $category->thumbnail_url }}" alt="Thumbnail"
                                 class="img-fluid rounded" style="max-height: 80px; object-fit: cover;" loading="lazy">
                        </div>
                    @endif
                    @if($category->banner)
                        <div class="mb-3">
                            <label class="text-muted small">Banner</label>
                            <img src="{{ $category->banner_url }}" alt="Banner"
                                 class="img-fluid rounded" style="max-height: 80px; object-fit: cover;" loading="lazy">
                        </div>
                    @endif
                    @if($category->icon)
                        <div class="mb-0">
                            <label class="text-muted small">Icon</label>
                            <div><i class="{{ $category->icon }} fa-2x"></i> <code class="ms-2">{{ $category->icon }}</code></div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Hierarchy --}}
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Hierarchy</h6>
                </div>
                <div class="card-body">
                    <dl class="mb-3">
                        <dt class="text-muted small">Parent</dt>
                        <dd>
                            @if($category->parent)
                                <a href="{{ route('admin.categories.show', $category->parent->id) }}" class="text-decoration-none">
                                    <i class="fas fa-level-up-alt me-1"></i> {{ $category->parent->name }}
                                </a>
                            @else
                                <span class="text-muted">None (Top Level)</span>
                            @endif
                        </dd>
                    </dl>
                    <dl class="mb-0">
                        <dt class="text-muted small">Subcategories ({{ $category->children_count }})</dt>
                        <dd>
                            @if($category->children->count() > 0)
                                <div class="list-group list-group-flush">
                                    @foreach($category->children as $child)
                                        <a href="{{ route('admin.categories.show', $child->id) }}"
                                           class="list-group-item list-group-item-action px-0 py-2 border-0 d-flex justify-content-between align-items-center">
                                            <span><i class="fas fa-level-down-alt me-2 text-muted"></i>{{ $child->name }}</span>
                                            <x-admin.category.status-badge :status="$category->status" />
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-muted">No subcategories</span>
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>

            {{-- Statistics --}}
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Total Products</span>
                        <strong>{{ $category->product_count }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Active Products</span>
                        <strong class="text-success">{{ $category->active_product_count }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Out of Stock</span>
                        <strong class="text-danger">{{ $category->out_of_stock_count }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subcategories</span>
                        <strong>{{ $category->children_count }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-0">
                        <span class="text-muted">Sort Order</span>
                        <strong>#{{ $category->sort_order }}</strong>
                    </div>
                </div>
            </div>

            {{-- SEO --}}
            @if($category->meta_title || $category->meta_description || $category->meta_keywords || $category->seo_image)
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">SEO</h6>
                </div>
                <div class="card-body">
                    @if($category->meta_title)
                        <dl class="mb-2">
                            <dt class="text-muted small">SEO Title</dt>
                            <dd class="mb-0">{{ $category->meta_title }}</dd>
                        </dl>
                    @endif
                    @if($category->meta_description)
                        <dl class="mb-2">
                            <dt class="text-muted small">Meta Description</dt>
                            <dd class="mb-0 small">{{ Str::limit($category->meta_description, 150) }}</dd>
                        </dl>
                    @endif
                    @if($category->meta_keywords)
                        <dl class="mb-2">
                            <dt class="text-muted small">Meta Keywords</dt>
                            <dd class="mb-0 small">{{ $category->meta_keywords }}</dd>
                        </dl>
                    @endif
                    @if($category->canonical_url)
                        <dl class="mb-2">
                            <dt class="text-muted small">Canonical URL</dt>
                            <dd class="mb-0 small"><code>{{ $category->canonical_url }}</code></dd>
                        </dl>
                    @endif
                    @if($category->seo_image)
                        <dl class="mb-0">
                            <dt class="text-muted small">SEO Image (OG)</dt>
                            <dd><img src="{{ $category->seo_image_url }}" alt="OG" class="img-fluid rounded" style="max-height: 80px;" loading="lazy"></dd>
                        </dl>
                    @endif
                </div>
            </div>
            @endif

            {{-- Timestamps --}}
            <div class="card">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Timestamps</h6>
                </div>
                <div class="card-body">
                    <dl class="mb-2">
                        <dt class="text-muted small">Created</dt>
                        <dd class="mb-0">{{ $category->created_at->format('M d, Y H:i:s') }}</dd>
                    </dl>
                    <dl class="mb-2">
                        <dt class="text-muted small">Updated</dt>
                        <dd class="mb-0">{{ $category->updated_at->format('M d, Y H:i:s') }}</dd>
                    </dl>
                    <dl class="mb-0">
                        <dt class="text-muted small">Full Slug</dt>
                        <dd class="mb-0"><code>{{ $category->full_slug }}</code></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

</x-layouts.admin-layout>
