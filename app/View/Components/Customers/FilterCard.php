<?php

namespace App\View\Components\Customers;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FilterCard extends Component
{

    public function __construct(
        public string $filterAction,
        public string $resetUrl,
        public ?string $name = null,
        public ?string $email = null,
    )
    {
        //
    }


    public function render(): View|Closure|string
    {
        return view('components.customers.filter-card');
    }
}
