<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

trait HasCache
{
    protected static function bootHasCache(): void
    {
        static::saved(function (Model $model) {
            $model->clearModelCache();
        });

        static::deleted(function (Model $model) {
            $model->clearModelCache();
        });
    }

    protected static function cacheKeys(): array
    {
        return property_exists(static::class, 'cacheKeys')
            ? static::$cacheKeys
            : [];
    }

    public function clearModelCache(): void
    {
        foreach (static::cacheKeys() as $key) {
            Cache::forget($key);
        }
    }

    public static function forgetCache(string $key): void
    {
        Cache::forget($key);
    }
}
