<?php

namespace App\Models;

use App\Enums\SupplierStatus;
use App\Traits\HasImageAccessors;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Supplier extends Model
{
    use HasFactory, SoftDeletes, HasImageAccessors, LogsActivity;

    protected $fillable = [
        'supplier_code',
        'name',
        'company_name',
        'contact_person',
        'email',
        'phone',
        'alternative_phone',
        'website',
        'trade_license_number',
        'tax_vat_number',
        'country',
        'state',
        'city',
        'postal_code',
        'full_address',
        'description',
        'logo',
        'status',
        'payment_terms',
        'credit_limit',
        'currency',
        'bank_information',
        'outstanding_balance',
        'last_purchase_date',
    ];

    protected function casts(): array
    {
        return [
            'status' => SupplierStatus::class,
            'credit_limit' => 'decimal:2',
            'outstanding_balance' => 'decimal:2',
            'last_purchase_date' => 'datetime',
        ];
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_supplier')
            ->withPivot(['purchase_price', 'is_preferred'])
            ->withTimestamps();
    }

    public function activityLogs(): MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'subject');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByCountry($query, string $country)
    {
        return $query->where('country', $country);
    }

    public function scopeByCity($query, string $city)
    {
        return $query->where('city', $city);
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
              ->orWhere('company_name', 'like', "%{$term}%")
              ->orWhere('supplier_code', 'like', "%{$term}%")
              ->orWhere('email', 'like', "%{$term}%")
              ->orWhere('phone', 'like', "%{$term}%")
              ->orWhere('contact_person', 'like', "%{$term}%")
              ->orWhere('country', 'like', "%{$term}%")
              ->orWhere('city', 'like', "%{$term}%");
        });
    }

    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo ? Storage::disk('public')->url($this->logo) : null;
    }

    public static function generateCode(): string
    {
        $prefix = config('ecommerce.supplier.code_prefix', 'SUP');
        $last = self::withTrashed()->where('supplier_code', 'like', "{$prefix}-%")
            ->orderBy('id', 'desc')
            ->lockForUpdate()
            ->value('supplier_code');

        if ($last) {
            $num = (int) substr($last, strlen($prefix) + 1) + 1;
        } else {
            $num = 1;
        }

        return $prefix . '-' . str_pad($num, 5, '0', STR_PAD_LEFT);
    }

    protected static function booted(): void
    {
        static::creating(function (Supplier $supplier) {
            if (empty($supplier->supplier_code)) {
                $supplier->supplier_code = self::generateCode();
            }
        });
    }
}
