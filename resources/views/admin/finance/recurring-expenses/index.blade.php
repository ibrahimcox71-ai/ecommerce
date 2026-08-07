<x-layouts.admin-layout title="Recurring Expenses">
    <x-admin.crud-header
        title="Recurring Expenses"
        subtitle="Manage recurring/predictable expenses"
        :buttons="[
            ['label' => 'Add Recurring Expense', 'route' => 'admin.finance.recurring-expenses.create', 'icon' => 'bi bi-plus-lg'],
        ]"
    />

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Interval</th>
                            <th>Payee</th>
                            <th>Next Due</th>
                            <th>Occurrences</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recurrings as $r)
                            <tr>
                                <td>{{ $r->category?->name ?? '—' }}</td>
                                <td class="fw-semibold">{{ number_format($r->amount, 2) }}</td>
                                <td>{{ ucwords(str_replace('_', ' ', $r->interval)) }}</td>
                                <td>{{ $r->payee ?? '—' }}</td>
                                <td>{{ $r->next_due_date?->format('d/m/Y') ?? '—' }}</td>
                                <td>{{ $r->occurrences }}/{{ $r->max_occurrences ?? '∞' }}</td>
                                <td>
                                    <span class="badge bg-{{ $r->isActive() ? 'success' : ($r->status === 'paused' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst($r->status) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.finance.recurring-expenses.edit', $r->id) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                                    <form method="POST" action="{{ route('admin.finance.recurring-expenses.toggle-status', $r->id) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-{{ $r->isActive() ? 'warning' : 'success' }}"
                                                title="{{ $r->isActive() ? 'Pause' : 'Activate' }}">
                                            <i class="bi bi-{{ $r->isActive() ? 'pause' : 'play' }}"></i>
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.finance.recurring-expenses.destroy', $r->id) }}" class="d-inline" onsubmit="return confirm('Cancel this recurring expense?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Cancel"><i class="bi bi-x-lg"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
                                    <x-admin.empty-state icon="bi bi-arrow-repeat" message="No recurring expenses found." buttonLabel="Add Recurring Expense" buttonRoute="admin.finance.recurring-expenses.create" />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($recurrings->hasPages())<div class="card-footer d-flex justify-content-center">{{ $recurrings->links() }}</div>@endif
    </div>
</x-layouts.admin-layout>
