<?php

namespace App\View\Components\menus;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SubmenuFullWidth extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $uniqueName,
        public string $content = 'Submenu',
        public bool $selectable = true,
        public bool $selected = false,
        public int $cols = 1,
        public int $cols_sm = 2,
        public int $cols_md = 3,
        public int $cols_lg = 3
    )
    {

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.menus.submenu-full-width');
    }
}
