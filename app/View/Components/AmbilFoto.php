<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AmbilFoto extends Component
{
    // Menambahkan properti untuk menerima $nis
    // public string $nis;

    /**
     * Buat instance komponen baru.
     *
     * @param string $nis
     */
    public function __construct()
    {
        // $this->nis = $nis;  // Simpan nilai nis ke properti $nis
    }

    /**
     * Menampilkan view yang mewakili komponen ini.
     */
    public function render(): View|Closure|string
    {
        return view('components.ambil-foto');
    }
}
