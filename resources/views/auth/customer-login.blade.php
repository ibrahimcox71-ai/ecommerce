<x-layouts.guest-layout title="Customer Login">
    <h4 class="fw-bold text-center mb-4 text-gray-800">Welcome Back</h4>

    <form method="POST" action="{{ route('customer.login') }}">
        @csrf

        <div class="mb-4">
            <label for="email" class="form-label fw-semibold text-gray-700">Email address</label>
            <input type="email" name="email" id="email" class="form-control-premium" value="{{ old('email') }}" required placeholder="your@email.com">
            @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="form-label fw-semibold text-gray-700">Password</label>
            <input type="password" name="password" id="password" class="form-control-premium" required placeholder="Enter your password">
            @error('password')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                <label class="form-check-label small text-gray-600" for="remember">Remember me</label>
            </div>
            <a href="{{ route('password.request') }}" class="text-primary-custom small fw-semibold">Forgot password?</a>
        </div>

        <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 mb-3 fw-semibold">Sign In</button>

        <div class="text-center">
            <p class="small text-gray-500">Don't have an account? <a href="{{ route('customer.register') }}" class="text-primary-custom fw-semibold">Register</a></p>
        </div>
    </form>
</x-layouts.guest-layout>
