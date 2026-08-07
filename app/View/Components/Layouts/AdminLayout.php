<?php

namespace App\View\Components\Layouts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AdminLayout extends Component
{
    public string $title;

    public function __construct(string $title = 'Admin Panel')
    {
        $this->title = $title;
    }

    public function render(): View|Closure|string
    {
        return view('layouts.admin');
    }
}
