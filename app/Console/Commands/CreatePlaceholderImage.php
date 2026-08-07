<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class CreatePlaceholderImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:create-placeholder
                            {--width=400 : Image width}
                            {--height=400 : Image height}
                            {--text="No Image" : Placeholder text}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a placeholder image for missing product images';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $width = (int) $this->option('width');
        $height = (int) $this->option('height');
        $text = $this->option('text');

        $imagePath = public_path('images/no-image.png');

        // Create images directory if not exists
        if (!File::isDirectory(public_path('images'))) {
            File::makeDirectory(public_path('images'), 0755, true);
        }

        try {
            // Create placeholder image using GD
            $image = imagecreatetruecolor($width, $height);
            
            // Set colors
            $bgColor = imagecolorallocate($image, 240, 240, 240); // Light gray
            $textColor = imagecolorallocate($image, 100, 100, 100); // Dark gray
            $borderColor = imagecolorallocate($image, 180, 180, 180); // Medium gray
            
            // Fill background
            imagefilledrectangle($image, 0, 0, $width, $height, $bgColor);
            
            // Add border
            imagerectangle($image, 0, 0, $width - 1, $height - 1, $borderColor);
            
            // Add text
            $fontPath = __DIR__ . '/../../Fonts/arial.ttf'; // or use default
            $fontSize = 16;
            
            // Calculate text position
            $textBBox = imagettfbbox($fontSize, 0, $fontPath, $text);
            $textWidth = $textBBox[2] - $textBBox[0];
            $textHeight = $textBBox[1] - $textBBox[7];
            $x = ($width - $textWidth) / 2;
            $y = ($height - $textHeight) / 2;
            
            imagettftext($image, $fontSize, 0, $x, $y, $textColor, $fontPath, $text);
            
            // Save image
            imagepng($image, $imagePath);
            imagedestroy($image);

            $this->info("Placeholder image created at: {$imagePath}");
            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Failed to create placeholder image: " . $e->getMessage());
            return self::FAILURE;
        }
    }
}
