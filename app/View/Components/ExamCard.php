<?php

namespace App\View\Components;

use App\Models\ModuleExam;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ExamCard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ModuleExam $exam,
        public int $iteration
    )
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.exam-card');
    }
}
