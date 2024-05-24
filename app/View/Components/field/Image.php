<?php

namespace App\View\Components\Field;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Image extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $name,
        public string $label = '',
        public string $imageUrl = '',
        public bool $readonly = false,
        public bool $deleteAllow = true,
        public string $deleteTitle = 'Delete',
        public string $deleteForm = '',
        public string $width = 'full',
    )
    {
        $this->width = trim(strtolower($width));
        if (!in_array($this->width, ['full', 'xs', 'sm', 'md', 'lg', 'xl', '1/3', '2/3', '1/4', '2/4', '3/4', '1/5', '2/5', '3/5', '4/5'], true)) {
            $this->width = 'full';
        }
        $this->label = trim($label) ?: $name;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.field.image');
    }
}
