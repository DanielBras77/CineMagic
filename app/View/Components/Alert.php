<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{
    public string $randomId = '';
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $type = 'dark',
        public string $message = '',
    ) {
        $this->type = strtolower($type);
        if (!in_array($this->type, ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'], true)) {
            $this->type = 'dark';
        }
        $this->randomId = 'alert-' . rand(10000, 99999);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.alert');
    }
}
