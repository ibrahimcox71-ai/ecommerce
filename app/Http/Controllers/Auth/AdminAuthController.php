<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AdminLoginRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(AdminLoginRequest $request)
    {
        $admin = Admin::where('email', $request->email)->first();

        if ($admin && $admin->isLocked()) {
            $minutes = now()->diffInMinutes($admin->locked_until);
            return back()->withErrors([
                'email' => "Account locked. Try again in {$minutes} minutes.",
            ])->onlyInput('email');
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            $admin = Auth::guard('admin')->user();

            if (!$admin->status) {
                Auth::guard('admin')->logout();
                return back()->withErrors(['email' => 'Your account has been deactivated.'])
                    ->onlyInput('email');
            }

            $admin->resetLoginAttempts();
            $admin->recordLogin();

            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Welcome back, ' . $admin->name . '!');
        }

        if ($admin) {
            $admin->incrementLoginAttempts();
            $admin->recordLogin(false, 'Invalid credentials');

            $remaining = $admin->getRemainingAttempts();
            if ($remaining > 0) {
                return back()->withErrors([
                    'email' => "Invalid credentials. {$remaining} attempt(s) remaining.",
                ])->onlyInput('email');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        if ($admin) {
            $admin->recordLogout();
        }

        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'You have been logged out successfully.');
    }
}
