<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

trait HasImageAccessors
{
    /**
     * Direct accessor for thumbnail URL with fallback.
     */
    protected function thumbnailUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                $placeholder = 'images/no-image.svg';
                
                if (empty($this->thumbnail)) {
                    return asset($placeholder);
                }

                if (!Storage::disk('public')->exists($this->thumbnail)) {
                    return asset($placeholder);
                }

                return Storage::disk('public')->url($this->thumbnail);
            }
        );
    }

    /**
     * Direct accessor for image URL with fallback.
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                $placeholder = 'images/no-image.svg';
                
                if (empty($this->image)) {
                    return asset($placeholder);
                }

                if (!Storage::disk('public')->exists($this->image)) {
                    return asset($placeholder);
                }

                return Storage::disk('public')->url($this->image);
            }
        );
    }

    /**
     * Verify image exists on disk (for validation/debugging).
     */
    public function imageExists(string $field = 'image', string $disk = 'public'): bool
    {
        $path = $this->getAttribute($field);
        
        if (empty($path)) {
            return false;
        }

        return Storage::disk($disk)->exists($path);
    }

    /**
     * Get safe image URL for HTML output.
     */
    public function getSafeImageUrl(
        string $field = 'image',
        string $disk = 'public',
        string $placeholder = 'images/no-image.svg'
    ): string {
        $path = $this->getAttribute($field);

        if (empty($path) || !Storage::disk($disk)->exists($path)) {
            return asset($placeholder);
        }

        return Storage::disk($disk)->url($path);
    }
}
