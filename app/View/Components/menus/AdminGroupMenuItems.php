<?php

namespace App\View\Components\Menus;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AdminGroupMenuItems extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public array $options,
        public string $title)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.menus.admin-group-menu-items');
    }
}
