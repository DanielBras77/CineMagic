<?php

namespace App\View\Components\Movies;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FilterCard extends Component
{

    public function __construct(
        public array $genres,
        public string $filterAction,
        public string $resetUrl,
        public ?string $genre = null,
        public ?string $title = null,
        public ?int $year = null,
    )
    {
        //
    }


    public function render(): View|Closure|string
    {
        return view('components.movies.filter-card');
    }

}
