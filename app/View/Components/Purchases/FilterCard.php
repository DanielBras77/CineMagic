<?php

namespace App\View\Components\Purchases;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FilterCard extends Component
{

    public function __construct(
        public string $filterAction,
        public string $resetUrl,
        public ?string $date = null,
        public ?string $customer_name = null,
    )
    {
        //
    }


    public function render(): View|Closure|string
    {
        return view('components.purchases.filter-card');
    }

}
