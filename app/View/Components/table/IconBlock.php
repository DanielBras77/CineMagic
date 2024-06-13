<?php

namespace App\View\Components\table;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class IconBlock extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $action = '#',
        public bool $blocked = false,
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table.icon-block');
    }
}
