<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function index(): View
    {
        $userId = Auth::guard('web')->id();
        $reviews = Review::with('product.images')
            ->where('user_id', $userId)
            ->latest()
            ->paginate(15);

        return view('customer.reviews', compact('reviews'));
    }

    public function store(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'body' => 'required|string|max:5000',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $userId = Auth::guard('web')->id();

        $existing = Review::where('user_id', $userId)
            ->where('product_id', $product->id)
            ->exists();

        if ($existing) {
            return back()->with('error', 'You have already reviewed this product.');
        }

        $review = Review::create([
            'user_id' => $userId,
            'product_id' => $product->id,
            'rating' => $validated['rating'],
            'title' => $validated['title'] ?? null,
            'body' => $validated['body'],
            'status' => 'pending',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $i => $file) {
                $path = 'reviews/' . date('Y/m');
                $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                Storage::disk('public')->putFileAs($path, $file, $filename);

                $review->images()->create([
                    'image' => $path . '/' . $filename,
                    'sort_order' => $i,
                ]);
            }
        }

        return back()->with('success', 'Your review has been submitted and is pending approval.');
    }

    public function update(Request $request, Review $review): RedirectResponse
    {
        if ($review->user_id !== Auth::guard('web')->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'body' => 'required|string|max:5000',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $review->update([
            'rating' => $validated['rating'],
            'title' => $validated['title'] ?? null,
            'body' => $validated['body'],
            'status' => 'pending',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $i => $file) {
                $path = 'reviews/' . date('Y/m');
                $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                Storage::disk('public')->putFileAs($path, $file, $filename);

                $review->images()->create([
                    'image' => $path . '/' . $filename,
                    'sort_order' => $i,
                ]);
            }
        }

        return back()->with('success', 'Your review has been updated and is pending approval.');
    }

    public function destroy(Review $review): RedirectResponse
    {
        if ($review->user_id !== Auth::guard('web')->id()) {
            abort(403);
        }

        foreach ($review->images as $image) {
            if (Storage::disk('public')->exists($image->image)) {
                Storage::disk('public')->delete($image->image);
            }
        }

        $review->delete();

        return back()->with('success', 'Review deleted successfully.');
    }

    public function helpful(Review $review): JsonResponse
    {
        $review->increment('helpful_count');
        return response()->json(['success' => true, 'count' => $review->fresh()->helpful_count]);
    }
}
