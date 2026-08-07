@props(['cart' => null])

<div class="dropdown-menu dropdown-menu-end mini-cart-dropdown-v2" id="miniCartDropdown">
    <x-mini-cart-content :cart="$cart" />
</div>
