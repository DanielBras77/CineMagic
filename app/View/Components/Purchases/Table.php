<?php

namespace App\View\Components\Purchases;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Table extends Component
{

    public function __construct(
        public object $purchases,
        public bool $showView = true,
    )
    {
        //
    }


    public function render(): View|Closure|string
    {
        return view('components.purchases.table');
    }
}
