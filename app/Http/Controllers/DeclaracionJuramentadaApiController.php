<?php

namespace App\Http\Controllers;

use App\DeclaracionJuramentada;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class DeclaracionJuramentadaApiController extends Controller
{
    public function index(Request $request)
    {
        $sortBy = $request->input('sort_by');
        $status = $request->input('status');
        $search = $request->input('search');
        $currentPage = $request->input('current_page');
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });
        $declaraciones = DeclaracionJuramentada::where(function ($query) use ($search) {
            return $query->where('numero_identificacion', $search)->orWhere('codigo', 'like', "%$search%");
        })->with('productos');
        if (isset($sortBy) && $sortBy !== '')
            $declaraciones->orderBy($sortBy, $request->input('sort_order'));
        if ($status !== 'T')
            $declaraciones->where('estado', $status);
        return $declaraciones->paginate($request->input('per_page'));
    }
    private function obtenerCodigoAutogenerado()
    {
        $today = date('Ymd');
        $ultimaDeclaracion = DeclaracionJuramentada::where('codigo', 'like', "$today%")->orderByRaw('cast(codigo as unsigned) desc')
            ->first();
        if (isset($ultimaDeclaracion)) {
            $codigo = intval($ultimaDeclaracion->codigo) + 1;
        } else
            $codigo = $today . 1;
        return $codigo;
    }
    public function destroy(Request $request)
    {
        $request->validate([
            'declaraciones' => 'required|array',
            'estado' => 'required|max:1'
        ]);
        $user = $request->user();
        $declaraciones = $request->input('declaraciones');
        DeclaracionJuramentada::whereIn('id', $declaraciones)
            ->update([
                'estado' =>
                DB::raw('if(estado = "A", "I", "A")'),
                'usuario_id' => $user->id
            ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'apellidos' => 'required|max:255',
            'nombres' => 'required|max:255',
            'numero_identificacion' => 'required|max:20',
            'telefono' => 'nullable|max:100',
            'correo_electronico' => 'nullable|max:500',
            'lugar_residencia' => 'required|max:255',
            'nacionalidad' => 'required|max:255',
            'direccion_domicilio' => 'required|max:300',
            'linea_aerea' => 'required|max:255',
            'numero_vuelo' => 'required|max:50',
            'aeropuerto_origen' => 'required|max:255',
            'alimentos_procesados' => 'nullable',
            'lugares_concentracion' => 'nullable',
            'equipos_campamento' => 'nullable',
            'fecha' => 'required|date',
            'productos' => 'nullable|array'
        ]);
        return DB::transaction(function () use ($request) {
            $declaracionJuramentada = DeclaracionJuramentada::create([
                'id' => uniqid('d' . date('ymdHis'), true),
                'codigo' => $this->obtenerCodigoAutogenerado(),
                'apellidos' => $request->input('apellidos'),
                'nombres' => $request->input('nombres'),
                'numero_identificacion' => $request->input('numero_identificacion'),
                'telefono' => $request->input('telefono'),
                'correo_electronico' => $request->input('correo_electronico'),
                'lugar_residencia' => $request->input('lugar_residencia'),
                'nacionalidad' => $request->input('nacionalidad'),
                'direccion_domicilio' => $request->input('direccion_domicilio'),
                'linea_aerea' => $request->input('linea_aerea'),
                'numero_vuelo' => $request->input('numero_vuelo'),
                'aeropuerto_origen' => $request->input('aeropuerto_origen'),
                'alimentos_procesados' => $request->input('alimentos_procesados'),
                'lugares_concentracion' => $request->input('lugares_concentracion'),
                'equipos_campamento' => $request->input('equipos_campamento'),
                'fecha' => new Carbon($request->input('fecha')),
                'estado' => 'A'
            ]);
            $productos = $request->input('productos');
            if (isset($productos)) {
                foreach ($productos as $producto) {
                    $declaracionJuramentada->productos()->attach($producto['id']);
                }
            }
            return $declaracionJuramentada;
        });
    }
    public function show($numeroDeclaracion)
    {
        return DeclaracionJuramentada::active()->where(function ($query) use ($numeroDeclaracion) {
            return $query->where('numero_identificacion', $numeroDeclaracion)->orWhere('id', $numeroDeclaracion);
        })->with('productos')->orderBy('fecha', 'desc')->firstOrFail();
    }
}
