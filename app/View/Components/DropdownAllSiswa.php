<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DropdownAllSiswa extends Component
{
    public $type;
    public $listdata; // Ganti nama properti
    public $label; // Ganti nama properti
    public $name; // Ganti nama properti
    public $id_property; // Ganti nama properti

    public function __construct($type = 'single', $listdata = [], $label ='Label', $name ='name', $id_property = 'single')
    {
        $this->type = $type;
        $this->listdata = $listdata;
        $this->label = $label;
        $this->name = $name;
        $this->id_property = $id_property;
    }



    public function render()
    {
        // dd($this->listdata); // Debug di sini
        return view('components.dropdown-allsiswa');
    }
}
