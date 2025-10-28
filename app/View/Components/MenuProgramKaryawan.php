<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MenuProgramKaryawan extends Component
{
    public array $items;
    public $menuItems;
    /**
     * Create a new component instance.
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
        // Menyimpan HTML langsung dalam variabel
        $this->menuItems = '
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-users-cog text-warning"></i>
                <p>
                    Legalisir
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route(\'legalisir-ijazah.index\')}}" class="nav-link">
                        <i class="fas fa-user-check nav-icon ml-2 text-primary"></i>
                        <p> Data Legalisir </p>
                    </a>
                </li>
            </ul>
        </li>';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {

        //return view('components.view('components.menu-program-karyawan')');
        return view('components.menu-program-karyawan');
    }
}
