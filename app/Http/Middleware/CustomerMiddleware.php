<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('customer')->check()) {
            return redirect()->route('customer.login');
        }

        $customer = Auth::guard('customer')->user();

        if (!$customer->status) {
            Auth::guard('customer')->logout();
            return redirect()->route('customer.login')
                ->with('error', 'Your account has been deactivated.');
        }

        return $next($request);
    }
}
