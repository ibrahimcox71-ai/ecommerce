<?php

namespace App\View\Components\Admin\Category;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MediaUploader extends Component
{
    public function __construct(
        public string $name = 'image',
        public string $label = 'Image',
        public ?string $currentImage = null,
        public string $accept = 'image/*',
        public string $maxSize = '2MB',
        public string $recommended = '512x512px',
        public ?string $helpText = null,
        public bool $removable = false,
        public string $removeName = 'remove_image',
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.admin.category.media-uploader');
    }
}
