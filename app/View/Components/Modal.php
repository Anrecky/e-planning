<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends Component
{
    public $modalId;
    public $modalTitle;
    public $size;

    public function __construct($modalId, $modalTitle, $size = null)
    {
        $this->modalId = $modalId;
        $this->modalTitle = $modalTitle;
        $this->size = $size;
    }

    public function render(): View|Closure|string
    {
        return view('components.modal');
    }
}
