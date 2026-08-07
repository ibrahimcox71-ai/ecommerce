<?php

namespace App\Models;

use App\Enums\CustomerType;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Customer extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'user_id',
        'customer_group_id',
        'customer_type',
        'company_name',
        'company_registration_number',
        'tax_number',
        'name',
        'email',
        'phone',
        'avatar',
        'date_of_birth',
        'gender',
        'emergency_contact_name',
        'emergency_contact_phone',
        'notes',
        'reward_points',
        'wallet_balance',
        'referral_code',
        'phone_verified_at',
        'email_verified_at',
        'last_login_at',
        'status',
        'suspended_at',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'customer_type' => CustomerType::class,
            'date_of_birth' => 'date',
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'suspended_at' => 'datetime',
            'reward_points' => 'integer',
            'wallet_balance' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(CustomerGroup::class, 'customer_group_id');
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(CustomerAddress::class);
    }

    public function defaultAddress(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(CustomerAddress::class)->where('is_default', true);
    }

    public function shippingAddresses(): HasMany
    {
        return $this->addresses()->whereIn('type', ['shipping', 'both']);
    }

    public function billingAddress(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(CustomerAddress::class)->whereIn('type', ['billing', 'both']);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function activityLogs(): MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'subject');
    }

    public function orders(): HasManyThrough
    {
        return $this->hasManyThrough(Order::class, User::class, 'id', 'user_id', 'user_id', 'id');
    }

    public function getTotalOrdersAttribute(): int
    {
        return $this->user?->orders()->count() ?? 0;
    }

    public function getTotalSpendAttribute(): float
    {
        return (float) ($this->user?->orders()->whereIn('order_status', ['completed', 'delivered'])->sum('total') ?? 0);
    }

    public function getAverageOrderValueAttribute(): float
    {
        $total = $this->total_orders;
        return $total > 0 ? round($this->total_spend / $total, 2) : 0;
    }

    public function getLastOrderAttribute()
    {
        return $this->user?->orders()->latest()->first();
    }

    public function getCancelledOrdersCountAttribute(): int
    {
        return $this->user?->orders()->where('order_status', 'cancelled')->count() ?? 0;
    }

    public function getReturnedOrdersCountAttribute(): int
    {
        return $this->user?->orders()->whereHas('return')->count() ?? 0;
    }

    public function getAvatarUrlAttribute(): ?string
    {
        return $this->avatar ? Storage::disk('public')->url($this->avatar) : null;
    }

    public function getThumbUrlAttribute(): ?string
    {
        return $this->avatar_url;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeSuspended($query)
    {
        return $query->where('status', 'suspended');
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
              ->orWhere('email', 'like', "%{$term}%")
              ->orWhere('phone', 'like', "%{$term}%")
              ->orWhere('company_name', 'like', "%{$term}%")
              ->orWhere('referral_code', 'like', "%{$term}%");
        });
    }

    public function scopeByCustomerType($query, $type)
    {
        return $query->where('customer_type', $type);
    }

    public function scopeByGroup($query, $groupId)
    {
        return $query->where('customer_group_id', $groupId);
    }

    public function scopeByCity($query, $city)
    {
        return $query->whereHas('addresses', fn($q) => $q->where('city', 'like', "%{$city}%"));
    }

    public function scopeByDateRange($query, $from, $to)
    {
        return $query->whereBetween('created_at', [$from, $to]);
    }

    public function scopeTopCustomers($query, $limit = 10)
    {
        return $query->where('status', 'active')
            ->whereHas('user.orders', fn($q) => $q->whereIn('order_status', ['completed', 'delivered']))
            ->withCount(['user.orders as orders_count' => fn($q) => $q->whereIn('order_status', ['completed', 'delivered'])])
            ->orderByDesc('orders_count')
            ->limit($limit);
    }

    public function scopeHighestSpending($query, $limit = 10)
    {
        return $query->where('status', 'active')
            ->withSum(['user.orders as total_spend_sum' => fn($q) => $q->whereIn('order_status', ['completed', 'delivered'])], 'total')
            ->orderByDesc('total_spend_sum')
            ->limit($limit);
    }

    public function scopeInactiveSince($query, \Carbon\Carbon $date)
    {
        return $query->where('status', 'active')
            ->where(function ($q) use ($date) {
                $q->whereNull('last_login_at')
                  ->orWhere('last_login_at', '<', $date);
            });
    }

    public function scopeGrowthBetween($query, $from, $to)
    {
        return $query->whereBetween('created_at', [$from, $to]);
    }

    public function suspend(): void
    {
        $this->update([
            'status' => 'suspended',
            'suspended_at' => now(),
        ]);
    }

    public function activate(): void
    {
        $this->update([
            'status' => 'active',
            'suspended_at' => null,
        ]);
    }

    public function isSuspended(): bool
    {
        return $this->status === 'suspended';
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function generateReferralCode(): string
    {
        $code = strtoupper(Str::random(8));
        while (static::where('referral_code', $code)->exists()) {
            $code = strtoupper(Str::random(8));
        }
        return $code;
    }

    public function addRewardPoints(int $points): void
    {
        $this->increment('reward_points', $points);
    }

    public function deductRewardPoints(int $points): bool
    {
        if ($this->reward_points < $points) {
            return false;
        }
        $this->decrement('reward_points', $points);
        return true;
    }

    public function addWalletBalance(float $amount): void
    {
        $this->increment('wallet_balance', $amount);
    }

    public function deductWalletBalance(float $amount): bool
    {
        if ($this->wallet_balance < $amount) {
            return false;
        }
        $this->decrement('wallet_balance', $amount);
        return true;
    }

    public function getUserNameAttribute(): ?string
    {
        return $this->user?->name;
    }

    public function getUserEmailAttribute(): ?string
    {
        return $this->user?->email;
    }

    public function getStatusBadgeAttribute(): string
    {
        if ($this->trashed()) {
            return '<span class="badge bg-danger bg-opacity-10 text-danger"><i class="fas fa-trash me-1"></i>Deleted</span>';
        }
        if ($this->isSuspended()) {
            return '<span class="badge bg-warning bg-opacity-10 text-warning"><i class="fas fa-pause-circle me-1"></i>Suspended</span>';
        }
        return '<span class="badge bg-success bg-opacity-10 text-success"><i class="fas fa-check-circle me-1"></i>Active</span>';
    }

    protected static function booted(): void
    {
        static::creating(function (Customer $customer) {
            if (empty($customer->referral_code)) {
                $customer->referral_code = $customer->generateReferralCode();
            }
        });
    }
}
