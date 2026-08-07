<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductImageController extends Controller
{
    /**
     * Store product with images.
     *
     * BEST PRACTICES EXAMPLE
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            
            // Thumbnail: single image
            'thumbnail' => 'nullable|image|mimes:jpeg,png,gif,webp|max:5120',
            
            // Gallery: multiple images
            'images.*' => 'nullable|image|mimes:jpeg,png,gif,webp|max:5120',
        ]);

        // ============================================================
        // STEP 1: Upload thumbnail to storage (returns RELATIVE path)
        // ============================================================
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = ImageUploadService::upload(
                $request->file('thumbnail'),
                'products',    // Directory in storage/app/public/
                'public'       // Disk name
            );
            
            // Log what was stored
            \Log::info("Thumbnail uploaded: {$thumbnailPath}");
        }

        // ============================================================
        // STEP 2: Create product with RELATIVE path (not full URL!)
        // ============================================================
        $product = Product::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? '',
            
            // IMPORTANT: Store ONLY the relative path
            // Example: "products/20240115120530_abc12345.jpg"
            // NOT: "/storage/products/..." or "http://..." or absolute path
            'thumbnail' => $thumbnailPath,
        ]);

        // ============================================================
        // STEP 3: Upload multiple images for gallery
        // ============================================================
        if ($request->hasFile('images')) {
            $imagePaths = ImageUploadService::uploadMultiple(
                $request->file('images'),
                'products',
                'public'
            );

            // Create ProductImage records with relative paths
            foreach ($imagePaths as $index => $path) {
                $product->images()->create([
                    'image' => $path,           // Relative path
                    'alt_text' => $validated['name'],
                    'is_primary' => $index === 0,
                    'sort_order' => $index,
                ]);
            }
            
            \Log::info("Created " . count($imagePaths) . " product images");
        }

        return redirect()->route('admin.products.show', $product)
                       ->with('success', 'Product created with images!');
    }

    /**
     * Update product and replace images.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,gif,webp|max:5120',
        ]);

        // ============================================================
        // REPLACE THUMBNAIL
        // ============================================================
        if ($request->hasFile('thumbnail')) {
            $newPath = ImageUploadService::replace(
                $request->file('thumbnail'),
                $product->thumbnail,     // Old path to delete
                'products',
                'public'
            );
            
            $product->update(['thumbnail' => $newPath]);
            
            \Log::info("Product thumbnail replaced: {$newPath}");
        }

        $product->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
        ]);

        return redirect()->route('admin.products.show', $product)
                       ->with('success', 'Product updated!');
    }

    /**
     * Delete product and cleanup images.
     */
    public function destroy(Product $product)
    {
        // ============================================================
        // DELETE ALL IMAGES
        // ============================================================
        
        // Delete main thumbnail
        if ($product->thumbnail) {
            ImageUploadService::delete($product->thumbnail, 'public');
            \Log::info("Deleted thumbnail: {$product->thumbnail}");
        }

        // Delete gallery images
        $imagePaths = $product->images->pluck('image')->toArray();
        if (!empty($imagePaths)) {
            $deleted = ImageUploadService::deleteMultiple($imagePaths, 'public');
            \Log::info("Deleted {$deleted} product images");
        }

        // Delete product record
        $product->delete();

        return redirect()->route('admin.products.index')
                       ->with('success', 'Product deleted!');
    }

    /**
     * Upload image via AJAX (for real-time preview).
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,gif,webp|max:5120',
        ]);

        $path = ImageUploadService::upload(
            $request->file('image'),
            'products/temp',  // Temporary directory
            'public'
        );

        if (!$path) {
            return response()->json([
                'success' => false,
                'message' => 'Upload failed',
            ], 400);
        }

        return response()->json([
            'success' => true,
            'path' => $path,
            'url' => ImageUploadService::getUrl($path, 'public'),
        ]);
    }

    /**
     * Show image in view (example).
     */
    public function show(Product $product)
    {
        // Model accessor automatically returns fallback image if missing
        return view('admin.products.show', [
            'product' => $product,
            
            // These will use model accessors automatically:
            'thumbnailUrl' => $product->thumbnail_url,      // Auto-fallback
            'imageUrls' => $product->images->map(fn($img) => $img->image_url), // Auto-fallback
            
            // Or manual helper:
            'manualUrl' => ImageUploadService::getUrl($product->thumbnail),
        ]);
    }
}
