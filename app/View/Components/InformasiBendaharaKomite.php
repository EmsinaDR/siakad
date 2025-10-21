<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InformasiBendaharaKomite extends Component
{
    public $data_keuangan_komite; // Tambahkan properti publik
    public $data_keuangan_komite_keluar; // Tambahkan properti publik

    public function __construct($data_keuangan_komite, $data_keuangan_komite_keluar)
    {
        $this->data_keuangan_komite = $data_keuangan_komite;
        $this->data_keuangan_komite_keluar = $data_keuangan_komite_keluar;
    }

    public function render()
    {
        return view('components.informasi-bendahara-komite');
    }
}
