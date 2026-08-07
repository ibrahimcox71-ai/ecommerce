<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PasswordChangeRequest;
use App\Http\Requests\Auth\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function showCustomerProfile()
    {
        $user = Auth::guard('web')->user();
        $loginHistory = $user->loginHistories()
            ->latest()
            ->take(10)
            ->get();

        return view('customer.profile', compact('user', 'loginHistory'));
    }

    public function showAdminProfile()
    {
        $admin = Auth::guard('admin')->user();
        $loginHistory = $admin->loginHistories()
            ->latest()
            ->take(10)
            ->get();

        return view('admin.profile', compact('admin', 'loginHistory'));
    }

    public function updateProfile(ProfileUpdateRequest $request)
    {
        $user = Auth::guard('web')->user();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }

    public function changePassword(PasswordChangeRequest $request)
    {
        $user = Auth::guard('web')->user();

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password changed successfully!');
    }

    public function updateAdminProfile(ProfileUpdateRequest $request)
    {
        $admin = Auth::guard('admin')->user();

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->phone = $request->phone;

        if ($request->hasFile('avatar')) {
            if ($admin->avatar) {
                Storage::disk('public')->delete($admin->avatar);
            }
            $admin->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $admin->save();

        return back()->with('success', 'Profile updated successfully!');
    }

    public function changeAdminPassword(PasswordChangeRequest $request)
    {
        $admin = Auth::guard('admin')->user();

        $admin->password = Hash::make($request->password);
        $admin->save();

        return back()->with('success', 'Password changed successfully!');
    }

    public function loginHistory(Request $request)
    {
        $guard = $request->query('guard', 'web');
        $user = Auth::guard($guard)->user();

        if (!$user) {
            return back()->with('error', 'User not authenticated.');
        }

        $histories = $user->loginHistories()
            ->latest()
            ->paginate(15);

        return view('auth.login-history', compact('histories', 'guard'));
    }

    public function destroySession(Request $request)
    {
        Auth::guard('web')->logoutOtherDevices($request->password);

        return back()->with('success', 'All other sessions have been terminated.');
    }
}
