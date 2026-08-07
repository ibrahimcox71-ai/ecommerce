<?php if (isset($component)) { $__componentOriginaleac9542bb5e3f887e862d1d96c472e9b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaleac9542bb5e3f887e862d1d96c472e9b = $attributes; } ?>
<?php $component = App\View\Components\Layouts\FrontendLayout::resolve(['title' => 'Home - '.e(config('app.name')).'','seoData' => $seoData ?? []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.frontend-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\FrontendLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>




<section class="hero-section">
    <div class="container">
        <div class="hero-carousel swiper hero-swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="hero-slide" style="background: linear-gradient(135deg, #212121 0%, #3A3A3A 55%, #F57224 130%);">
                        <div class="hero-bg">
                            <img src="https://picsum.photos/seed/hero1/1920/600" alt="" loading="eager" fetchpriority="high" style="opacity: 0.06;">
                        </div>
                        <div class="hero-bg-pattern"><i class="fas fa-shopping-bag"></i></div>
                        <div class="hero-floating-elements">
                            <div class="float-el"></div>
                            <div class="float-el"></div>
                            <div class="float-el"></div>
                            <div class="float-el"></div>
                        </div>
                        <div class="hero-overlay"></div>
                        <div class="container">
                            <div class="hero-content">
                                <span class="hero-badge">
                                    <i class="fas fa-bolt"></i> New Collection
                                </span>
                                <h1 class="hero-title-xlarge">Summer Sale<br><span class="text-gradient-gold">Up to 50% Off</span></h1>
                                <p class="hero-subtitle">Discover premium products at unbeatable prices. Limited time offer — shop the best deals today with free shipping.</p>
                                <div class="hero-actions">
                                    <a href="<?php echo e(route('shop')); ?>" class="hero-btn btn-primary-custom">
                                        Shop Now <i class="fas fa-arrow-right"></i>
                                    </a>
                                    <a href="<?php echo e(route('flash-sale')); ?>" class="hero-btn btn-outline-custom">
                                        <i class="fas fa-bolt"></i> Flash Sale
                                    </a>
                                </div>
                                <div class="hero-trust-badges">
                                    <span><i class="fas fa-check-circle"></i> Free Shipping</span>
                                    <span><i class="fas fa-check-circle"></i> Secure Payment</span>
                                    <span><i class="fas fa-check-circle"></i> Easy Returns</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="hero-slide" style="background: linear-gradient(135deg, #171717 0%, #2B2B2B 50%, #D0520A 120%);">
                        <div class="hero-bg">
                            <img src="https://picsum.photos/seed/hero2/1920/600" alt="" loading="eager" style="opacity: 0.06;">
                        </div>
                        <div class="hero-bg-pattern"><i class="fas fa-star"></i></div>
                        <div class="hero-floating-elements">
                            <div class="float-el"></div>
                            <div class="float-el"></div>
                            <div class="float-el"></div>
                            <div class="float-el"></div>
                        </div>
                        <div class="hero-overlay"></div>
                        <div class="container">
                            <div class="hero-content">
                                <span class="hero-badge">
                                    <i class="fas fa-star"></i> Best Sellers
                                </span>
                                <h1 class="hero-title-xlarge">Premium Picks<br><span class="text-gradient-gold">Handpicked for You</span></h1>
                                <p class="hero-subtitle">Our most-loved products, curated from thousands of verified reviews. Quality you can trust, delivered to your door.</p>
                                <div class="hero-actions">
                                    <a href="<?php echo e(route('shop', ['sort' => 'best-seller'])); ?>" class="hero-btn btn-primary-custom">
                                        Explore Best Sellers <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                                <div class="hero-trust-badges">
                                    <span><i class="fas fa-check-circle"></i> 10K+ Reviews</span>
                                    <span><i class="fas fa-check-circle"></i> 4.8 Avg Rating</span>
                                    <span><i class="fas fa-check-circle"></i> 30-Day Return</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="hero-slide" style="background: linear-gradient(135deg, #212121 0%, #424242 55%, #F59E0B 140%);">
                        <div class="hero-bg">
                            <img src="https://picsum.photos/seed/hero3/1920/600" alt="" loading="eager" style="opacity: 0.06;">
                        </div>
                        <div class="hero-bg-pattern"><i class="fas fa-truck"></i></div>
                        <div class="hero-floating-elements">
                            <div class="float-el"></div>
                            <div class="float-el"></div>
                            <div class="float-el"></div>
                            <div class="float-el"></div>
                        </div>
                        <div class="hero-overlay"></div>
                        <div class="container">
                            <div class="hero-content">
                                <span class="hero-badge">
                                    <i class="fas fa-truck"></i> Free Shipping
                                </span>
                                <h1 class="hero-title-xlarge">New Arrivals<br><span class="text-gradient-gold">Fresh & Trending</span></h1>
                                <p class="hero-subtitle">Be the first to discover our latest products. Free shipping on orders over $50 with easy 30-day returns.</p>
                                <div class="hero-actions">
                                    <a href="<?php echo e(route('shop', ['sort' => 'newest'])); ?>" class="hero-btn btn-primary-custom">
                                        Discover Now <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                                <div class="hero-trust-badges">
                                    <span><i class="fas fa-check-circle"></i> Free Shipping $50+</span>
                                    <span><i class="fas fa-check-circle"></i> Secure Checkout</span>
                                    <span><i class="fas fa-check-circle"></i> 24/7 Support</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero-pagination swiper-pagination"></div>
            <div class="hero-button-prev hero-nav-btn"><i class="fas fa-chevron-left"></i></div>
            <div class="hero-button-next hero-nav-btn"><i class="fas fa-chevron-right"></i></div>
        </div>

        
    </div>
</section>

<div class="container">

    
    <div class="live-bar mb-4" data-aos="fade-up">
        <div class="live-visitor-counter">
            <span class="live-dot"></span>
            <span><strong id="liveVisitorCount">186</strong> people are viewing this site right now</span>
        </div>
        <div class="d-flex align-items-center gap-3 flex-wrap ms-auto">
            <span class="fs-8 text-gray-500"><i class="fas fa-shield-alt text-success me-1"></i> Secure Checkout</span>
            <span class="fs-8 text-gray-500"><i class="fas fa-undo text-success me-1"></i> 30-Day Returns</span>
            <span class="fs-8 text-gray-500"><i class="fas fa-truck text-success me-1"></i> Free Shipping $50+</span>
        </div>
    </div>

    
    <?php if($flashSaleProducts->isNotEmpty()): ?>
    <section class="section-margin" data-aos="fade-up">
        <div class="flash-sale-v2">
            <div class="flash-bg-pattern"><i class="fas fa-bolt"></i></div>
            <div class="flash-content">
                <div class="flash-header">
                    <div class="flash-title-section">
                        <div class="flash-icon"><i class="fas fa-bolt"></i></div>
                        <div>
                            <h3 class="flash-title">Flash Sale <span class="flash-live-badge"><i class="fas fa-circle"></i> Live</span></h3>
                            <p class="flash-subtitle">Limited time offers — grab them before they're gone!</p>
                        </div>
                    </div>
                    <div class="flash-timer-v2" id="flashCountdown">
                        <div class="timer-block">
                            <span class="timer-num fd-days">00</span>
                            <span class="timer-label">Days</span>
                        </div>
                        <span class="timer-sep">:</span>
                        <div class="timer-block">
                            <span class="timer-num fd-hours">00</span>
                            <span class="timer-label">Hours</span>
                        </div>
                        <span class="timer-sep">:</span>
                        <div class="timer-block">
                            <span class="timer-num fd-mins">00</span>
                            <span class="timer-label">Mins</span>
                        </div>
                        <span class="timer-sep">:</span>
                        <div class="timer-block">
                            <span class="timer-num fd-secs">00</span>
                            <span class="timer-label">Secs</span>
                        </div>
                    </div>
                </div>

                <div class="flash-progress-wrap">
                    <div class="flash-progress">
                        <div class="flash-progress-bar" style="width: 72%;"></div>
                    </div>
                    <span class="flash-sold-text"><strong>1,284</strong> sold already</span>
                </div>

                <div class="row g-3 row-cols-2 row-cols-md-4">
                    <?php $__currentLoopData = $flashSaleProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col">
                            <?php if (isset($component)) { $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.product-card','data' => ['product' => $product]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('product-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a)): ?>
<?php $attributes = $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a; ?>
<?php unset($__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a)): ?>
<?php $component = $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a; ?>
<?php unset($__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a); ?>
<?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="flash-cta">
                    <a href="<?php echo e(route('flash-sale')); ?>">
                        View All Deals <i class="fas fa-bolt ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    
    <?php if($featuredCategories->isNotEmpty()): ?>
    <section class="section-margin" data-aos="fade-up">
        <div class="section-header">
            <div class="section-header-left">
                <span class="section-bar"></span>
                <div class="section-header-group">
                    <h3>Featured Categories</h3>
                    <span class="section-subtitle">Shop by category</span>
                </div>
            </div>
            <a href="<?php echo e(route('shop')); ?>" class="section-link">
                View All <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="round-categories">
            <?php $__currentLoopData = $featuredCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $colors = ['#F57224', '#D0520A', '#212121', '#F59E0B', '#10B981', '#EF4444', '#3B82F6', '#424242'];
                    $color = $colors[$loop->index % count($colors)];
                ?>
                <a href="<?php echo e(route('category.show', $cat->slug)); ?>" class="round-cat-item">
                    <div class="round-cat-icon" style="background: linear-gradient(135deg, <?php echo e($color); ?>, <?php echo e($color); ?>dd);">
                        <?php if($cat->icon): ?> <i class="<?php echo e($cat->icon); ?>"></i> <?php else: ?> <i class="fas fa-tag"></i> <?php endif; ?>
                    </div>
                    <span class="round-cat-name"><?php echo e($cat->name); ?></span>
                    <?php if($cat->products_count > 0): ?>
                    <span class="round-cat-count"><?php echo e($cat->products_count); ?> items</span>
                    <?php endif; ?>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>
    <?php endif; ?>

    
    <?php if($brands->isNotEmpty()): ?>
    <section class="section-margin" data-aos="fade-up">
        <div class="section-header">
            <div class="section-header-left">
                <span class="section-bar"></span>
                <div class="section-header-group">
                    <h3>Popular Brands</h3>
                    <span class="section-subtitle">Top brands you love</span>
                </div>
            </div>
        </div>
        <div class="brand-slider-v2">
            <div class="brand-track" id="brandTrack">
                <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="brand-item">
                        <a href="<?php echo e(route('brand.show', $brand->slug)); ?>" class="brand-card-v2">
                            <?php if($brand->image): ?>
                                <img src="<?php echo e(asset('storage/' . $brand->image)); ?>"
                                     alt="<?php echo e($brand->name); ?>"
                                     loading="lazy"
                                     onerror="this.onerror=null;this.parentElement.innerHTML='<span style=\'font-weight:700;color:var(--gray-400)\'><?php echo e($brand->name); ?></span>'">
                            <?php else: ?>
                                <span class="fw-bold text-gray-400 fs-7"><?php echo e($brand->name); ?></span>
                            <?php endif; ?>
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    
    <?php if($trendingProducts->isNotEmpty()): ?>
    <section class="section-margin" data-aos="fade-up">
        <div class="section-header">
            <div class="section-header-left">
                <div class="section-icon icon-trending"><i class="fas fa-fire"></i></div>
                <div class="section-header-group">
                    <h3>Trending Products</h3>
                    <span class="section-subtitle">Most popular right now</span>
                </div>
            </div>
            <a href="<?php echo e(route('shop')); ?>" class="section-link">
                View All <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="product-grid-v2">
            <?php $__currentLoopData = $trendingProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if (isset($component)) { $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.product-card','data' => ['product' => $product]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('product-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a)): ?>
<?php $attributes = $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a; ?>
<?php unset($__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a)): ?>
<?php $component = $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a; ?>
<?php unset($__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a); ?>
<?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>
    <?php endif; ?>

    
    <?php if($todaysDeals->isNotEmpty()): ?>
    <section class="section-margin" data-aos="fade-up">
        <div class="section-header">
            <div class="section-header-left">
                <div class="todays-deals-header">
                    <div class="td-icon"><i class="fas fa-clock"></i></div>
                    <div class="section-header-group">
                        <h3>Today's Deals</h3>
                        <span class="section-subtitle">Limited time offers with big savings</span>
                    </div>
                    <div class="td-timer">
                        <i class="fas fa-hourglass-half"></i>
                        Ends in <span class="td-time-block" id="tdHours">23</span>:
                        <span class="td-time-block" id="tdMins">59</span>:
                        <span class="td-time-block" id="tdSecs">59</span>
                    </div>
                </div>
            </div>
            <a href="<?php echo e(route('flash-sale')); ?>" class="section-link">
                View All <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="product-grid-v2">
            <?php $__currentLoopData = $todaysDeals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if (isset($component)) { $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.product-card','data' => ['product' => $product]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('product-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a)): ?>
<?php $attributes = $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a; ?>
<?php unset($__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a)): ?>
<?php $component = $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a; ?>
<?php unset($__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a); ?>
<?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>
    <?php endif; ?>

    
    <?php if($latestProducts->isNotEmpty()): ?>
    <section class="section-margin" data-aos="fade-up">
        <div class="section-header">
            <div class="section-header-left">
                <div class="section-icon icon-new"><i class="fas fa-sparkles"></i></div>
                <div class="section-header-group">
                    <h3>New Arrivals</h3>
                    <span class="section-subtitle">Fresh from the collection</span>
                </div>
            </div>
            <a href="<?php echo e(route('shop', ['sort' => 'newest'])); ?>" class="section-link">
                View All <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="product-grid-v2">
            <?php $__currentLoopData = $latestProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if (isset($component)) { $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.product-card','data' => ['product' => $product]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('product-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a)): ?>
<?php $attributes = $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a; ?>
<?php unset($__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a)): ?>
<?php $component = $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a; ?>
<?php unset($__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a); ?>
<?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>
    <?php endif; ?>

    
    <?php if($bestSellers->isNotEmpty()): ?>
    <section class="section-margin" data-aos="fade-up">
        <div class="section-header">
            <div class="section-header-left">
                <div class="section-icon icon-best-seller"><i class="fas fa-crown"></i></div>
                <div class="section-header-group">
                    <h3>Best Sellers</h3>
                    <span class="section-subtitle">Top-rated products our customers love</span>
                </div>
            </div>
            <a href="<?php echo e(route('shop', ['sort' => 'best-seller'])); ?>" class="section-link">
                View All <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="product-grid-v2">
            <?php $__currentLoopData = $bestSellers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if (isset($component)) { $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.product-card','data' => ['product' => $product]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('product-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a)): ?>
<?php $attributes = $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a; ?>
<?php unset($__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a)): ?>
<?php $component = $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a; ?>
<?php unset($__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a); ?>
<?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>
    <?php endif; ?>

    
    <?php if($featuredProducts->isNotEmpty()): ?>
    <section class="section-margin" data-aos="fade-up">
        <div class="section-header">
            <div class="section-header-left">
                <div class="section-icon icon-recommended"><i class="fas fa-thumbs-up"></i></div>
                <div class="section-header-group">
                    <h3>Recommended For You</h3>
                    <span class="section-subtitle">Based on your preferences</span>
                </div>
            </div>
        </div>
        <div class="product-grid-v2">
            <?php $__currentLoopData = $featuredProducts->shuffle()->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if (isset($component)) { $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.product-card','data' => ['product' => $product]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('product-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a)): ?>
<?php $attributes = $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a; ?>
<?php unset($__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a)): ?>
<?php $component = $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a; ?>
<?php unset($__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a); ?>
<?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>
    <?php endif; ?>

    
    <?php if($collections->isNotEmpty()): ?>
    <section class="section-margin" data-aos="fade-up">
        <div class="section-header">
            <div class="section-header-left">
                <span class="section-bar"></span>
                <div class="section-header-group">
                    <h3>Top Collections</h3>
                    <span class="section-subtitle">Curated just for you</span>
                </div>
            </div>
        </div>
        <div class="collection-grid">
            <?php $__currentLoopData = $collections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $collection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $bgColors = [
                        'linear-gradient(135deg, #212121, #F57224)',
                        'linear-gradient(135deg, #171717, #D0520A)',
                        'linear-gradient(135deg, #212121, #10B981)',
                        'linear-gradient(135deg, #171717, #F59E0B)',
                    ];
                    $bgColor = $bgColors[$index % count($bgColors)];
                    $images = ['https://picsum.photos/seed/col' . ($index + 1) . '/600/400', 'https://picsum.photos/seed/col' . ($index + 1) . 'b/400/400'];
                ?>
                <a href="<?php echo e(route('category.show', $collection->slug)); ?>" class="collection-card">
                    <div class="collection-bg">
                        <img src="<?php echo e($images[0]); ?>" alt="" loading="lazy" style="opacity: 0.15;">
                    </div>
                    <div class="collection-overlay" style="background: linear-gradient(180deg, transparent 20%, <?php echo e($bgColors[$index % 4]); ?>ee 100%);"></div>
                    <div class="collection-body">
                        <span class="collection-label">Collection</span>
                        <h4 class="collection-title"><?php echo e($collection->name); ?></h4>
                        <span class="collection-count"><?php echo e($collection->products_count); ?> Products</span>
                        <div class="collection-arrow"><i class="fas fa-arrow-right"></i></div>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>
    <?php endif; ?>

    
    <section class="section-margin" data-aos="fade-up">
        <div class="section-header">
            <div class="section-header-left">
                <div class="section-icon icon-trending"><i class="fas fa-clock-rotate"></i></div>
                <div class="section-header-group">
                    <h3>Recently Viewed</h3>
                    <span class="section-subtitle">Pick up where you left off</span>
                </div>
            </div>
            <a href="<?php echo e(route('shop')); ?>" class="section-link">
                View All <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <?php if($recentlyViewed->isNotEmpty()): ?>
        <div class="recently-viewed-scroll">
            <?php $__currentLoopData = $recentlyViewed; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="recent-item">
                <?php if (isset($component)) { $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.product-card','data' => ['product' => $product]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('product-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a)): ?>
<?php $attributes = $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a; ?>
<?php unset($__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a)): ?>
<?php $component = $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a; ?>
<?php unset($__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a); ?>
<?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php else: ?>
        <div class="text-center py-5 text-gray-400">
            <i class="fas fa-clock" style="font-size: 2.5rem; margin-bottom: 12px; display: block;"></i>
            <p class="mb-0">No recently viewed items yet. Start browsing!</p>
        </div>
        <?php endif; ?>
    </section>

    
    <section class="section-margin" data-aos="fade-up">
        <div class="newsletter-section">
            <div class="newsletter-bg-pattern"><i class="fas fa-envelope-open-text"></i></div>
            <div class="newsletter-content">
                <h3>Get 10% OFF Your First Purchase</h3>
                <p>Subscribe to our newsletter and receive exclusive deals, new arrivals, and insider-only offers straight to your inbox.</p>
                <form class="newsletter-form" action="#" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="email" name="email" placeholder="Enter your email address" required>
                    <button type="submit">Subscribe <i class="fas fa-paper-plane ms-1"></i></button>
                </form>
                <div class="newsletter-trust">
                    <span><i class="fas fa-check me-1"></i> No spam, ever</span>
                    <span><i class="fas fa-check me-1"></i> Unsubscribe anytime</span>
                    <span><i class="fas fa-check me-1"></i> 10K+ subscribers</span>
                </div>
            </div>
        </div>
    </section>

    
    <section class="section-margin" data-aos="fade-up">
        <div class="section-header">
            <div class="section-header-left">
                <div class="section-icon icon-top-rated"><i class="fas fa-star"></i></div>
                <div class="section-header-group">
                    <h3>What Our Customers Say</h3>
                </div>
            </div>
        </div>
        <?php
            $testimonials = [
                ['name' => 'Sarah M.', 'initials' => 'SM', 'rating' => 5, 'text' => 'Absolutely love my purchase! The quality exceeded my expectations and shipping was incredibly fast. Will definitely be buying again.', 'date' => '2 days ago'],
                ['name' => 'James K.', 'initials' => 'JK', 'rating' => 5, 'text' => 'Best online shopping experience I have had. The customer service team was super helpful and the product is exactly as described.', 'date' => '1 week ago'],
                ['name' => 'Emily R.', 'initials' => 'ER', 'rating' => 4, 'text' => 'Great quality and amazing value for money. The only reason I am giving 4 stars is because delivery took a bit longer than expected.', 'date' => '3 weeks ago'],
                ['name' => 'Michael D.', 'initials' => 'MD', 'rating' => 5, 'text' => 'I was hesitant to order online but this store exceeded all my expectations. Premium products and excellent customer support. Highly recommended!', 'date' => '1 month ago'],
            ];
        ?>
        <div class="row g-4">
            <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-6 col-lg-3">
                    <div class="testimonial-card">
                        <div class="testimonial-header">
                            <div class="testimonial-avatar-placeholder"><?php echo e($testimonial['initials']); ?></div>
                            <div>
                                <div class="testimonial-name"><?php echo e($testimonial['name']); ?></div>
                                <div class="testimonial-date"><?php echo e($testimonial['date']); ?></div>
                            </div>
                        </div>
                        <div class="testimonial-verified">
                            <i class="fas fa-check-circle"></i> Verified Purchase
                        </div>
                        <div class="testimonial-rating">
                            <?php for($i = 1; $i <= 5; $i++): ?>
                                <i class="fas fa-star <?php echo e($i <= $testimonial['rating'] ? 'text-warning' : 'text-gray-300'); ?> fs-8"></i>
                            <?php endfor; ?>
                        </div>
                        <p class="testimonial-text">"<?php echo e($testimonial['text']); ?>"</p>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>

    
    <section class="section-margin" data-aos="fade-up">
        <div class="section-header">
            <div class="section-header-left">
                <span class="section-bar"></span>
                <div class="section-header-group">
                    <h3>Why Shop With Us</h3>
                    <span class="section-subtitle">The best shopping experience guaranteed</span>
                </div>
            </div>
        </div>
        <div class="row g-3">
            <div class="col-6 col-md-4 col-lg">
                <div class="feature-icon-card">
                    <div class="ficon bg-primary-light text-primary-custom">
                        <i class="fas fa-truck"></i>
                    </div>
                    <h6>Free Shipping</h6>
                    <p>On orders over $50</p>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg">
                <div class="feature-icon-card">
                    <div class="ficon bg-success-light text-success-custom">
                        <i class="fas fa-lock"></i>
                    </div>
                    <h6>Secure Payment</h6>
                    <p>100% protected checkout</p>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg">
                <div class="feature-icon-card">
                    <div class="ficon bg-warning-light text-warning">
                        <i class="fas fa-undo"></i>
                    </div>
                    <h6>Easy Returns</h6>
                    <p>30-day return policy</p>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg">
                <div class="feature-icon-card">
                    <div class="ficon bg-primary-light text-primary-custom">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h6>24/7 Support</h6>
                    <p>Dedicated support team</p>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg">
                <div class="feature-icon-card">
                    <div class="ficon bg-success-light text-success-custom">
                        <i class="fas fa-award"></i>
                    </div>
                    <h6>Genuine Products</h6>
                    <p>100% authentic guarantee</p>
                </div>
            </div>
        </div>
    </section>

</div>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaleac9542bb5e3f887e862d1d96c472e9b)): ?>
<?php $attributes = $__attributesOriginaleac9542bb5e3f887e862d1d96c472e9b; ?>
<?php unset($__attributesOriginaleac9542bb5e3f887e862d1d96c472e9b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaleac9542bb5e3f887e862d1d96c472e9b)): ?>
<?php $component = $__componentOriginaleac9542bb5e3f887e862d1d96c472e9b; ?>
<?php unset($__componentOriginaleac9542bb5e3f887e862d1d96c472e9b); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\ecommerce\resources\views\frontend\home.blade.php ENDPATH**/ ?>