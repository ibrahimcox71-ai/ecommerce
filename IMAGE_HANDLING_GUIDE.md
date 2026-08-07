# Image Handling System - Complete Guide

## Architecture Overview

This system provides:
- **Model Accessors**: Automatic fallback to placeholder images
- **Upload Service**: Clean file upload with validation
- **Trait**: Reusable image logic across models
- **Blade Views**: Safe image rendering with onerror fallback
- **Storage**: Organized directory structure with symlinks

---

## 1. MODEL ACCESSORS (Recommended)

### Using the Trait

Any model with images should use `HasImageAccessors`:

```php
use App\Traits\HasImageAccessors;

class Product extends Model
{
    use HasImageAccessors;
}
```

### Automatic Accessors (After using Trait)

```blade
{{-- Product thumbnail --}}
<img src="{{ $product->thumbnail_url }}" alt="Product">

{{-- Product image --}}
<img src="{{ $product->image_url }}" alt="Product">

{{-- With onerror fallback --}}
<img src="{{ $product->image_url }}" 
     alt="Product"
     onerror="this.src='{{ asset('images/no-image.png') }}'">
```

### Manual Method Call

```php
// Get safe URL
$url = $product->getSafeImageUrl('thumbnail', 'public');

// Check if image exists
if ($product->imageExists('image', 'public')) {
    echo $product->image_url;
}
```

---

## 2. CONTROLLER BEST PRACTICES

### Storing Images (Clean Relative Paths)

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Store a product with image upload.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,gif,webp|max:5120',
            'images.*' => 'nullable|image|mimes:jpeg,png,gif,webp|max:5120',
        ]);

        // Upload thumbnail (single image)
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = ImageUploadService::upload(
                $request->file('thumbnail'),
                'products',  // directory
                'public'     // disk
            );
        }

        // Create product with relative path (NOT full URL)
        $product = Product::create([
            'name' => $validated['name'],
            'thumbnail' => $thumbnailPath, // e.g., 'products/20240115120530_abc12345.jpg'
            'slug' => Str::slug($validated['name']),
        ]);

        // Upload multiple images
        if ($request->hasFile('images')) {
            $imagePaths = ImageUploadService::uploadMultiple(
                $request->file('images'),
                'products',
                'public'
            );

            foreach ($imagePaths as $index => $path) {
                $product->images()->create([
                    'image' => $path,
                    'alt_text' => $validated['name'],
                    'is_primary' => $index === 0,
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('products.show', $product)
                       ->with('success', 'Product created successfully!');
    }

    /**
     * Update a product with image replacement.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,gif,webp|max:5120',
        ]);

        // Replace thumbnail if new one uploaded
        if ($request->hasFile('thumbnail')) {
            $newPath = ImageUploadService::replace(
                $request->file('thumbnail'),
                $product->thumbnail,
                'products',
                'public'
            );
            $product->thumbnail = $newPath;
        }

        $product->update([
            'name' => $validated['name'],
            'thumbnail' => $product->thumbnail,
        ]);

        return redirect()->route('products.show', $product)
                       ->with('success', 'Product updated successfully!');
    }

    /**
     * Delete a product and cleanup images.
     */
    public function destroy(Product $product)
    {
        // Delete thumbnail
        ImageUploadService::delete($product->thumbnail, 'public');

        // Delete all product images
        $imagePaths = $product->images->pluck('image')->toArray();
        ImageUploadService::deleteMultiple($imagePaths, 'public');

        $product->delete();

        return redirect()->route('products.index')
                       ->with('success', 'Product deleted successfully!');
    }
}
```

---

## 3. BLADE VIEW IMPLEMENTATION

### Safe Image Rendering

```blade
{{-- Simple image with model accessor --}}
<img src="{{ $product->thumbnail_url }}" 
     alt="{{ $product->name }}"
     class="img-fluid">

{{-- With onerror fallback --}}
<img src="{{ $product->image_url }}" 
     alt="{{ $product->name }}"
     onerror="this.src='{{ asset('images/no-image.png') }}'"
     class="product-image">

{{-- Product gallery --}}
<div class="product-gallery">
    @forelse($product->images as $image)
        <img src="{{ $image->image_url }}" 
             alt="{{ $image->alt_text ?? $product->name }}"
             onerror="this.src='{{ asset('images/no-image.png') }}'"
             class="gallery-image">
    @empty
        <img src="{{ asset('images/no-image.png') }}" 
             alt="No images available"
             class="gallery-image">
    @endforelse
</div>

{{-- Using service helper directly --}}
<img src="{{ \App\Services\ImageUploadService::getUrl($product->thumbnail) }}"
     alt="{{ $product->name }}">

{{-- Brand image --}}
<img src="{{ $brand->image_url }}"
     alt="{{ $brand->name }}"
     onerror="this.src='{{ asset('images/no-image.png') }}'">

{{-- Category icon --}}
<img src="{{ $category->image_url }}"
     alt="{{ $category->name }}"
     onerror="this.src='{{ asset('images/no-image.png') }}'">
```

### Reusable Blade Component

Create `resources/views/components/product-image.blade.php`:

```blade
@props([
    'product',
    'alt' => $product->name,
    'class' => 'img-fluid',
    'placeholder' => 'images/no-image.png',
])

<img src="{{ $product->image_url }}" 
     alt="{{ $alt }}"
     class="{{ $class }}"
     onerror="this.src='{{ asset($placeholder) }}'"
     {{ $attributes }}>
```

Usage:

```blade
<x-product-image :product="$product" class="thumbnail" />

<x-product-image :product="$product" 
                 alt="Product thumbnail"
                 placeholder="images/error.png" />
```

---

## 4. TROUBLESHOOTING & TERMINAL COMMANDS

### Setup & Configuration

```bash
# Recreate storage symlink (if broken/missing)
php artisan storage:link

# Force delete old symlink and recreate
rm public/storage
php artisan storage:link

# On Windows (if symlink fails):
mklink /D "C:\laragon\www\ecommerce\public\storage" "C:\laragon\www\ecommerce\storage\app\public"
```

### Permissions (Linux/Mac)

```bash
# Fix storage directory permissions
chmod -R 755 storage/app/public
chmod -R 755 public/storage

# If issues persist, use 775
chmod -R 775 storage/app/public
chmod -R 775 public/storage

# Fix ownership (if running as different user)
sudo chown -R www-data:www-data storage/
sudo chown -R www-data:www-data public/storage
```

### Clear Caches

```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# All at once (clear)
php artisan optimize:clear

# Or use (refresh)
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Debugging

```bash
# Check if symlink exists
ls -la public/storage
# or on Windows
dir public\storage

# Check if files exist
ls -la storage/app/public/products/
# or
dir storage\app\public\products\

# Test storage disk
php artisan tinker
>>> Storage::disk('public')->allFiles('products')
>>> Storage::disk('public')->exists('products/test.jpg')
```

### Database Cleanup (Remove Old Paths)

```bash
# Database command (caution: backup first!)
php artisan tinker

# Find products with invalid image paths
>>> Product::whereNotNull('thumbnail')->get();

# Delete orphaned records
>>> Product::whereNull('thumbnail')->delete();

# Update paths if needed (careful!)
>>> Product::where('thumbnail', 'like', 'http%')->update(['thumbnail' => null]);
```

---

## 5. DATABASE MIGRATION

If creating new tables:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            
            // Store RELATIVE paths only (e.g., 'products/image.jpg')
            // NOT full URLs or absolute paths
            $table->string('thumbnail')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            
            // Relative path
            $table->string('image');
            
            $table->string('alt_text')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });
    }
};
```

---

## 6. VALIDATION RULES

```php
<?php

// In FormRequest or Controller
$validated = $request->validate([
    'thumbnail' => 'nullable|image|mimes:jpeg,png,gif,webp|max:5120',
    'images.*' => 'nullable|image|mimes:jpeg,png,gif,webp|max:5120',
    'brand_image' => 'nullable|image|mimes:jpeg,png,gif,webp|max:2048',
]);

// Custom validation in FormRequest
public function rules(): array
{
    return [
        'thumbnail' => [
            'nullable',
            'image',
            'mimes:jpeg,png,gif,webp',
            'max:5120', // 5MB
            'dimensions:min_width=300,min_height=300',
        ],
    ];
}
```

---

## 7. PLACEHOLDER IMAGE SETUP

1. Create placeholder at: `public/images/no-image.png` (or your path)
2. Update constant in `ImageUploadService.php` if needed:

```php
public const PLACEHOLDER_IMAGE = 'images/no-image.png';
```

3. Reference in Blade and models uses this automatically

---

## Summary

| Step | What | Where |
|------|------|-------|
| **Upload** | Use `ImageUploadService::upload()` | Controller |
| **Store** | Save RELATIVE path to DB | Controller |
| **Display** | Use `$model->image_url` accessor | Blade view |
| **Fallback** | Automatic in model + `onerror` in HTML | Model + Blade |
| **Delete** | Use `ImageUploadService::delete()` | Controller |

This ensures: ✅ No 404 errors ✅ Clean paths in DB ✅ Secure handling ✅ Automatic fallbacks
