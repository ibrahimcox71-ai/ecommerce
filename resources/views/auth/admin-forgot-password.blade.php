<x-layouts.guest-layout title="Admin Forgot Password">
    <h4 class="fw-bold text-center mb-4">
        <i class="fas fa-key me-2"></i>Admin Forgot Password
    </h4>

    <p class="text-muted text-center small mb-4">
        Enter your email address and we'll send you a password reset link.
    </p>

    <form method="POST" action="{{ route('admin.password.email') }}">
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

        <button type="submit" class="btn btn-primary btn-block w-100">
            Send Password Reset Link
        </button>

        <p class="text-center mt-3 mb-0">
            <a href="{{ route('admin.login') }}" class="text-muted small">Back to login</a>
        </p>
    </form>
</x-layouts.guest-layout>
