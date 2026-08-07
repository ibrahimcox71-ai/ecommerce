<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(): View
    {
        $userId = Auth::guard('web')->id();
        $notifications = Notification::where('notifiable_id', $userId)
            ->where('notifiable_type', 'App\Models\User')
            ->latest()
            ->paginate(20);

        return view('customer.notifications', compact('notifications'));
    }

    public function markAsRead(Notification $notification): RedirectResponse
    {
        if ($notification->notifiable_id !== Auth::guard('web')->id()) {
            abort(403);
        }

        $notification->markAsRead();

        return back()->with('success', 'Notification marked as read.');
    }

    public function markAllAsRead(): RedirectResponse
    {
        $userId = Auth::guard('web')->id();

        Notification::where('notifiable_id', $userId)
            ->where('notifiable_type', 'App\Models\User')
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return back()->with('success', 'All notifications marked as read.');
    }

    public function destroy(Notification $notification): RedirectResponse
    {
        if ($notification->notifiable_id !== Auth::guard('web')->id()) {
            abort(403);
        }

        $notification->delete();

        return back()->with('success', 'Notification deleted.');
    }

    public function unreadCount(): JsonResponse
    {
        $userId = Auth::guard('web')->id();
        $count = 0;

        if ($userId) {
            $count = Notification::where('notifiable_id', $userId)
                ->where('notifiable_type', 'App\Models\User')
                ->whereNull('read_at')
                ->count();
        }

        return response()->json(['count' => $count]);
    }

    public function latest(): JsonResponse
    {
        $userId = Auth::guard('web')->id();

        if (!$userId) {
            return response()->json(['notifications' => []]);
        }

        $notifications = Notification::where('notifiable_id', $userId)
            ->where('notifiable_type', 'App\Models\User')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($n) {
                return [
                    'id' => $n->id,
                    'type' => $n->type,
                    'data' => $n->data,
                    'read_at' => $n->read_at,
                    'created_at' => $n->created_at->diffForHumans(),
                ];
            });

        return response()->json(['notifications' => $notifications]);
    }
}
