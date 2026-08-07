<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    public static function bootHasSlug(): void
    {
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->{static::slugSource()});
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty(static::slugSource()) && !$model->isDirty('slug')) {
                $model->slug = Str::slug($model->{static::slugSource()});
            }
        });
    }

    protected static function slugSource(): string
    {
        return 'name';
    }
}
