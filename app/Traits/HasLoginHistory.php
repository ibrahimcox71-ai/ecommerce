<?php

namespace App\Traits;

use App\Models\LoginHistory;

trait HasLoginHistory
{
    public function loginHistories()
    {
        return $this->morphMany(LoginHistory::class, 'authenticatable');
    }

    public function recordLogin($isSuccessful = true, $failureReason = null): LoginHistory
    {
        $userAgent = request()->userAgent();

        return $this->loginHistories()->create([
            'ip_address' => request()->ip(),
            'user_agent' => $userAgent,
            'device_type' => $this->detectDeviceType($userAgent),
            'browser' => $this->detectBrowser($userAgent),
            'platform' => $this->detectPlatform($userAgent),
            'location' => null,
            'is_successful' => $isSuccessful,
            'failure_reason' => $failureReason,
            'login_at' => now(),
        ]);
    }

    public function recordLogout(): void
    {
        $this->loginHistories()
            ->whereNull('logout_at')
            ->latest()
            ->first()
            ?->update(['logout_at' => now()]);
    }

    public function latestLoginHistory()
    {
        return $this->morphOne(LoginHistory::class, 'authenticatable')
            ->latestOfMany();
    }

    private function detectDeviceType(?string $userAgent): string
    {
        if (preg_match('/Mobile|Android|iPhone|iPad|iPod/i', $userAgent ?? '')) {
            return preg_match('/iPad|Tablet/i', $userAgent ?? '') ? 'tablet' : 'mobile';
        }
        return 'desktop';
    }

    private function detectBrowser(?string $userAgent): string
    {
        if (preg_match('/Edge/i', $userAgent ?? '')) return 'Edge';
        if (preg_match('/Firefox/i', $userAgent ?? '')) return 'Firefox';
        if (preg_match('/Chrome/i', $userAgent ?? '')) return 'Chrome';
        if (preg_match('/Safari/i', $userAgent ?? '')) return 'Safari';
        if (preg_match('/Opera/i', $userAgent ?? '')) return 'Opera';
        return 'Unknown';
    }

    private function detectPlatform(?string $userAgent): string
    {
        if (preg_match('/Windows/i', $userAgent ?? '')) return 'Windows';
        if (preg_match('/Macintosh|Mac OS X/i', $userAgent ?? '')) return 'macOS';
        if (preg_match('/Linux/i', $userAgent ?? '')) return 'Linux';
        if (preg_match('/Android/i', $userAgent ?? '')) return 'Android';
        if (preg_match('/iPhone|iPad|iPod/i', $userAgent ?? '')) return 'iOS';
        return 'Unknown';
    }
}
