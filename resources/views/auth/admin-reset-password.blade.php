<x-layouts.guest-layout title="Admin Reset Password">
    <h4 class="fw-bold text-center mb-4">
        <i class="fas fa-key me-2"></i>Admin Reset Password
    </h4>

    <form method="POST" action="{{ route('admin.password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

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
                <label class="form-label" for="password">New Password</label>
            </div>
            @error('password')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <div class="form-outline">
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                <label class="form-label" for="password_confirmation">Confirm Password</label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block w-100">
            Reset Password
        </button>
    </form>
</x-layouts.guest-layout>
