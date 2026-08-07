<x-layouts.admin-layout title="Brand Details">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">{{ $brand->name }}</h4>
            <p class="text-muted small mb-0">Brand details and information</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.brands.edit', $brand->id) }}" class="btn btn-primary">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
            <a href="{{ route('admin.brands.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="row g-4">
        {{-- Main Info --}}
        <div class="col-lg-8">
            {{-- Basic Info --}}
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Basic Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <dl class="mb-0">
                                <dt class="text-muted small">Brand Name</dt>
                                <dd class="fw-semibold mb-0">{{ $brand->name }}</dd>
                            </dl>
                        </div>
                        <div class="col-md-6 mb-3">
                            <dl class="mb-0">
                                <dt class="text-muted small">Brand Code</dt>
                                <dd class="mb-0">
                                    @if($brand->brand_code)
                                        <span class="badge bg-light text-dark border">{{ $brand->brand_code }}</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </dd>
                            </dl>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <dl class="mb-0">
                                <dt class="text-muted small">Slug</dt>
                                <dd class="mb-0"><code>{{ $brand->slug }}</code></dd>
                            </dl>
                        </div>
                        <div class="col-md-6 mb-3">
                            <dl class="mb-0">
                                <dt class="text-muted small">Country</dt>
                                <dd class="mb-0">{{ $brand->country ?? '—' }}</dd>
                            </dl>
                        </div>
                    </div>

                    @if($brand->description)
                        <hr>
                        <dl class="mb-0">
                            <dt class="text-muted small">Description</dt>
                            <dd>{{ $brand->description }}</dd>
                        </dl>
                    @endif

                    <hr>
                    <div class="row">
                        @if($brand->website)
                            <div class="col-md-4 mb-2">
                                <dl class="mb-0">
                                    <dt class="text-muted small"><i class="fas fa-globe me-1"></i> Website</dt>
                                    <dd class="mb-0"><a href="{{ $brand->website }}" target="_blank" class="small">{{ $brand->website }}</a></dd>
                                </dl>
                            </div>
                        @endif
                        @if($brand->email)
                            <div class="col-md-4 mb-2">
                                <dl class="mb-0">
                                    <dt class="text-muted small"><i class="fas fa-envelope me-1"></i> Email</dt>
                                    <dd class="mb-0"><a href="mailto:{{ $brand->email }}" class="small">{{ $brand->email }}</a></dd>
                                </dl>
                            </div>
                        @endif
                        @if($brand->phone)
                            <div class="col-md-4 mb-2">
                                <dl class="mb-0">
                                    <dt class="text-muted small"><i class="fas fa-phone me-1"></i> Phone</dt>
                                    <dd class="mb-0 small">{{ $brand->phone }}</dd>
                                </dl>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Banner --}}
            @if($brand->banner)
                <div class="card mb-4">
                    <div class="card-header bg-transparent">
                        <h6 class="fw-bold mb-0">Banner</h6>
                    </div>
                    <div class="card-body p-0">
                        <img src="{{ $brand->banner_url }}" alt="{{ $brand->name }} Banner"
                             class="img-fluid rounded-bottom w-100" style="max-height: 300px; object-fit: cover;">
                    </div>
                </div>
            @endif

            {{-- Activity Log --}}
            <div class="card">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Activity Log</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 ps-4">Action</th>
                                    <th class="border-0">By</th>
                                    <th class="border-0 pe-4 text-end">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($brand->activityLogs()->latest()->take(20)->get() as $log)
                                    <tr>
                                        <td class="ps-4">
                                            <span class="badge bg-{{ str_contains($log->description, 'created') ? 'success' : (str_contains($log->description, 'updated') ? 'info' : (str_contains($log->description, 'restored') ? 'warning' : 'secondary')) }}">
                                                {{ $log->description }}
                                            </span>
                                        </td>
                                        <td class="small">
                                            @if($log->causer)
                                                {{ $log->causer->name ?? 'Unknown' }}
                                            @else
                                                <span class="text-muted">System</span>
                                            @endif
                                        </td>
                                        <td class="pe-4 text-end text-muted small">
                                            {{ $log->created_at->format('M d, Y H:i') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-muted">
                                            No activity logs found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">
            {{-- Logo & Status --}}
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Logo & Status</h6>
                </div>
                <div class="card-body text-center">
                    @if($brand->logo)
                        <img src="{{ $brand->logo_url }}" alt="{{ $brand->name }}"
                             class="img-fluid rounded mb-3" style="max-height: 150px;">
                    @elseif($brand->image)
                        <img src="{{ $brand->image_url }}" alt="{{ $brand->name }}"
                             class="img-fluid rounded mb-3" style="max-height: 150px;">
                    @else
                        <div class="bg-light rounded p-4 mb-3">
                            <i class="fas fa-building fa-3x text-muted"></i>
                        </div>
                    @endif

                    <div class="d-flex justify-content-center gap-2 flex-wrap mb-0">
                        @php
                            $statusColors = ['active' => 'success', 'inactive' => 'secondary', 'hidden' => 'dark'];
                            $statusIcons = ['active' => 'fa-check-circle', 'inactive' => 'fa-pause-circle', 'hidden' => 'fa-eye-slash'];
                        @endphp
                        <span class="badge bg-{{ $statusColors[$brand->status->value] ?? 'secondary' }}">
                            <i class="fas {{ $statusIcons[$brand->status->value] ?? 'fa-circle' }} me-1"></i>
                            {{ $brand->status->label() }}
                        </span>
                        @if($brand->featured)
                            <span class="badge bg-warning"><i class="fas fa-star me-1"></i> Featured</span>
                        @endif
                        @if($brand->popular)
                            <span class="badge bg-info"><i class="fas fa-fire me-1"></i> Popular</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Product Stats --}}
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="fw-bold mb-0">Product Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Total Products</span>
                        <span class="badge bg-primary">{{ $brand->products_count }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Active Products</span>
                        <span class="badge bg-success">{{ $brand->active_products_count }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-0">
                        <span class="text-muted">Sort Order</span>
                        <span class="fw-semibold">{{ $brand->sort_order }}</span>
                    </div>
                </div>
            </div>

            {{-- SEO --}}
            @if($brand->meta_title || $brand->meta_description || $brand->meta_keywords || $brand->canonical_url)
                <div class="card mb-4">
                    <div class="card-header bg-transparent">
                        <h6 class="fw-bold mb-0">SEO</h6>
                    </div>
                    <div class="card-body">
                        @if($brand->meta_title)
                            <dl class="mb-2">
                                <dt class="text-muted small">Meta Title</dt>
                                <dd class="mb-0 small">{{ $brand->meta_title }}</dd>
                            </dl>
                        @endif
                        @if($brand->meta_description)
                            <dl class="mb-2">
                                <dt class="text-muted small">Meta Description</dt>
                                <dd class="mb-0 small">{{ Str::limit($brand->meta_description, 100) }}</dd>
                            </dl>
                        @endif
                        @if($brand->meta_keywords)
                            <dl class="mb-2">
                                <dt class="text-muted small">Meta Keywords</dt>
                                <dd class="mb-0 small">{{ $brand->meta_keywords }}</dd>
                            </dl>
                        @endif
                        @if($brand->canonical_url)
                            <dl class="mb-0">
                                <dt class="text-muted small">Canonical URL</dt>
                                <dd class="mb-0 small"><a href="{{ $brand->canonical_url }}" target="_blank">{{ Str::limit($brand->canonical_url, 40) }}</a></dd>
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
                        <dd class="mb-0">{{ $brand->created_at->format('M d, Y H:i') }}</dd>
                    </dl>
                    <dl class="mb-2">
                        <dt class="text-muted small">Updated</dt>
                        <dd class="mb-0">{{ $brand->updated_at->format('M d, Y H:i') }}</dd>
                    </dl>
                    @if($brand->is_hidden)
                        <dl class="mb-0">
                            <dt class="text-muted small">Visibility</dt>
                            <dd class="mb-0"><span class="badge bg-dark">Hidden from listings</span></dd>
                        </dl>
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-layouts.admin-layout>
