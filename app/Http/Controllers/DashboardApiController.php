<?php

namespace App\Http\Controllers;

use App\DeclaracionJuramentada;
use App\ProductoRetenido;
use App\RegistroRetencion;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardApiController extends Controller
{
    public function index(Request $request)
    {
        $desde = (new Carbon($request->input('desde')))->startOfDay();
        $hasta = (new Carbon($request->input('hasta')))->endOfDay();
        $declaracionesB = DeclaracionJuramentada::active()->whereBetween('fecha', [$desde, $hasta]);
        $cantidadDeclaraciones = (clone $declaracionesB)->count();
        $retencionesB = RegistroRetencion::active()->whereBetween('fecha', [$desde, $hasta]);
        $cantidadRetenciones = (clone $retencionesB)->count();
        $alimentosProcesadosSi = (clone $declaracionesB)->where('alimentos_procesados', 'S')->count();
        $alimentosProcesadosNo = (clone $declaracionesB)->where('alimentos_procesados', 'N')->count();
        $lugaresConcentracionSi = (clone $declaracionesB)->where('lugares_concentracion', 'S')->count();
        $lugaresConcentracionNo = (clone $declaracionesB)->where('lugares_concentracion', 'N')->count();
        $equiposCampamentoSi = (clone $declaracionesB)->where('equipos_campamento', 'S')->count();
        $equiposCampamentoNo = (clone $declaracionesB)->where('equipos_campamento', 'N')->count();
        $top10 = ProductoRetenido::whereHas('retencion', function ($query) use ($desde, $hasta) {
            $query->active()->whereBetween('fecha', [$desde, $hasta]);
        })->selectRaw('sum(cantidad) as conteo, producto_id')->with('producto')->groupBy('producto_id')->take(10)->get()
            ->transform(function ($item) {
                return [
                    $item->producto->descripcion, $item->conteo
                ];
            });
        return [
            'registrosTotales' => [
                ['Declaraciones Juramentadas', $cantidadDeclaraciones],
                ['Retenciones/Rechazos', $cantidadRetenciones]
            ],
            'alimentosProcesados' => [
                ['Sí', $alimentosProcesadosSi],
                ['No', $alimentosProcesadosNo]
            ],
            'lugaresConcentracion' => [
                ['Sí', $lugaresConcentracionSi],
                ['No', $lugaresConcentracionNo]
            ],
            'equiposCampamento' => [
                ['Sí', $equiposCampamentoSi],
                ['No', $equiposCampamentoNo]
            ],
            'top10' => $top10
        ];
    }
}
