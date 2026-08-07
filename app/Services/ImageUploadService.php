<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploadService
{
    /**
     * Default placeholder image path.
     */
    public const PLACEHOLDER_IMAGE = 'images/no-image.svg';

    /**
     * Allowed image MIME types.
     */
    public const ALLOWED_MIMES = [
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp',
        'image/svg+xml',
    ];

    /**
     * Maximum image file size in KB.
     */
    public const MAX_SIZE_KB = 5120; // 5MB

    /**
     * Upload an image to storage.
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param string $disk
     * @return string|null Relative path (e.g., 'products/image.jpg') or null on failure
     */
    public static function upload(
        UploadedFile $file,
        string $directory = 'products',
        string $disk = 'public'
    ): ?string {
        // Validate file
        if (!self::isValidImage($file)) {
            return null;
        }

        try {
            // Generate unique filename
            $filename = self::generateFilename($file);
            
            // Store file and return relative path
            $path = $file->storeAs(
                $directory,
                $filename,
                ['disk' => $disk]
            );

            return $path;
        } catch (\Exception $e) {
            \Log::error('Image upload failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Upload multiple images.
     *
     * @param array $files
     * @param string $directory
     * @param string $disk
     * @return array Array of relative paths
     */
    public static function uploadMultiple(
        array $files,
        string $directory = 'products',
        string $disk = 'public'
    ): array {
        $paths = [];

        foreach ($files as $file) {
            $path = self::upload($file, $directory, $disk);
            if ($path) {
                $paths[] = $path;
            }
        }

        return $paths;
    }

    /**
     * Delete an image from storage.
     *
     * @param string|null $path
     * @param string $disk
     * @return bool
     */
    public static function delete(?string $path, string $disk = 'public'): bool
    {
        if (empty($path)) {
            return false;
        }

        try {
            return Storage::disk($disk)->delete($path);
        } catch (\Exception $e) {
            \Log::error('Image deletion failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete multiple images.
     *
     * @param array $paths
     * @param string $disk
     * @return int Number of successfully deleted files
     */
    public static function deleteMultiple(array $paths, string $disk = 'public'): int
    {
        $deleted = 0;

        foreach ($paths as $path) {
            if (self::delete($path, $disk)) {
                $deleted++;
            }
        }

        return $deleted;
    }

    /**
     * Replace an old image with a new one.
     *
     * @param UploadedFile $file
     * @param string|null $oldPath
     * @param string $directory
     * @param string $disk
     * @return string|null
     */
    public static function replace(
        UploadedFile $file,
        ?string $oldPath,
        string $directory = 'products',
        string $disk = 'public'
    ): ?string {
        // Upload new file
        $newPath = self::upload($file, $directory, $disk);

        if ($newPath && !empty($oldPath)) {
            // Delete old file if new upload successful
            self::delete($oldPath, $disk);
        }

        return $newPath;
    }

    /**
     * Validate if file is a valid image.
     *
     * @param UploadedFile $file
     * @return bool
     */
    public static function isValidImage(UploadedFile $file): bool
    {
        // Check MIME type
        if (!in_array($file->getMimeType(), self::ALLOWED_MIMES)) {
            return false;
        }

        // Check file size
        if ($file->getSize() > self::MAX_SIZE_KB * 1024) {
            return false;
        }

        // Check if is valid image
        if (!getimagesize($file)) {
            return false;
        }

        return true;
    }

    /**
     * Generate a unique filename.
     *
     * @param UploadedFile $file
     * @return string
     */
    public static function generateFilename(UploadedFile $file): string
    {
        $timestamp = now()->format('YmdHis');
        $random = Str::random(8);
        $extension = $file->getClientOriginalExtension();

        return "{$timestamp}_{$random}.{$extension}";
    }

    /**
     * Get image URL with fallback.
     *
     * @param string|null $path
     * @param string $disk
     * @return string
     */
    public static function getUrl(?string $path, string $disk = 'public'): string
    {
        if (empty($path)) {
            return asset(self::PLACEHOLDER_IMAGE);
        }

        if (!Storage::disk($disk)->exists($path)) {
            return asset(self::PLACEHOLDER_IMAGE);
        }

        return Storage::disk($disk)->url($path);
    }

    /**
     * Check if image exists on disk.
     *
     * @param string|null $path
     * @param string $disk
     * @return bool
     */
    public static function exists(?string $path, string $disk = 'public'): bool
    {
        if (empty($path)) {
            return false;
        }

        return Storage::disk($disk)->exists($path);
    }
}
