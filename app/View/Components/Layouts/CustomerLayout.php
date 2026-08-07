<?php

namespace App\View\Components\Layouts;

use App\Services\SEOService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CustomerLayout extends Component
{
    public string $title;
    public ?string $metaDescription;
    public array $seoData;

    public function __construct(string $title = 'My Account', ?string $metaDescription = null, array $seoData = [])
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
            $seo->setRobots('noindex,nofollow');
            $this->seoData = $seo->build();
        }
    }

    public function render(): View|Closure|string
    {
        return view('layouts.customer');
    }
}
