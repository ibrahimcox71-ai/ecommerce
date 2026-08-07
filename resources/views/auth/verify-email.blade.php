<x-layouts.guest-layout title="Verify Email">
    <div class="text-center">
        <i class="fas fa-envelope-open-text fa-3x text-primary mb-3"></i>
        <h4 class="fw-bold mb-3">Verify Your Email</h4>
        <p class="text-muted small mb-4">A verification link has been sent to your email address.</p>

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-primary">Resend Verification Email</button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="mt-3">
            @csrf
            <button type="submit" class="btn btn-link text-muted small">Logout</button>
        </form>
    </div>
</x-layouts.guest-layout>
