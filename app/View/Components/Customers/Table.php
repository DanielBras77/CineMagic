<?php

namespace App\View\Components\Customers;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Table extends Component
{
    public function __construct(
        public object $customers,
        public bool $showView = true,
        public bool $showEdit = true,
        public bool $showDelete = true,
    )
    {
        //
    }


    public function render(): View|Closure|string
    {
        return view('components.customers.table');
    }
}
