<x-layouts.guest-layout title="Forgot Password">
    <h4 class="fw-bold text-center mb-4">Reset Password</h4>
    <p class="text-muted small text-center mb-4">Enter your email and we'll send you a reset link.</p>

    <form method="POST" action="{{ route('password.email') }}">
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

        <button type="submit" class="btn btn-primary btn-block w-100">Send Reset Link</button>

        <div class="text-center mt-3">
            <a href="{{ route('login') }}" class="small">Back to login</a>
        </div>
    </form>
</x-layouts.guest-layout>
