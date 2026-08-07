@props([
    'id' => 'confirmDeleteModal',
    'title' => 'Confirm Delete',
    'message' => 'Are you sure you want to delete this item? This action cannot be undone.',
    'cancelText' => 'Cancel',
    'confirmText' => 'Delete',
    'confirmBtnId' => 'confirmDeleteBtn',
    'formId' => 'deleteForm',
    'action' => '#',
    'entity' => 'item',
])
<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog" aria-modal="true" aria-labelledby="{{ $id }}Label">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $id }}Label">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger mb-0">
                    <i class="fas fa-exclamation-triangle me-2" aria-hidden="true"></i>
                    {{ $message }}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ $cancelText }}</button>
                <button type="button" class="btn btn-danger" id="{{ $confirmBtnId }}"
                        data-entity="{{ $entity }}">
                    <i class="fas fa-trash me-1" aria-hidden="true"></i> {{ $confirmText }}
                </button>
                <form id="{{ $formId }}" method="POST" class="d-none" action="{{ $action }}">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
</div>
