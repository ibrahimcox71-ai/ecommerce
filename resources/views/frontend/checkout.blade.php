<x-layouts.frontend-layout>
@php $title = 'Checkout' @endphp

<div class="checkout-page">
    <div class="container py-4">
        <x-breadcrumb :items="[
            ['label' => 'Cart', 'url' => route('cart')],
            ['label' => 'Checkout'],
        ]" />

        {{-- Checkout Steps --}}
        <div class="checkout-steps">
            <div class="step active">
                <div class="step-circle">1</div>
                <div class="step-info">
                    <span class="step-label">Cart</span>
                </div>
            </div>
            <div class="step-connector active"></div>
            <div class="step active">
                <div class="step-circle">2</div>
                <div class="step-info">
                    <span class="step-label">Checkout</span>
                </div>
            </div>
            <div class="step-connector"></div>
            <div class="step">
                <div class="step-circle">3</div>
                <div class="step-info">
                    <span class="step-label">Confirmation</span>
                </div>
            </div>
        </div>

        <form id="checkoutForm" class="checkout-form">
            @csrf
            <div class="row g-4">
                <div class="col-lg-7 col-xl-8">
                    {{-- Guest/Login Prompt --}}
                    @if ($isGuest)
                        <div class="checkout-section guest-section">
                            <div class="guest-info">
                                <i class="fas fa-user"></i>
                                <span>Checking out as guest</span>
                                <a href="{{ route('login') }}?redirect={{ urlencode(route('checkout')) }}" class="btn-guest-login">Sign in for faster checkout</a>
                            </div>
                        </div>
                    @endif

                    {{-- Shipping Address --}}
                    <div class="checkout-section">
                        <div class="section-title">
                            <i class="fas fa-map-marker-alt"></i>
                            <h5>Shipping Address</h5>
                        </div>
                        <div class="section-body">
                            @if ($addresses->isNotEmpty())
                                <div class="saved-addresses">
                                    <label class="saved-label">Saved Addresses</label>
                                    <div class="address-cards">
                                        @foreach ($addresses as $addr)
                                            <div class="address-card {{ $loop->first ? 'selected' : '' }}">
                                                <input type="radio" name="saved_address_id" value="{{ $addr->id }}"
                                                       id="addr_{{ $addr->id }}"
                                                       class="address-radio"
                                                       data-name="{{ $addr->name }}"
                                                       data-email="{{ $addr->email }}"
                                                       data-phone="{{ $addr->phone }}"
                                                       data-line1="{{ $addr->address_line1 }}"
                                                       data-line2="{{ $addr->address_line2 }}"
                                                       data-city="{{ $addr->city }}"
                                                       data-state="{{ $addr->state }}"
                                                       data-zip="{{ $addr->zip }}"
                                                       data-country="{{ $addr->country }}"
                                                       {{ $loop->first ? 'checked' : '' }}>
                                                <label for="addr_{{ $addr->id }}" class="address-card-label">
                                                    <strong>{{ $addr->name }}</strong>
                                                    <span>{{ $addr->getFullAddress() }}</span>
                                                    @if ($addr->phone)
                                                        <small>{{ $addr->phone }}</small>
                                                    @endif
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="or-divider"><span>Or enter a new address</span></div>
                                </div>
                            @endif

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="field-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="field-input" name="shipping_address[name]" required placeholder="John Doe">
                                </div>
                                <div class="col-md-6">
                                    <label class="field-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="field-input" name="shipping_address[email]" required
                                           placeholder="john@example.com"
                                           @auth value="{{ auth()->user()->email }}" @endauth>
                                </div>
                                <div class="col-md-6">
                                    <label class="field-label">Phone <span class="text-danger">*</span></label>
                                    <input type="tel" class="field-input" name="shipping_address[phone]" required placeholder="+1 (555) 000-0000">
                                </div>
                                <div class="col-12">
                                    <label class="field-label">Address Line 1 <span class="text-danger">*</span></label>
                                    <input type="text" class="field-input" name="shipping_address[address_line1]" required placeholder="123 Main Street">
                                </div>
                                <div class="col-12">
                                    <label class="field-label">Address Line 2</label>
                                    <input type="text" class="field-input" name="shipping_address[address_line2]" placeholder="Apt, Suite, etc. (optional)">
                                </div>
                                <div class="col-md-5">
                                    <label class="field-label">City <span class="text-danger">*</span></label>
                                    <input type="text" class="field-input" name="shipping_address[city]" required placeholder="New York">
                                </div>
                                <div class="col-md-4">
                                    <label class="field-label">State</label>
                                    <input type="text" class="field-input" name="shipping_address[state]" placeholder="NY">
                                </div>
                                <div class="col-md-3">
                                    <label class="field-label">ZIP Code</label>
                                    <input type="text" class="field-input" name="shipping_address[zip]" placeholder="10001">
                                </div>
                                <div class="col-12">
                                    <label class="field-label">Country <span class="text-danger">*</span></label>
                                    <select class="field-select" name="shipping_address[country]" required>
                                        <option value="US">United States</option>
                                        <option value="CA">Canada</option>
                                        <option value="GB">United Kingdom</option>
                                        <option value="AU">Australia</option>
                                        <option value="DE">Germany</option>
                                        <option value="FR">France</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Billing Address --}}
                    <div class="checkout-section">
                        <div class="section-title">
                            <i class="fas fa-file-invoice"></i>
                            <h5>Billing Address</h5>
                        </div>
                        <div class="section-body">
                            <div class="billing-same">
                                <label class="custom-toggle">
                                    <input type="checkbox" name="billing_same" id="billingSame" value="1" checked>
                                    <span class="toggle-track"><span class="toggle-thumb"></span></span>
                                    <span class="toggle-label">Same as shipping address</span>
                                </label>
                            </div>
                            <div id="billingFields" style="display: none;">
                                <div class="row g-3 mt-2">
                                    <div class="col-md-6">
                                        <label class="field-label">Full Name</label>
                                        <input type="text" class="field-input" name="billing_address[name]">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="field-label">Email</label>
                                        <input type="email" class="field-input" name="billing_address[email]">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="field-label">Phone</label>
                                        <input type="tel" class="field-input" name="billing_address[phone]">
                                    </div>
                                    <div class="col-12">
                                        <label class="field-label">Address Line 1</label>
                                        <input type="text" class="field-input" name="billing_address[address_line1]">
                                    </div>
                                    <div class="col-12">
                                        <label class="field-label">Address Line 2</label>
                                        <input type="text" class="field-input" name="billing_address[address_line2]">
                                    </div>
                                    <div class="col-md-5">
                                        <label class="field-label">City</label>
                                        <input type="text" class="field-input" name="billing_address[city]">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="field-label">State</label>
                                        <input type="text" class="field-input" name="billing_address[state]">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="field-label">ZIP Code</label>
                                        <input type="text" class="field-input" name="billing_address[zip]">
                                    </div>
                                    <div class="col-12">
                                        <label class="field-label">Country</label>
                                        <select class="field-select" name="billing_address[country]">
                                            <option value="US">United States</option>
                                            <option value="CA">Canada</option>
                                            <option value="GB">United Kingdom</option>
                                            <option value="AU">Australia</option>
                                            <option value="DE">Germany</option>
                                            <option value="FR">France</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Shipping Method --}}
                    <div class="checkout-section">
                        <div class="section-title">
                            <i class="fas fa-truck"></i>
                            <h5>Shipping Method</h5>
                        </div>
                        <div class="section-body">
                            <div class="shipping-methods">
                                @foreach ($shippingMethods as $key => $method)
                                    <div class="shipping-method-card {{ $key === 'standard' ? 'selected' : '' }}">
                                        <input type="radio" name="shipping_method" value="{{ $key }}"
                                               id="ship_{{ $key }}"
                                               class="shipping-radio"
                                               data-cost="{{ $method['cost'] }}"
                                               {{ $key === 'standard' ? 'checked' : '' }}>
                                        <label for="ship_{{ $key }}" class="shipping-label">
                                            <div class="shipping-left">
                                                <div class="shipping-icon">
                                                    @if ($key === 'free') <i class="fas fa-leaf"></i>
                                                    @elseif ($key === 'express') <i class="fas fa-rocket"></i>
                                                    @elseif ($key === 'overnight') <i class="fas fa-bolt"></i>
                                                    @else <i class="fas fa-truck"></i>
                                                    @endif
                                                </div>
                                                <div>
                                                    <strong>{{ $method['label'] }}</strong>
                                                    <span class="shipping-estimate">{{ $method['estimate'] }}</span>
                                                </div>
                                            </div>
                                            <div class="shipping-price">
                                                @if ($method['cost'] > 0)
                                                    ${{ number_format($method['cost'], 2) }}
                                                @else
                                                    <span class="free-tag">FREE</span>
                                                @endif
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Payment Method --}}
                    <div class="checkout-section">
                        <div class="section-title">
                            <i class="fas fa-credit-card"></i>
                            <h5>Payment Method</h5>
                        </div>
                        <div class="section-body">
                            <div class="payment-methods">
                                <div class="payment-method-card selected">
                                    <input type="radio" name="payment_method" value="cod" id="pay_cod" class="payment-radio" checked>
                                    <label for="pay_cod" class="payment-label">
                                        <div class="payment-left">
                                            <div class="payment-icon"><i class="fas fa-money-bill-wave"></i></div>
                                            <div>
                                                <strong>Cash on Delivery</strong>
                                                <span class="payment-desc">Pay when you receive your order</span>
                                            </div>
                                        </div>
                                        <div class="payment-check"><i class="fas fa-check-circle"></i></div>
                                    </label>
                                </div>
                                <div class="payment-method-card">
                                    <input type="radio" name="payment_method" value="stripe" id="pay_stripe" class="payment-radio">
                                    <label for="pay_stripe" class="payment-label">
                                        <div class="payment-left">
                                            <div class="payment-icon"><i class="fab fa-stripe"></i></div>
                                            <div>
                                                <strong>Credit / Debit Card</strong>
                                                <span class="payment-desc">Visa, Mastercard, Amex</span>
                                            </div>
                                        </div>
                                        <div class="payment-check"><i class="fas fa-check-circle"></i></div>
                                    </label>
                                </div>
                                <div class="payment-method-card">
                                    <input type="radio" name="payment_method" value="paypal" id="pay_paypal" class="payment-radio">
                                    <label for="pay_paypal" class="payment-label">
                                        <div class="payment-left">
                                            <div class="payment-icon"><i class="fab fa-paypal"></i></div>
                                            <div>
                                                <strong>PayPal</strong>
                                                <span class="payment-desc">Pay with your PayPal account</span>
                                            </div>
                                        </div>
                                        <div class="payment-check"><i class="fas fa-check-circle"></i></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Order Notes --}}
                    <div class="checkout-section">
                        <div class="section-title">
                            <i class="fas fa-sticky-note"></i>
                            <h5>Order Notes</h5>
                        </div>
                        <div class="section-body">
                            <textarea class="field-input field-textarea" name="notes" rows="3" placeholder="Special instructions for delivery (optional)"></textarea>
                        </div>
                    </div>
                </div>

                {{-- Order Summary Sidebar --}}
                <div class="col-lg-5 col-xl-4">
                    <div class="checkout-summary-sticky">
                        <div class="checkout-summary-card">
                            <h5 class="summary-card-title">Order Summary</h5>

                            <div class="summary-items">
                                @foreach ($cart->items as $item)
                                    <div class="summary-item">
                                        <img src="{{ $item->getProductImage() ?? 'https://placehold.co/50x50/f0f0f0/999?text=N' }}"
                                             alt="{{ $item->getProductTitle() }}" class="summary-item-img">
                                        <div class="summary-item-info">
                                            <span class="summary-item-name">{{ Str::limit($item->product->name, 30) }}</span>
                                            @if ($item->variant)
                                                <span class="summary-item-variant">{{ $item->variant->getAttributesList() }}</span>
                                            @endif
                                            <span class="summary-item-qty">Qty: {{ $item->quantity }}</span>
                                        </div>
                                        <span class="summary-item-price">${{ number_format($item->subtotal, 2) }}</span>
                                    </div>
                                @endforeach
                            </div>

                            <div class="summary-divider"></div>

                            <div class="summary-calc">
                                <div class="calc-row">
                                    <span>Subtotal</span>
                                    <span id="checkoutSubtotal">${{ number_format($cart->subtotal, 2) }}</span>
                                </div>
                                @if ($cart->coupon_id)
                                    <div class="calc-row text-success">
                                        <span>Coupon ({{ $cart->coupon->code ?? '' }})</span>
                                        <span id="checkoutDiscount">-${{ number_format($cart->coupon_discount, 2) }}</span>
                                    </div>
                                @endif
                                <div class="calc-row">
                                    <span>Shipping</span>
                                    <span id="checkoutShipping">
                                        @if ($cart->shipping_cost > 0)
                                            ${{ number_format($cart->shipping_cost, 2) }}
                                        @else
                                            <span class="free-tag-sm">FREE</span>
                                        @endif
                                    </span>
                                </div>
                                <div class="calc-row">
                                    <span>Tax</span>
                                    <span id="checkoutTax">${{ number_format($cart->tax_amount, 2) }}</span>
                                </div>
                            </div>

                            <div class="summary-divider"></div>

                            <div class="calc-total">
                                <span>Total</span>
                                <span id="checkoutTotal">${{ number_format($cart->total, 2) }}</span>
                            </div>

                            <button type="submit" class="btn-place-order btn-ripple" id="placeOrderBtn">
                                <i class="fas fa-lock"></i>
                                <span>Place Order</span>
                            </button>

                            <div class="summary-security">
                                <i class="fas fa-shield-alt"></i>
                                <span>Your information is secure and encrypted</span>
                            </div>

                            <div class="summary-payment-icons">
                                <i class="fab fa-cc-visa"></i>
                                <i class="fab fa-cc-mastercard"></i>
                                <i class="fab fa-cc-amex"></i>
                                <i class="fab fa-cc-paypal"></i>
                                <i class="fab fa-cc-discover"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
.checkout-page { min-height: 60vh; background: #F8FAFC; }
.checkout-steps { display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 32px; padding: 20px; background: #fff; border-radius: 14px; border: 1px solid #E5E7EB; }
.step { display: flex; align-items: center; gap: 8px; }
.step-circle { width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 13px; background: #F3F4F6; color: #9CA3AF; }
.step.active .step-circle { background: var(--gradient-primary); color: #fff; box-shadow: 0 4px 10px rgba(245,114,36,.25); }
.step-label { font-size: 12px; font-weight: 500; color: #9CA3AF; display: none; }
@media (min-width: 576px) { .step-label { display: inline; } .step.active .step-label { color: var(--primary); font-weight: 600; } }
.step-connector { width: 40px; height: 2px; background: #F3F4F6; }
.step-connector.active { background: var(--gradient-primary); }
.checkout-section { background: #fff; border-radius: 14px; border: 1px solid #E5E7EB; margin-bottom: 14px; overflow: hidden; }
.section-title { display: flex; align-items: center; gap: 10px; padding: 16px 20px; border-bottom: 1px solid #F3F4F6; }
.section-title i { font-size: 16px; color: var(--primary); width: 20px; }
.section-title h5 { margin: 0; font-size: 15px; font-weight: 700; }
.section-body { padding: 20px; }
.guest-section .guest-info { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
.guest-info i { font-size: 20px; color: var(--primary); }
.guest-info span { font-size: 14px; color: var(--gray-700); font-weight: 500; }
.btn-guest-login { margin-left: auto; padding: 8px 18px; border-radius: 10px; border: 1px solid var(--primary); color: var(--primary); font-size: 13px; font-weight: 600; text-decoration: none; transition: all .2s; }
.btn-guest-login:hover { background: var(--primary); color: #fff; }
.saved-label { font-size: 13px; font-weight: 600; color: var(--gray-700); margin-bottom: 10px; display: block; }
.address-cards { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 16px; }
.address-card { border: 2px solid #F3F4F6; border-radius: 12px; padding: 14px; cursor: pointer; transition: all .2s; position: relative; }
.address-card:hover { border-color: #E5E7EB; }
.address-card.selected { border-color: var(--primary); background: rgba(245,114,36,.04); }
.address-radio { display: none; }
.address-card-label { cursor: pointer; display: block; }
.address-card-label strong { display: block; font-size: 14px; color: var(--gray-800); margin-bottom: 4px; }
.address-card-label span { font-size: 13px; color: var(--gray-500); display: block; line-height: 1.4; }
.address-card-label small { font-size: 12px; color: var(--gray-400); margin-top: 4px; display: block; }
.or-divider { text-align: center; font-size: 12px; color: var(--gray-400); margin-bottom: 16px; position: relative; }
.or-divider::before, .or-divider::after { content: ''; position: absolute; top: 50%; width: calc(50% - 60px); height: 1px; background: #F3F4F6; }
.or-divider::before { left: 0; } .or-divider::after { right: 0; }
.or-divider span { background: #fff; padding: 0 12px; }
.field-label { font-size: 13px; font-weight: 500; color: var(--gray-700); margin-bottom: 6px; display: block; }
.field-input { width: 100%; padding: 10px 14px; border: 1px solid #E5E7EB; border-radius: 10px; font-size: 14px; outline: none; transition: all .2s; background: #fff; }
.field-input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(245,114,36,.1); }
.field-select { width: 100%; padding: 10px 14px; border: 1px solid #E5E7EB; border-radius: 10px; font-size: 14px; outline: none; background: #fff; cursor: pointer; }
.field-textarea { resize: vertical; min-height: 80px; }
.custom-toggle { display: inline-flex; align-items: center; gap: 10px; cursor: pointer; user-select: none; }
.custom-toggle input { display: none; }
.toggle-track { width: 40px; height: 22px; background: #D1D5DB; border-radius: 11px; position: relative; transition: background .2s; flex-shrink: 0; }
.toggle-thumb { position: absolute; top: 2px; left: 2px; width: 18px; height: 18px; border-radius: 50%; background: #fff; transition: transform .2s; box-shadow: 0 1px 3px rgba(0,0,0,.15); }
.custom-toggle input:checked + .toggle-track { background: var(--primary); }
.custom-toggle input:checked + .toggle-track .toggle-thumb { transform: translateX(18px); }
.toggle-label { font-size: 14px; color: var(--gray-700); }
.shipping-methods { display: flex; flex-direction: column; gap: 8px; }
.shipping-method-card { border: 2px solid #F3F4F6; border-radius: 12px; transition: all .2s; }
.shipping-method-card:hover { border-color: #E5E7EB; }
.shipping-method-card.selected { border-color: var(--primary); background: rgba(245,114,36,.04); }
.shipping-radio { display: none; }
.shipping-label { display: flex; align-items: center; justify-content: space-between; padding: 14px 16px; cursor: pointer; }
.shipping-left { display: flex; align-items: center; gap: 12px; }
.shipping-icon { width: 40px; height: 40px; border-radius: 10px; background: #F3F4F6; display: flex; align-items: center; justify-content: center; font-size: 16px; color: var(--primary); flex-shrink: 0; }
.shipping-label strong { display: block; font-size: 14px; color: var(--gray-800); }
.shipping-estimate { font-size: 12px; color: var(--gray-500); }
.shipping-price { font-weight: 700; font-size: 15px; color: var(--gray-800); }
.free-tag { color: #059669; background: rgba(16,185,129,.1); padding: 2px 8px; border-radius: 4px; font-size: 12px; font-weight: 700; }
.payment-methods { display: flex; flex-direction: column; gap: 8px; }
.payment-method-card { border: 2px solid #F3F4F6; border-radius: 12px; transition: all .2s; }
.payment-method-card:hover { border-color: #E5E7EB; }
.payment-method-card.selected { border-color: var(--primary); background: rgba(245,114,36,.04); }
.payment-radio { display: none; }
.payment-label { display: flex; align-items: center; justify-content: space-between; padding: 14px 16px; cursor: pointer; }
.payment-left { display: flex; align-items: center; gap: 12px; }
.payment-icon { width: 40px; height: 40px; border-radius: 10px; background: #F3F4F6; display: flex; align-items: center; justify-content: center; font-size: 20px; color: var(--primary); flex-shrink: 0; }
.payment-label strong { display: block; font-size: 14px; color: var(--gray-800); }
.payment-desc { font-size: 12px; color: var(--gray-500); }
.payment-check { font-size: 20px; color: transparent; }
.payment-method-card.selected .payment-check { color: var(--primary); }
.checkout-summary-sticky { position: sticky; top: calc(var(--header-height) + 24px); }
.checkout-summary-card { background: #fff; border-radius: 14px; border: 1px solid #E5E7EB; padding: 24px; }
.summary-card-title { font-size: 17px; font-weight: 700; margin-bottom: 16px; }
.summary-items { max-height: 300px; overflow-y: auto; display: flex; flex-direction: column; gap: 12px; }
.summary-item { display: flex; gap: 10px; align-items: flex-start; }
.summary-item-img { width: 48px; height: 48px; border-radius: 8px; object-fit: cover; flex-shrink: 0; }
.summary-item-info { flex: 1; min-width: 0; }
.summary-item-name { display: block; font-size: 13px; font-weight: 500; color: var(--gray-800); }
.summary-item-variant { display: block; font-size: 11px; color: var(--gray-400); }
.summary-item-qty { display: block; font-size: 11px; color: var(--gray-500); margin-top: 2px; }
.summary-item-price { font-size: 14px; font-weight: 600; color: var(--gray-800); white-space: nowrap; }
.summary-divider { height: 1px; background: #F3F4F6; margin: 14px 0; }
.summary-calc { display: flex; flex-direction: column; gap: 10px; }
.calc-row { display: flex; justify-content: space-between; font-size: 14px; color: var(--gray-600); }
.calc-total { display: flex; justify-content: space-between; align-items: center; font-size: 18px; font-weight: 800; color: var(--gray-900); margin-bottom: 16px; }
.btn-place-order { display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 14px; border-radius: 12px; border: none; background: var(--gradient-primary); color: #fff; font-weight: 700; font-size: 16px; cursor: pointer; transition: all .25s; box-shadow: 0 4px 14px rgba(245,114,36,.3); }
.btn-place-order:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(245,114,36,.35); }
.btn-place-order:disabled { opacity: .6; cursor: not-allowed; transform: none; }
.summary-security { display: flex; align-items: center; gap: 8px; justify-content: center; margin-top: 12px; font-size: 12px; color: var(--gray-500); }
.summary-security i { color: var(--success); font-size: 14px; }
.summary-payment-icons { display: flex; justify-content: center; gap: 10px; margin-top: 12px; font-size: 24px; color: #D1D5DB; }
.free-tag-sm { font-size: 12px; font-weight: 700; color: #059669; background: rgba(16,185,129,.1); padding: 2px 8px; border-radius: 4px; }
@media (max-width: 767.98px) { .address-cards { grid-template-columns: 1fr; } .checkout-steps { padding: 12px; } .section-body { padding: 14px; } .summary-items { max-height: 200px; } }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('checkoutForm');
    const placeBtn = document.getElementById('placeOrderBtn');
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content;

    document.querySelectorAll('.address-radio').forEach(radio => {
        radio.addEventListener('change', function() {
            if (!this.checked) return;
            document.querySelectorAll('.address-card').forEach(c => c.classList.remove('selected'));
            this.closest('.address-card').classList.add('selected');
            const d = this.dataset;
            const prefix = 'shipping_address';
            form.querySelector(`[name="${prefix}[name]"]`).value = d.name || '';
            form.querySelector(`[name="${prefix}[email]"]`).value = d.email || '';
            form.querySelector(`[name="${prefix}[phone]"]`).value = d.phone || '';
            form.querySelector(`[name="${prefix}[address_line1]"]`).value = d.line1 || '';
            form.querySelector(`[name="${prefix}[address_line2]"]`).value = d.line2 || '';
            form.querySelector(`[name="${prefix}[city]"]`).value = d.city || '';
            form.querySelector(`[name="${prefix}[state]"]`).value = d.state || '';
            form.querySelector(`[name="${prefix}[zip]"]`).value = d.zip || '';
            form.querySelector(`[name="${prefix}[country]"]`).value = d.country || 'US';
        });
    });

    const billingSame = document.getElementById('billingSame');
    const billingFields = document.getElementById('billingFields');
    billingSame?.addEventListener('change', function() {
        billingFields.style.display = this.checked ? 'none' : 'block';
    });

    document.querySelectorAll('.shipping-radio').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.shipping-method-card').forEach(c => c.classList.remove('selected'));
            this.closest('.shipping-method-card').classList.add('selected');
            updateCheckoutShipping(parseFloat(this.dataset.cost) || 0);
        });
    });

    document.querySelectorAll('.payment-radio').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.payment-method-card').forEach(c => c.classList.remove('selected'));
            this.closest('.payment-method-card').classList.add('selected');
        });
    });

    function updateCheckoutShipping(cost) {
        const shippingEl = document.getElementById('checkoutShipping');
        const totalEl = document.getElementById('checkoutTotal');
        const subtotal = parseFloat('{{ $cart->subtotal }}');
        const discount = parseFloat('{{ $cart->coupon_discount }}');
        const taxRate = parseFloat('{{ $cart->tax_rate }}');
        const afterCoupon = subtotal - discount;
        const tax = afterCoupon * (taxRate / 100);
        const total = afterCoupon + cost + tax;
        shippingEl.innerHTML = cost > 0 ? '$' + cost.toFixed(2) : '<span class="free-tag-sm">FREE</span>';
        totalEl.textContent = '$' + total.toFixed(2);
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        if (placeBtn.disabled) return;
        placeBtn.disabled = true;
        placeBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';

        const formData = new FormData(form);
        formData.append('billing_same', billingSame?.checked ? '1' : '0');

        fetch('{{ route("checkout.place") }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect;
            } else {
                showToast(data.message || 'An error occurred.', 'error');
                placeBtn.disabled = false;
                placeBtn.innerHTML = '<i class="fas fa-lock me-2"></i>Place Order';
            }
        })
        .catch(() => {
            showToast('An error occurred. Please try again.', 'error');
            placeBtn.disabled = false;
            placeBtn.innerHTML = '<i class="fas fa-lock me-2"></i>Place Order';
        });
    });
});
</script>
@endpush
</x-layouts.frontend-layout>
