@props([
    'title' => 'Trashed Items',
    'count' => 0,
    'actions' => '',
    'indexRoute' => '#',
    'entity' => 'Items',
])
<div class="alert alert-info d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3" role="status">
    <div>
        <i class="fas fa-trash-restore me-2" aria-hidden="true"></i>
        <strong>{{ $title }}</strong>
        <span class="ms-2 text-muted">{{ $count }} item(s)</span>
    </div>
    <div class="d-flex gap-2">
        {{ $actions }}
        <a href="{{ $indexRoute }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1" aria-hidden="true"></i> Back to {{ $entity }}
        </a>
    </div>
</div>
