<?php

namespace App\View\Components\Admin;

use App\Models\Admin;
use App\Models\Notification;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class Header extends Component
{
    public mixed $admin;

    public array $notifications = [];

    public int $unreadCount = 0;

    public function __construct()
    {
        $this->admin = Auth::guard('admin')->user();

        if ($this->admin) {
            $this->notifications = Notification::where('notifiable_type', Admin::class)
                ->where('notifiable_id', $this->admin->id)
                ->latest()
                ->take(10)
                ->get()
                ->all();

            $this->unreadCount = Notification::where('notifiable_type', Admin::class)
                ->where('notifiable_id', $this->admin->id)
                ->unread()
                ->count();
        }
    }

    public function render(): View|Closure|string
    {
        return view('partials.admin.header');
    }
}
