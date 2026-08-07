@props(['price' => 0, 'costPrice' => 0, 'tax' => 0, 'taxType' => 'exclusive', 'discount' => 0, 'discountType' => 'percentage'])

<div class="profit-calculator p-3 bg-light rounded" role="region" aria-label="Profit Calculator" aria-live="polite">
    <h6 class="fw-semibold mb-3"><i class="fas fa-chart-line me-2 text-primary" aria-hidden="true"></i>Profit Calculator</h6>
    <div class="row g-2 small">
        <div class="col-6">
            <span class="text-muted">Sale Price:</span>
            <span class="fw-semibold float-end" id="calcSalePrice">{{ config('ecommerce.currency_symbol') }}0.00</span>
        </div>
        <div class="col-6">
            <span class="text-muted">Cost Price:</span>
            <span class="fw-semibold float-end" id="calcCostPrice">{{ config('ecommerce.currency_symbol') }}0.00</span>
        </div>
        <div class="col-12"><hr class="my-1"></div>
        <div class="col-6">
            <span class="text-muted">Profit:</span>
            <span class="fw-semibold float-end text-success" id="calcProfit">{{ config('ecommerce.currency_symbol') }}0.00</span>
        </div>
        <div class="col-6">
            <span class="text-muted">Margin:</span>
            <span class="fw-semibold float-end text-primary" id="calcMargin">0%</span>
        </div>
        <div class="col-12"><hr class="my-1"></div>
        <div class="col-6">
            <span class="text-muted">Tax ({{ $tax }}%):</span>
            <span class="fw-semibold float-end" id="calcTax">{{ config('ecommerce.currency_symbol') }}0.00</span>
        </div>
        <div class="col-6">
            <span class="text-muted">After Tax:</span>
            <span class="fw-semibold float-end" id="calcAfterTax">{{ config('ecommerce.currency_symbol') }}0.00</span>
        </div>
    </div>
</div>
