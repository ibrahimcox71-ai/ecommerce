@props(['categories' => []])
@if($categories->isNotEmpty())
    <div class="mega-menu-v2" role="navigation" aria-label="Category navigation">
        <div class="container">
            <div class="row g-4">
                @foreach($categories as $category)
                    <div class="col-lg-3">
                        <a href="{{ route('category.show', $category->slug) }}" class="text-decoration-none fw-semibold text-gray-800 d-block mb-2">{{ $category->name }}</a>
                        @if(($category->children ?? collect())->isNotEmpty())
                            <ul class="list-unstyled mb-3">
                                @foreach($category->children as $child)
                                    <li class="mb-1">
                                        <a href="{{ route('category.show', $child->slug) }}" class="text-muted small text-decoration-none">{{ $child->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
