<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AddButtonInvert extends Component
{
    /**
     * @param string $route
     */
    public function __construct(
        public string $route
    )
    {
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.add-button-invert');
    }
}
