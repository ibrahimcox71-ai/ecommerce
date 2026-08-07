<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerAuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.customer-register');
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
        ]);

        $user->assignRole('customer');

        event(new Registered($user));

        Auth::guard('web')->login($user);

        $user->recordLogin();

        return redirect()->route('customer.dashboard')
            ->with('success', 'Account created successfully! Please verify your email.');
    }

    public function showLoginForm()
    {
        return view('auth.customer-login');
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user && $user->isLocked()) {
            $minutes = now()->diffInMinutes($user->locked_until);
            return back()->withErrors([
                'email' => "Account locked. Try again in {$minutes} minutes.",
            ])->onlyInput('email');
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::guard('web')->attempt($credentials, $remember)) {
            $user = Auth::guard('web')->user();

            if (!$user->status) {
                Auth::guard('web')->logout();
                return back()->withErrors(['email' => 'Your account has been deactivated.'])
                    ->onlyInput('email');
            }

            $user->resetLoginAttempts();
            $user->recordLogin();

            $request->session()->put('remember_me', $remember);

            return redirect()->intended(route('customer.dashboard'))
                ->with('success', 'Welcome back, ' . $user->name . '!');
        }

        if ($user) {
            $user->incrementLoginAttempts();
            $user->recordLogin(false, 'Invalid credentials');

            $remaining = $user->getRemainingAttempts();
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
        $user = Auth::guard('web')->user();

        if ($user) {
            $user->recordLogout();
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'You have been logged out successfully.');
    }
}
