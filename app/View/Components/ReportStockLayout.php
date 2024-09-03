<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ReportStockLayout extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $type,
        public $date,
        public $branch,
        public $item,
        public $batch = null,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layouts.report-stock');
    }
}
