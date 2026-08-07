<?php

namespace App\View\Components\Admin\Category;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TreeItem extends Component
{
    public function __construct(
        public array $category = [],
        public int $depth = 0
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.admin.category.tree-item');
    }
}
