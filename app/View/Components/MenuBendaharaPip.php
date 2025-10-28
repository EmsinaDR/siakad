<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MenuBendaharaPip extends Component
{
    public $namaProgram;

    public function __construct($namaProgram)
    {
        $this->namaProgram = $namaProgram;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        //return view('components.view('components.menu-bendahara-pip')');
        return view('components.menu-bendahara-pip');
    }
}
