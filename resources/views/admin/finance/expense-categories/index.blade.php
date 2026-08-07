<x-layouts.admin-layout title="Expense Categories">
    <x-admin.crud-header
        title="Expense Categories"
        subtitle="Manage expense categorization"
        :buttons="[
            ['label' => 'Add Category', 'route' => 'admin.finance.expense-categories.create', 'icon' => 'bi bi-plus-lg'],
        ]"
    />

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Parent</th>
                            <th class="text-center">Expenses</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td class="fw-semibold">{{ $category->name }}</td>
                                <td><span class="badge bg-info">{{ $category->type ?? '—' }}</span></td>
                                <td>{{ $category->parent?->name ?? '—' }}</td>
                                <td class="text-center">{{ $category->expenses_count }}</td>
                                <td>
                                    <span class="badge bg-{{ $category->is_active ? 'success' : 'secondary' }}">
                                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.finance.expense-categories.edit', $category->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.finance.expense-categories.destroy', $category->id) }}" class="d-inline" onsubmit="return confirm('Delete this category?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <x-admin.empty-state
                                        icon="bi bi-tag"
                                        message="No expense categories found."
                                        buttonLabel="Add Category"
                                        buttonRoute="admin.finance.expense-categories.create"
                                    />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($categories->hasPages())
            <div class="card-footer d-flex justify-content-center">{{ $categories->links() }}</div>
        @endif
    </div>
</x-layouts.admin-layout>
