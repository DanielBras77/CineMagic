<?php

namespace App\View\Components\menus;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Cart extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public int $total = 0,
        public string $href = '#',
        public bool $selectable = true,
        public bool $selected = false
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.menus.cart');
    }
}
