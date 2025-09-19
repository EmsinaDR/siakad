<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TandaTangan extends Component
{
    public array $ttds;
    public string $tempat;
    public string $tanggal;

    public function __construct(array $ttds = [], string $tempat = '', string $tanggal = '')
    {
        $this->ttds = $ttds;
        $this->tempat = $tempat;
        $this->tanggal = $tanggal;
    }

    public function render(): View|Closure|string
    {
        return view('components.tanda-tangan');
    }
}
