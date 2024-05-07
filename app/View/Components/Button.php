<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{

    public function __construct(
        public string $element = 'a',
        public string $buttonName = '',
        public string $text = '',
        public string $href = '#',
        public string $type = 'dark',
    ) {
        $this->element = strtolower($element);
        if (!in_array($this->element, ['a', 'button', 'submit', 'reset'], true)) {
            $this->element = 'a';
        }
        $this->type = strtolower($type);
        if (!in_array($this->type, [
            'primary', 'secondary', 'success', 'danger',
            'warning', 'info', 'light', 'dark', 'link'
        ], true)) {
            $this->type = 'dark';
        }
        $this->buttonName = trim($buttonName);
        $this->text = trim($text) ?: ucfirst($this->type);
    }
    public function render(): View|Closure|string
    {
        return view('components.button');
    }
}
