<footer class="bg-white border-top py-3 mt-auto">
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</small>
            <small class="text-muted">
                <a href="{{ route('terms') }}" class="text-muted text-decoration-none me-2">Terms</a>
                <a href="{{ route('privacy-policy') }}" class="text-muted text-decoration-none">Privacy</a>
            </small>
        </div>
    </div>
</footer>
