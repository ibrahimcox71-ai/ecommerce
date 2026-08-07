<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\ReviewReply;
use App\Services\NotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function index(Request $request): View
    {
        $reviews = Review::with(['user', 'product.images', 'images'])
            ->when($request->filled('search'), fn($q) => $q->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                  ->orWhere('body', 'like', "%{$request->search}%")
                  ->orWhereHas('user', fn($q) => $q->where('name', 'like', "%{$request->search}%"))
                  ->orWhereHas('product', fn($q) => $q->where('name', 'like', "%{$request->search}%"));
            }))
            ->when($request->filled('status'), fn($q) => $q->where('status', $request->status))
            ->when($request->filled('rating'), fn($q) => $q->where('rating', $request->rating))
            ->when($request->filled('verified'), fn($q) => $q->where('is_verified', $request->verified === '1'))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.reviews.index', compact('reviews'));
    }

    public function show(Review $review): View
    {
        $review->load(['user', 'product.images', 'images', 'replies.admin']);
        return view('admin.reviews.show', compact('review'));
    }

    public function approve(Review $review): RedirectResponse
    {
        $review->update(['status' => 'approved']);

        if (app()->bound(NotificationService::class)) {
            app(NotificationService::class)->reviewApproved($review);
        }

        return back()->with('success', 'Review approved successfully.');
    }

    public function reject(Review $review): RedirectResponse
    {
        $review->update(['status' => 'rejected']);
        return back()->with('success', 'Review rejected.');
    }

    public function destroy(Review $review): RedirectResponse
    {
        $review->delete();
        return redirect()->route('admin.reviews.index')->with('success', 'Review deleted.');
    }

    public function reply(Request $request, Review $review): RedirectResponse
    {
        $validated = $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        $review->replies()->create([
            'admin_id' => Auth::guard('admin')->id(),
            'body' => $validated['body'],
        ]);

        return back()->with('success', 'Reply added successfully.');
    }

    public function deleteReply(ReviewReply $reply): RedirectResponse
    {
        $reply->delete();
        return back()->with('success', 'Reply deleted.');
    }

    public function markVerified(Review $review): RedirectResponse
    {
        $review->update([
            'is_verified' => true,
            'verified_at' => now(),
        ]);

        return back()->with('success', 'Review marked as verified purchase.');
    }
}
