<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['categories', 'brands', 'maxPrice' => 1000]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['categories', 'brands', 'maxPrice' => 1000]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="filter-panel">
    <form action="<?php echo e(route('shop')); ?>" method="GET" id="shopFilterForm">
        <?php if(request('q')): ?>
            <input type="hidden" name="q" value="<?php echo e(request('q')); ?>">
        <?php endif; ?>

        
        <div class="filter-block">
            <div class="filter-header">
                <h6>Search</h6>
            </div>
            <div class="filter-body">
                <div class="search-input-group">
                    <i class="fas fa-search"></i>
                    <input type="text" name="q" class="filter-search-input" placeholder="Search products..." value="<?php echo e(request('q')); ?>">
                </div>
            </div>
        </div>

        
        <div class="filter-block">
            <div class="filter-header">
                <h6>Price Range</h6>
            </div>
            <div class="filter-body">
                <div class="price-range-display">
                    <span>$<span id="minPriceDisplay"><?php echo e(request('min_price', 0)); ?></span></span>
                    <span>—</span>
                    <span>$<span id="maxPriceDisplay"><?php echo e(request('max_price', $maxPrice)); ?></span></span>
                </div>
                <div class="price-slider-wrapper">
                    <div class="price-slider" id="priceSlider"></div>
                </div>
                <input type="hidden" name="min_price" id="minPriceInput" value="<?php echo e(request('min_price')); ?>">
                <input type="hidden" name="max_price" id="maxPriceInput" value="<?php echo e(request('max_price')); ?>">
            </div>
        </div>

        
        <?php if($categories->isNotEmpty()): ?>
            <div class="filter-block">
                <div class="filter-header">
                    <h6>Categories</h6>
                </div>
                <div class="filter-body filter-scroll">
                    <div class="filter-radio-group">
                        <label class="filter-radio">
                            <input type="radio" name="category" value="" <?php echo e(!request('category') ? 'checked' : ''); ?>

                                   onchange="this.form.submit()">
                            <span class="radio-label">All Categories</span>
                            <span class="radio-count"><?php echo e($categories->sum('products_count')); ?></span>
                        </label>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="filter-radio">
                                <input type="radio" name="category" value="<?php echo e($cat->slug); ?>" <?php echo e(request('category') === $cat->slug ? 'checked' : ''); ?>

                                       onchange="this.form.submit()">
                                <span class="radio-label"><?php echo e($cat->name); ?></span>
                                <span class="radio-count"><?php echo e($cat->products_count); ?></span>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        
        <?php if($brands->isNotEmpty()): ?>
            <div class="filter-block">
                <div class="filter-header">
                    <h6>Brands</h6>
                </div>
                <div class="filter-body filter-scroll">
                    <div class="filter-checkbox-group">
                        <label class="filter-checkbox">
                            <input type="radio" name="brand" value="" <?php echo e(!request('brand') ? 'checked' : ''); ?>

                                   onchange="this.form.submit()">
                            <span class="check-label">All Brands</span>
                        </label>
                        <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="filter-checkbox">
                                <input type="radio" name="brand" value="<?php echo e($brand->slug); ?>" <?php echo e(request('brand') === $brand->slug ? 'checked' : ''); ?>

                                       onchange="this.form.submit()">
                                <span class="check-label"><?php echo e($brand->name); ?></span>
                                <span class="check-count"><?php echo e($brand->products_count); ?></span>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        
        <div class="filter-block">
            <div class="filter-header">
                <h6>Rating</h6>
            </div>
            <div class="filter-body">
                <div class="filter-radio-group">
                    <?php $__currentLoopData = [5 => 'Excellent', 4 => 'Good', 3 => 'Average', 2 => 'Below Avg', 1 => 'Poor']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rating => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="filter-radio">
                            <input type="radio" name="rating" value="<?php echo e($rating); ?>" <?php echo e(request('rating') == $rating ? 'checked' : ''); ?>

                                   onchange="this.form.submit()">
                            <span class="radio-label">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <i class="fas fa-star <?php echo e($i <= $rating ? 'text-warning' : 'text-gray-300'); ?>"></i>
                                <?php endfor; ?>
                                & up
                            </span>
                        </label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>

        
        <div class="filter-block">
            <div class="filter-header">
                <h6>Availability</h6>
            </div>
            <div class="filter-body">
                <label class="filter-checkbox">
                    <input type="checkbox" name="in_stock" value="1" <?php echo e(request('in_stock') ? 'checked' : ''); ?>

                           onchange="this.form.submit()">
                    <span class="check-label"><i class="fas fa-check-circle text-success"></i> In Stock Only</span>
                </label>
            </div>
        </div>

        
        <div class="filter-block">
            <div class="filter-header">
                <h6>Offers</h6>
            </div>
            <div class="filter-body">
                <label class="filter-checkbox">
                    <input type="checkbox" name="on_sale" value="1" <?php echo e(request('on_sale') ? 'checked' : ''); ?>

                           onchange="this.form.submit()">
                    <span class="check-label"><i class="fas fa-tag text-danger"></i> On Sale</span>
                </label>
            </div>
        </div>

        <button type="submit" class="filter-apply-btn">Apply Filters</button>
        <a href="<?php echo e(route('shop')); ?>" class="filter-clear-btn">Clear All</a>
    </form>
</div>

<?php $__env->startPush('styles'); ?>
<style>
.filter-panel { background: #fff; border-radius: 14px; border: 1px solid #E5E7EB; padding: 20px; }
.filter-block { margin-bottom: 20px; padding-bottom: 16px; border-bottom: 1px solid #F3F4F6; }
.filter-block:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
.filter-header { margin-bottom: 10px; }
.filter-header h6 { font-size: 13px; font-weight: 700; color: var(--gray-800); text-transform: uppercase; letter-spacing: .3px; }
.filter-body.filter-scroll { max-height: 200px; overflow-y: auto; }
.filter-body.filter-scroll::-webkit-scrollbar { width: 3px; }
.filter-body.filter-scroll::-webkit-scrollbar-thumb { background: #D1D5DB; border-radius: 2px; }
.search-input-group { display: flex; align-items: center; background: #F9FAFB; border: 1px solid #E5E7EB; border-radius: 10px; padding: 0 12px; }
.search-input-group i { color: #9CA3AF; font-size: 14px; }
.search-input-group .filter-search-input { flex: 1; border: none; background: transparent; padding: 10px 8px; font-size: 13px; outline: none; }
.price-range-display { display: flex; justify-content: center; gap: 8px; font-size: 14px; font-weight: 600; color: var(--gray-800); margin-bottom: 12px; }
.price-slider-wrapper { padding: 0 4px; margin-bottom: 8px; }
.filter-radio-group, .filter-checkbox-group { display: flex; flex-direction: column; gap: 6px; }
.filter-radio, .filter-checkbox { display: flex; align-items: center; gap: 8px; padding: 6px 8px; border-radius: 8px; cursor: pointer; transition: background .15s; }
.filter-radio:hover, .filter-checkbox:hover { background: #F9FAFB; }
.filter-radio input, .filter-checkbox input { accent-color: var(--primary); }
.radio-label, .check-label { flex: 1; font-size: 13px; color: var(--gray-700); display: flex; align-items: center; gap: 4px; }
.radio-count, .check-count { font-size: 11px; color: var(--gray-400); background: #F3F4F6; padding: 2px 8px; border-radius: 4px; font-weight: 500; }
.filter-apply-btn { width: 100%; padding: 10px; border-radius: 10px; border: none; background: var(--gradient-primary); color: #fff; font-weight: 600; font-size: 13px; cursor: pointer; margin-top: 12px; transition: all .2s; }
.filter-apply-btn:hover { opacity: .9; }
.filter-clear-btn { display: block; text-align: center; padding: 10px; border-radius: 10px; border: 1px solid #E5E7EB; color: var(--gray-500); font-size: 13px; margin-top: 8px; text-decoration: none; transition: all .2s; }
.filter-clear-btn:hover { border-color: var(--primary); color: var(--primary); }
</style>
<?php $__env->stopPush(); ?><?php /**PATH C:\laragon\www\ecommerce\resources\views\components\shop-filters.blade.php ENDPATH**/ ?>