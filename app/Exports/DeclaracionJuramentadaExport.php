<?php

namespace App\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DeclaracionJuramentadaExport implements FromView
{
    protected $declaraciones;
    public function __construct($declaraciones)
    {
        $this->declaraciones = $declaraciones;
    }
    public function view(): View
    {
        return view('exports.declaraciones-juramentadas', [
            'declaraciones' => $this->declaraciones
        ]);
    }
}
