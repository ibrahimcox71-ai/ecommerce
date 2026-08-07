<x-layouts.guest-layout title="Admin Login">
    <h4 class="fw-bold text-center mb-4">
        <i class="fas fa-shield-alt me-2"></i>Admin Login
    </h4>

    <form method="POST" action="{{ route('admin.login') }}">
        @csrf

        <div class="mb-4">
            <div class="form-outline">
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                <label class="form-label" for="email">Email address</label>
            </div>
            @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <div class="form-outline">
                <input type="password" name="password" id="password" class="form-control" required>
                <label class="form-label" for="password">Password</label>
            </div>
            @error('password')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-check mb-4">
            <input type="checkbox" name="remember" class="form-check-input" id="remember">
            <label class="form-check-label" for="remember">Remember me</label>
        </div>

        <button type="submit" class="btn btn-primary btn-block w-100">Sign In</button>
    </form>
</x-layouts.guest-layout>
