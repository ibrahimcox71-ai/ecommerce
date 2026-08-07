@extends('layouts.app')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center bg-light py-5">
    <div class="card border-0 shadow-sm p-4 p-md-5" style="max-width: 420px; width: 100%; border-radius: 16px;">
        <div class="text-center mb-4">
            <div class="d-flex align-items-center justify-content-center gap-2 mb-2">
                <span class="badge bg-warning p-2 rounded-3 text-white"><i class="fa-solid fa-store fs-4"></i></span>
                <h3 class="fw-bold m-0">Ecommerce Platform</h3>
            </div>
            <p class="text-muted small">Welcome Back</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-3 text-start">
                <label for="email" class="form-label fw-medium text-dark">Email address</label>
                <input type="email" id="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="your@email.com" required autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3 text-start">
                <label for="password" class="form-label fw-medium text-dark">Password</label>
                <input type="password" id="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" placeholder="Enter your password" required>
                @error('password')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="d-flex justify-content-between align-items-center mb-4 fs-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label text-muted" for="remember">Remember me</label>
                </div>
                @if (Route::has('password.request'))
                    <a class="text-primary text-decoration-none fw-medium" href="{{ route('password.request') }}">Forgot password?</a>
                @endif
            </div>

            <!-- Button -->
            <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm mb-3">Sign In</button>

            <!-- Register Link -->
            @if (Route::has('register'))
                <div class="text-center fs-6">
                    <span class="text-muted">Don't have an account?</span>
                    <a href="{{ route('register') }}" class="text-primary text-decoration-none fw-semibold">Register</a>
                </div>
            @endif
        </form>
    </div>
</div>
@endsection
