# Image Handling System - Setup & Troubleshooting Checklist

## ✅ QUICK SETUP (5 minutes)

```bash
# 1. Ensure storage symlink exists
php artisan storage:link

# 2. Create directories
mkdir -p storage/app/public/products
mkdir -p storage/app/public/brands
mkdir -p storage/app/public/categories
mkdir -p public/images

# 3. Fix permissions (Linux/Mac)
chmod -R 755 storage/app/public
chmod -R 755 public/storage

# 4. Clear caches
php artisan optimize:clear

# 5. Verify setup
php artisan tinker
>>> Storage::disk('public')->allFiles()
>>> exit
```

---

## 🔧 FIXING BROKEN IMAGES

### Symptom: "No Image" 404 Placeholder Not Showing

**Solution:**

```bash
# 1. Verify placeholder exists
ls -la public/images/
# or Windows:
dir public\images\

# 2. Verify storage symlink
ls -la public/storage/
# or Windows:
dir public

# 3. If symlink broken, recreate it
php artisan storage:link --force

# 4. Clear view cache
php artisan view:clear

# 5. Check browser cache
# - Hard refresh: Ctrl+Shift+R (Windows/Linux) or Cmd+Shift+R (Mac)
```

### Symptom: Images Show But Are 404

**Root causes:**
1. Symlink missing/broken
2. File physically doesn't exist in storage/app/public/
3. File path in database is incorrect (has full URL or absolute path)

**Debug steps:**

```bash
# Check what's in database
php artisan tinker
>>> Product::pluck('thumbnail') # See all paths
>>> Product::first()->thumbnail # Check one
>>> exit

# Expected format: "products/20240115120530_abc12345.jpg"
# NOT: "/storage/products/..." or "http://..." or "C:/path/to/..."

# Check if file actually exists
>>> Storage::disk('public')->exists('products/20240115120530_abc12345.jpg')
# Should return true

# List all files in products directory
>>> Storage::disk('public')->allFiles('products')
```

### Symptom: Model Accessor Returns NULL or Wrong URL

**Solution:**

```php
// In controller or tinker
$product = Product::first();

// Check database value
dd($product->getAttribute('thumbnail')); // Raw DB value

// Check accessor
dd($product->thumbnail_url); // Should use accessor

// Manually test accessor
dd($product->getSafeImageUrl('thumbnail', 'public'));

// Check if file exists
dd(Storage::disk('public')->exists($product->thumbnail));
```

---

## 🚀 DEPLOYMENT CHECKLIST

### Before Going to Production

```bash
# 1. Build CSS/JS
npm run build

# 2. Migrate database
php artisan migrate --force

# 3. Create storage directories
mkdir -p storage/app/public/products
mkdir -p storage/app/public/brands

# 4. Create symlink
php artisan storage:link

# 5. Fix permissions
sudo chown -R www-data:www-data storage/
sudo chown -R www-data:www-data public/storage
chmod -R 755 storage/app/public

# 6. Clear all caches
php artisan optimize:clear
php artisan config:cache
php artisan route:cache

# 7. Set production environment
echo "APP_ENV=production" >> .env
echo "APP_DEBUG=false" >> .env
```

### Verify on Production

```bash
# SSH into server
ssh user@your-server.com

# Navigate to project
cd /var/www/ecommerce

# Test storage
php artisan tinker
>>> Storage::disk('public')->allFiles()
>>> Storage::disk('public')->exists('products/test.jpg')
>>> exit

# Check permissions
ls -la storage/app/public/
ls -la public/storage/

# Monitor logs
tail -f storage/logs/laravel.log
```

---

## 💾 DATABASE COMMANDS

### Fix Invalid Paths in Database

```bash
php artisan tinker
```

```php
// Find products with bad paths
Product::where('thumbnail', 'like', 'http%')->get()
Product::where('thumbnail', 'like', '%storage/%')->get()
Product::where('thumbnail', 'like', '%/%/%')->get()

// Fix them (example)
Product::where('thumbnail', 'like', '%/storage/%')
    ->update(['thumbnail' => DB::raw("REPLACE(thumbnail, '/storage/', '')")])

// Clean up nulls
Product::where('thumbnail', '')->update(['thumbnail' => null])

// Verify
Product::whereNotNull('thumbnail')->pluck('thumbnail')->take(5)
```

---

## 📋 PERMISSIONS MATRIX

| Path | User | Group | Perms | Reason |
|------|------|-------|-------|--------|
| `storage/app/public/` | www-data | www-data | 755 | Web server needs write |
| `public/storage/` | www-data | www-data | 755 | Symlink target |
| `public/images/` | www-data | www-data | 755 | Placeholder images |
| `storage/logs/` | www-data | www-data | 755 | Log files |

### Apply All Permissions

```bash
# For shared hosting (not SSH):
# Upload this script as fix-permissions.php and access via browser

<?php
chmod('storage/app/public', 0755);
chmod('public/storage', 0755);
chmod('public/images', 0755);
chmod('storage/logs', 0755);
echo "Permissions fixed!";
?>

# Then delete the script
```

---

## 🔍 DEBUGGING COMMANDS

### List All Storage Files

```bash
php artisan tinker
>>> Storage::disk('public')->allFiles()
>>> Storage::disk('public')->allDirectories()
>>> exit
```

### Test Image Upload Service

```bash
php artisan tinker

# Test validation
>>> $file = new \Illuminate\Http\UploadedFile('path/to/file.jpg', 'file.jpg');
>>> \App\Services\ImageUploadService::isValidImage($file);

# Test upload
>>> \App\Services\ImageUploadService::getUrl('products/test.jpg');

# Test placeholder
>>> \App\Services\ImageUploadService::getUrl(null);

>>> exit
```

### Check Configuration

```bash
php artisan config:show filesystems
```

---

## 🐛 COMMON ISSUES & FIXES

| Issue | Cause | Fix |
|-------|-------|-----|
| Image returns placeholder | File missing from disk | Check storage/app/public/ directory |
| 404 on storage/ route | Symlink broken | `php artisan storage:link --force` |
| Permission denied writing | Wrong ownership | `sudo chown -R www-data:www-data storage/` |
| Images work locally not production | Different storage config | Check .env FILESYSTEM_DISK on server |
| Database has full URLs | Old upload logic | Run DB fix commands above |
| Accessor returns NULL | Model not using trait | Add `use HasImageAccessors;` to model |

---

## 📱 BLADE EXAMPLES (READY TO USE)

### Simple Image

```blade
<img src="{{ $product->image_url }}" alt="{{ $product->name }}">
```

### With Error Handling

```blade
<img src="{{ $product->image_url }}" 
     alt="{{ $product->name }}"
     onerror="this.src='{{ asset('images/no-image.svg') }}'">
```

### Gallery Loop

```blade
@forelse($product->images as $image)
    <img src="{{ $image->image_url }}" 
         alt="{{ $image->alt_text }}"
         onerror="this.src='{{ asset('images/no-image.svg') }}'">
@empty
    <img src="{{ asset('images/no-image.svg') }}" alt="No images">
@endforelse
```

---

## 🎯 FINAL VERIFICATION

Run this command to verify everything works:

```bash
php artisan tinker

# 1. Check symlink
>>> file_exists(public_path('storage'))
# Should return: true

# 2. Check placeholder
>>> file_exists(public_path('images/no-image.svg'))
# Should return: true

# 3. Check storage disk
>>> Storage::disk('public')->exists('.')
# Should return: true

# 4. Get a product with image
>>> $product = Product::whereNotNull('thumbnail')->first()
>>> $product->image_url
# Should return URL like: http://localhost:8000/storage/products/...

# 5. Test non-existent image
>>> \App\Services\ImageUploadService::getUrl(null)
# Should return: http://localhost:8000/images/no-image.svg

>>> exit
```

---

## 📞 SUPPORT

If issues persist:

1. Check `storage/logs/laravel.log` for errors
2. Run `php artisan storage:link --force`
3. Run `php artisan optimize:clear`
4. Verify file permissions with `ls -la`
5. Check database values with `php artisan tinker`
