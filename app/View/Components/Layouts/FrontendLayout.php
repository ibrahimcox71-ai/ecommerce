<?php

namespace App\View\Components\Layouts;

use App\Services\SEOService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FrontendLayout extends Component
{
    public string $title;
    public ?string $metaDescription;
    public array $seoData;

    public function __construct(string $title = 'Home', ?string $metaDescription = null, array $seoData = [])
    {
        $this->title = $title;
        $this->metaDescription = $metaDescription;
        $this->seoData = $seoData;

        if (empty($seoData)) {
            $seo = app(SEOService::class);
            $seo->setTitle($title);
            if ($metaDescription) {
                $seo->setDescription($metaDescription);
            }
            $this->seoData = $seo->build();
        }
    }

    public function render(): View|Closure|string
    {
        return view('components.layouts.frontend-layout');
    }
}
