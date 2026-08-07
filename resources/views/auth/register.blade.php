<x-layouts.guest-layout title="Register">
    <h4 class="fw-bold text-center mb-4">Create Account</h4>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-4">
            <div class="form-outline">
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                <label class="form-label" for="name">Full name</label>
            </div>
            @error('name')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <div class="form-outline">
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                <label class="form-label" for="email">Email address</label>
            </div>
            @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="form-outline">
                    <input type="password" name="password" id="password" class="form-control" required>
                    <label class="form-label" for="password">Password</label>
                </div>
                @error('password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <div class="form-outline">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                    <label class="form-label" for="password_confirmation">Confirm password</label>
                </div>
            </div>
        </div>

        <div class="form-check mb-4">
            <input type="checkbox" name="terms" class="form-check-input" id="terms">
            <label class="form-check-label small" for="terms">
                I agree to the <a href="{{ route('terms') }}">Terms of Service</a> and <a href="{{ route('privacy-policy') }}">Privacy Policy</a>
            </label>
            @error('terms')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary btn-block w-100 mb-3">Create Account</button>

        <div class="text-center">
            <p class="small">Already have an account? <a href="{{ route('login') }}">Sign In</a></p>
        </div>
    </form>
</x-layouts.guest-layout>
