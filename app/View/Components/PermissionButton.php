<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class PermissionButton extends Component
{
    public function __construct(
        public string $permission,
        public string $tag = 'button',
        public string $type = 'button',
        public ?string $href = null,
        public string $class = '',
        public ?string $action = null,
        public ?string $method = null,
    ) {
    }

    public function shouldRender(): bool
    {
        $user = Auth::guard('admin')->user();

        if (!$user) {
            return false;
        }

        if ($user->hasRole('super-admin')) {
            return true;
        }

        return $user->can($permission);
    }

    public function render(): View|Closure|string
    {
        return function (array $data) {
            if (!$this->shouldRender()) {
                return '';
            }

            $attributes = [];

            if ($this->tag === 'a') {
                $attributes['href'] = $this->href ?? '#';
            }

            if ($this->tag === 'button') {
                $attributes['type'] = $this->type;
            }

            if ($this->class) {
                $attributes['class'] = $this->class;
            }

            if ($this->action) {
                $attributes['onclick'] = $this->action;
            }

            $attrs = collect($attributes)->map(fn ($v, $k) => $k . '="' . e($v) . '"')->implode(' ');

            return '<' . $this->tag . ' ' . $attrs . '>' . e($data['slot'] ?? '') . '</' . $this->tag . '>';
        };
    }
}
