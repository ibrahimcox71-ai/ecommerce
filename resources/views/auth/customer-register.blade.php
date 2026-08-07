<x-layouts.guest-layout title="Customer Register">
    <h4 class="fw-bold text-center mb-4 text-gray-800">Create Account</h4>

    <form method="POST" action="{{ route('customer.register') }}">
        @csrf

        <div class="mb-4">
            <label for="name" class="form-label fw-semibold text-gray-700">Full name</label>
            <input type="text" name="name" id="name" class="form-control-premium" value="{{ old('name') }}" required placeholder="John Doe">
            @error('name')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="form-label fw-semibold text-gray-700">Email address</label>
            <input type="email" name="email" id="email" class="form-control-premium" value="{{ old('email') }}" required placeholder="your@email.com">
            @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="row mb-4">
            <div class="col-md-6 mb-3 mb-md-0">
                <label for="password" class="form-label fw-semibold text-gray-700">Password</label>
                <input type="password" name="password" id="password" class="form-control-premium" required placeholder="Min 8 characters">
                @error('password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="password_confirmation" class="form-label fw-semibold text-gray-700">Confirm password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control-premium" required placeholder="Repeat password">
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 mb-3 fw-semibold">Create Account</button>

        <div class="text-center">
            <p class="small text-gray-500">Already have an account? <a href="{{ route('customer.login') }}" class="text-primary-custom fw-semibold">Sign In</a></p>
        </div>
    </form>
</x-layouts.guest-layout>
