<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DeclaracionJuramentada;
use App\Exports\DeclaracionJuramentadaExport;
use Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class DeclaracionJuramentadaController extends Controller
{
    public function show($id)
    {
        return PDF::loadView('exports.declaracion-juramentada', [
            'declaracion' => DeclaracionJuramentada::findOrFail($id),
            'qrcode' => QrCode::format('svg')->size(100)->generate(route('declaracion-juramentada', $id))
        ])->stream();
    }
    public function index(Request $request)
    {
        $request->validate([
            'desde' => 'nullable|date',
            'hasta' => 'nullable|date'
        ]);
        $sortBy = $request->input('sort_by');
        $status = $request->input('status');
        $search = $request->input('search');
        $desde = $request->input('desde');
        $hasta = $request->input('hasta');
        $declaraciones = DeclaracionJuramentada::where(function ($query) use ($search) {
            return $query->where('numero_identificacion', $search)->orWhere('codigo', 'like', "%$search%");
        })->with('productos');
        if (isset($desde))
            $declaraciones->where('fecha', '>=', new Carbon($desde));
        if (isset($hasta))
            $declaraciones->where('fecha', '<=', new Carbon($hasta));
        if (isset($sortBy) && $sortBy !== '')
            $declaraciones->orderBy($sortBy, $request->input('sort_order'));
        if ($status !== 'T')
            $declaraciones->where('estado', $status);
        return Excel::download(new DeclaracionJuramentadaExport($declaraciones->get()), 'declaraciones' . date('YmdHis') . '.xlsx');
    }
}
