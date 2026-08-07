<x-layouts.customer-layout title="Notifications">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">Notifications</h4>
        </div>
        @if ($notifications->total() > 0)
            <div class="d-flex gap-2">
                <form method="POST" action="{{ route('customer.notifications.read-all') }}">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-check-double me-1"></i>Mark All as Read
                    </button>
                </form>
            </div>
        @endif
    </div>

    @if ($notifications->isEmpty())
        <div class="card">
            <div class="card-body text-center py-5 text-muted">
                <i class="fas fa-bell fa-3x mb-3"></i>
                <p>No notifications yet.</p>
            </div>
        </div>
    @else
        <div class="list-group">
            @foreach ($notifications as $notification)
                <div class="list-group-item list-group-item-action border-0 shadow-sm mb-2 rounded
                    {{ is_null($notification->read_at) ? 'border-start border-primary border-4' : '' }}">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="d-flex gap-3 align-items-start">
                            <div class="rounded-circle bg-{{ $notification->data['color'] ?? 'primary' }} bg-opacity-10 p-3 d-flex align-items-center justify-content-center"
                                 style="width: 48px; height: 48px;">
                                <i class="fas fa-{{ $notification->data['icon'] ?? 'bell' }} text-{{ $notification->data['color'] ?? 'primary' }}"></i>
                            </div>
                            <div>
                                <p class="mb-1 fw-semibold">{{ $notification->data['title'] ?? 'Notification' }}</p>
                                @if (isset($notification->data['message']))
                                    <p class="mb-1 text-muted small">{{ $notification->data['message'] }}</p>
                                @endif
                                <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            @if (is_null($notification->read_at))
                                <form method="POST" action="{{ route('customer.notifications.read', $notification) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-link text-success p-0" title="Mark as read">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('customer.notifications.destroy', $notification) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-link text-danger p-0" title="Delete"
                                        onclick="return confirm('Delete this notification?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $notifications->links() }}
        </div>
    @endif
</x-layouts.customer-layout>
