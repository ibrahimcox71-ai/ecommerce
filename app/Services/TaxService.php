<?php

namespace App\Services;

use App\Models\TaxGroup;
use App\Models\TaxRate;
use App\Models\TaxItem;
use Illuminate\Support\Collection;

class TaxService
{
    public function calculateTax(float $amount, ?int $taxGroupId = null, ?string $region = null): array
    {
        $rates = $this->getApplicableRates($taxGroupId, $region);
        $taxAmount = 0;
        $breakdown = [];

        foreach ($rates as $rate) {
            $isCompound = $rate->is_compound;
            $calculatedTax = $amount * ($rate->rate / 100);

            if ($isCompound) {
                $calculatedTax = ($amount + $taxAmount) * ($rate->rate / 100);
            }

            $taxAmount += $calculatedTax;
            $breakdown[] = [
                'rate_id' => $rate->id,
                'rate_name' => $rate->name,
                'rate' => $rate->rate,
                'amount' => $calculatedTax,
                'is_compound' => $isCompound,
            ];
        }

        return [
            'total_tax' => $taxAmount,
            'total_with_tax' => $amount + $taxAmount,
            'breakdown' => $breakdown,
        ];
    }

    public function applyTaxToModel(Model $model, float $amount, ?int $taxGroupId = null, ?string $region = null): void
    {
        $result = $this->calculateTax($amount, $taxGroupId, $region);

        foreach ($result['breakdown'] as $item) {
            TaxItem::create([
                'taxable_type' => get_class($model),
                'taxable_id' => $model->id,
                'tax_rate_id' => $item['rate_id'],
                'amount' => $item['amount'],
                'rate' => $item['rate'],
                'region' => $region,
            ]);
        }
    }

    protected function getApplicableRates(?int $taxGroupId = null, ?string $region = null): Collection
    {
        $query = TaxRate::active();

        if ($taxGroupId) {
            $query->where('tax_group_id', $taxGroupId);
        } else {
            $defaultGroup = TaxGroup::default()->first();
            if ($defaultGroup) {
                $query->where('tax_group_id', $defaultGroup->id);
            }
        }

        if ($region) {
            $query->where(function ($q) use ($region) {
                $q->where('region', $region)->orWhereNull('region');
            });
        }

        return $query->orderBy('priority')->get();
    }
}
