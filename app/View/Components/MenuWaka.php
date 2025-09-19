<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MenuWaka extends Component
{
    public $namaProgram;

    public function __construct($namaProgram)
    {
        $this->namaProgram = $namaProgram;
    }

    public function render()
    {
        return view('components.menu-waka');
    }
}
