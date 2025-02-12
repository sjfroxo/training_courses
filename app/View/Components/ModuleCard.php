<?php

namespace App\View\Components;

use App\Models\Module;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ModuleCard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Module $module
    )
    {

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.module-card');
    }
}
