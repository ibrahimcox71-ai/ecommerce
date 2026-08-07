<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function index(): View
    {
        $userId = Auth::guard('web')->id();
        $wishlists = Wishlist::with('product.images')
            ->where('user_id', $userId)
            ->latest()
            ->get();

        return view('customer.wishlist', compact('wishlists'));
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $userId = Auth::guard('web')->id();

        if (!$userId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Please login to add items to wishlist.',
            ], 401);
        }

        $exists = Wishlist::where('user_id', $userId)
            ->where('product_id', $request->product_id)
            ->exists();

        if ($exists) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product is already in your wishlist.',
            ], 409);
        }

        Wishlist::create([
            'user_id' => $userId,
            'product_id' => $request->product_id,
        ]);

        $count = Wishlist::where('user_id', $userId)->count();

        return response()->json([
            'status' => 'success',
            'message' => 'Product added to wishlist!',
            'count' => $count,
        ]);
    }

    public function destroy(Product $product): JsonResponse
    {
        $userId = Auth::guard('web')->id();

        $deleted = Wishlist::where('user_id', $userId)
            ->where('product_id', $product->id)
            ->delete();

        if (!$deleted) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found in your wishlist.',
            ], 404);
        }

        $count = Wishlist::where('user_id', $userId)->count();

        return response()->json([
            'status' => 'success',
            'message' => 'Product removed from wishlist!',
            'count' => $count,
        ]);
    }

    public function toggle(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $userId = Auth::guard('web')->id();

        if (!$userId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Please login to manage your wishlist.',
            ], 401);
        }

        $wishlist = Wishlist::where('user_id', $userId)
            ->where('product_id', $request->product_id)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            $added = false;
        } else {
            Wishlist::create([
                'user_id' => $userId,
                'product_id' => $request->product_id,
            ]);
            $added = true;
        }

        $count = Wishlist::where('user_id', $userId)->count();

        return response()->json([
            'status' => 'success',
            'added' => $added,
            'message' => $added ? 'Product added to wishlist!' : 'Product removed from wishlist!',
            'count' => $count,
        ]);
    }

    public function count(): JsonResponse
    {
        $userId = Auth::guard('web')->id();
        $count = $userId ? Wishlist::where('user_id', $userId)->count() : 0;

        return response()->json(['count' => $count]);
    }
}
