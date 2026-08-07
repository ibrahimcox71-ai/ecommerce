<?php

namespace App\Models;

use App\Enums\PurchasePaymentStatus;
use App\Enums\PurchaseStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Purchase extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'po_number',
        'supplier_id',
        'warehouse_id',
        'purchase_date',
        'expected_delivery_date',
        'reference_number',
        'status',
        'payment_status',
        'currency',
        'exchange_rate',
        'subtotal',
        'discount_amount',
        'discount_percentage',
        'tax_amount',
        'shipping_cost',
        'other_cost',
        'total_amount',
        'paid_amount',
        'due_amount',
        'notes',
        'terms',
        'attachment',
        'created_by',
        'approved_by',
        'approved_at',
        'ordered_at',
        'completed_at',
        'cancelled_at',
    ];

    protected function casts(): array
    {
        return [
            'purchase_date' => 'date',
            'expected_delivery_date' => 'date',
            'exchange_rate' => 'decimal:4',
            'subtotal' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'discount_percentage' => 'decimal:2',
            'tax_amount' => 'decimal:2',
            'shipping_cost' => 'decimal:2',
            'other_cost' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'paid_amount' => 'decimal:2',
            'due_amount' => 'decimal:2',
            'approved_at' => 'datetime',
            'ordered_at' => 'datetime',
            'completed_at' => 'datetime',
            'cancelled_at' => 'datetime',
            'status' => PurchaseStatus::class,
            'payment_status' => PurchasePaymentStatus::class,
        ];
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function goodsReceipts(): HasMany
    {
        return $this->hasMany(GoodsReceipt::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(PurchasePayment::class);
    }

    public function returns(): HasMany
    {
        return $this->hasMany(PurchaseReturn::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'approved_by');
    }

    public function scopeDraft($q)
    {
        return $q->where('status', 'draft');
    }

    public function scopePending($q)
    {
        return $q->where('status', 'pending');
    }

    public function scopeApproved($q)
    {
        return $q->where('status', 'approved');
    }

    public function scopeCompleted($q)
    {
        return $q->where('status', 'completed');
    }

    public function scopeCancelled($q)
    {
        return $q->where('status', 'cancelled');
    }

    public function scopeUnpaid($q)
    {
        return $q->where('payment_status', 'unpaid');
    }

    public function scopeOverdue($q)
    {
        return $q->where('payment_status', '!=', 'paid')
            ->where('expected_delivery_date', '<', now());
    }

    public function scopeBySupplier($q, $supplierId)
    {
        return $q->where('supplier_id', $supplierId);
    }

    public function scopeByDateRange($q, $from, $to)
    {
        return $q->whereBetween('purchase_date', [$from, $to]);
    }

    public function isEditable(): bool
    {
        return in_array($this->status->value, ['draft', 'pending']);
    }

    public function isApprovable(): bool
    {
        return $this->status->value === 'pending';
    }

    public function isReceivable(): bool
    {
        return in_array($this->status->value, ['approved', 'ordered', 'partially_received']);
    }

    public function isCancellable(): bool
    {
        return !in_array($this->status->value, ['completed', 'cancelled', 'returned']);
    }

    public function isDeletable(): bool
    {
        return in_array($this->status->value, ['draft', 'cancelled']);
    }

    public static function generatePONumber(): string
    {
        $prefix = config('ecommerce.purchase.po_prefix', 'PO');
        $year = now()->format('Y');
        $month = now()->format('m');

        $lastPO = self::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->lockForUpdate()
            ->orderBy('id', 'desc')
            ->first();

        $sequence = $lastPO ? (int) substr($lastPO->po_number, -4) + 1 : 1;

        return sprintf('%s-%s%s-%04d', $prefix, $year, $month, $sequence);
    }
}
