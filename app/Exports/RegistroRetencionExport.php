<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class RegistroRetencionExport implements FromView
{
    protected $retenciones;
    public function __construct($retenciones)
    {
        $this->retenciones = $retenciones;
    }
    public function view(): View
    {
        return view('exports.retenciones', [
            'retenciones' => $this->retenciones
        ]);
    }
}
