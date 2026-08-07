@props(['posts' => [], 'title' => 'Latest News'])
@if($posts->isNotEmpty())
    <section class="mb-5">
        <div class="section-header">
            <div class="section-header-left">
                <span class="section-bar"></span>
                <h3>{{ $title }}</h3>
            </div>
            <a href="{{ route('blog') }}" class="section-link">View All <i class="fas fa-arrow-right ms-1" aria-hidden="true"></i></a>
        </div>
        <div class="row g-4">
            @foreach($posts as $post)
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="rounded-top-4 d-flex align-items-center justify-content-center" style="height: 200px; background: linear-gradient(135deg, var(--primary-50), #E0E7FF);">
                            <i class="fas fa-newspaper fa-4x text-primary-custom" style="opacity: 0.4;" aria-hidden="true"></i>
                        </div>
                        <div class="card-body p-4">
                            <h5 class="fw-bold card-title text-gray-800">{{ $post->title ?? 'Blog Post' }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($post->excerpt ?? ($post->body ?? ''), 100) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endif
