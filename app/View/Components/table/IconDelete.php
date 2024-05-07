<?php

namespace App\View\Components\table;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class IconDelete extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $action = '#',
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table.icon-delete');
    }
}
