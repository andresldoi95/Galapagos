<?php

namespace App\Http\Controllers;

use App\RegistroRetencion;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistroRetencionController extends Controller
{
    private function obtenerNumeroDocumento()
    {
        $ultimoRegistro = RegistroRetencion::orderByRaw('cast(numero_documento as unsigned) desc')->select(['numero_documento'])->first();
        if (isset($ultimoRegistro))
            $numeroDocumento = intval($ultimoRegistro->numero_documento) + 1;
        else
            $numeroDocumento = 1;
        return str_pad($numeroDocumento, 8, '0', STR_PAD_LEFT);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'lugar' => 'required|max:2',
            'tipo_transporte' => 'required|max:2',
            'nombre_transporte' => 'required|max:500',
            'destino' => 'required|max:255',
            'procedencia' => 'required|max:255',
            'fecha' => 'required|date',
            'retencion' => 'nullable',
            'rechazo' => 'nullable',
            'inspeccion_origen' => 'required|max:1',
            'inspector_responsable' => 'nullable|max:255|required_if:inspeccion_origen,S',
            'fecha_inspeccion' => 'nullable|required_if:inspeccion_origen,S|date',
            'numero_guia_sanitaria' => 'nullable|max:50',
            'numero_candado' => 'nullable|max:255',
            'nombre_completo' => 'required|max:500',
            'direccion' => 'required|max:255',
            'numero_identificacion' => 'required|max:20',
            'tipo_residencia' => 'required|max:1',
            'observaciones' => 'nullable|max:500',
            'numero_guia_transporte' => 'nullable|max:50',
            'porcentaje_mal_estado' => 'required|numeric',
            'porcentaje_plagados' => 'required|numeric',
            'retencion_patio' => 'required|max:1',
            'nombre_inspector_responsable' => 'required|max:500',
            'identificacion_inspector_responsable' => 'required|max:20',
            'nombre_testigo' => 'required|max:500',
            'identificacion_testigo' => 'required|max:20',
            'productos' => 'required|array'
        ]);
        DB::transaction(function () use ($id, $request) {
            $registroRetencion = RegistroRetencion::findOrFail($id);
            $registroRetencion->lugar = $request->input('lugar');
            $registroRetencion->tipo_transporte = $request->input('tipo_transporte');
            $registroRetencion->nombre_transporte = $request->input('nombre_transporte');
            $registroRetencion->destino = $request->input('destino');
            $registroRetencion->procedencia = $request->input('procedencia');
            $registroRetencion->fecha = new Carbon($request->input('fecha'));
            $registroRetencion->retencion = $request->input('retencion') ? 'S' : 'N';
            $registroRetencion->rechazo = $request->input('rechazo') ? 'S' : 'N';
            $registroRetencion->inspeccion_origen = $request->input('inspeccion_origen');
            $registroRetencion->inspector_responsable = $request->input('inspector_responsable');
            $registroRetencion->fecha_inspeccion = new Carbon($request->input('fecha_inspeccion'));
            $registroRetencion->numero_guia_sanitaria = $request->input('numero_guia_sanitaria');
            $registroRetencion->numero_candado = $request->input('numero_candado');
            $registroRetencion->nombre_completo = $request->input('nombre_completo');
            $registroRetencion->direccion = $request->input('direccion');
            $registroRetencion->numero_identificacion = $request->input('numero_identificacion');
            $registroRetencion->tipo_residencia = $request->input('tipo_residencia');
            $registroRetencion->observaciones = $request->input('observaciones');
            $registroRetencion->numero_guia_transporte = $request->input('numero_guia_transporte');
            $registroRetencion->porcentaje_mal_estado = $request->input('porcentaje_mal_estado');
            $registroRetencion->porcentaje_plagados = $request->input('porcentaje_plagados');
            $registroRetencion->retencion_patio = $request->input('retencion_patio');
            $registroRetencion->nombre_inspector_responsable = $request->input('nombre_inspector_responsable');
            $registroRetencion->identificacion_inspector_responsable = $request->input('identificacion_inspector_responsable');
            $registroRetencion->nombre_testigo = $request->input('nombre_testigo');
            $registroRetencion->identificacion_testigo = $request->input('identificacion_testigo');
            $registroRetencion->modificador_id = $request->user()->id;
            $registroRetencion->save();
            $registroRetencion->productos()->delete();
            $productos = $request->input('productos');
            foreach ($productos as $producto) {
                $registroRetencion->productos()->create([
                    'id' => uniqid('p' . date('ymdHis'), true),
                    'producto_id' => $producto['producto_id'],
                    'peso' => $producto['peso'],
                    'cantidad' => $producto['cantidad'],
                    'categoria' => $producto['categoria'],
                    'razon_retencion' => $producto['razon_retencion'],
                    'destino_producto' => $producto['destino_producto'],
                    'transportado_en' => $producto['transportado_en']
                ]);
            }
        });
    }
    public function store(Request $request)
    {
        $request->validate([
            'lugar' => 'required|max:2',
            'tipo_transporte' => 'required|max:2',
            'nombre_transporte' => 'required|max:500',
            'destino' => 'required|max:255',
            'procedencia' => 'required|max:255',
            'fecha' => 'required|date',
            'retencion' => 'nullable',
            'rechazo' => 'nullable',
            'inspeccion_origen' => 'required|max:1',
            'inspector_responsable' => 'nullable|max:255|required_if:inspeccion_origen,S',
            'fecha_inspeccion' => 'nullable|required_if:inspeccion_origen,S|date',
            'numero_guia_sanitaria' => 'nullable|max:50',
            'numero_candado' => 'nullable|max:255',
            'nombre_completo' => 'required|max:500',
            'direccion' => 'required|max:255',
            'numero_identificacion' => 'required|max:20',
            'tipo_residencia' => 'required|max:1',
            'observaciones' => 'nullable|max:500',
            'numero_guia_transporte' => 'nullable|max:50',
            'porcentaje_mal_estado' => 'required|numeric',
            'porcentaje_plagados' => 'required|numeric',
            'retencion_patio' => 'required|max:1',
            'nombre_inspector_responsable' => 'required|max:500',
            'identificacion_inspector_responsable' => 'required|max:20',
            'nombre_testigo' => 'required|max:500',
            'identificacion_testigo' => 'required|max:20',
            'productos' => 'required|array'
        ]);
        DB::transaction(function () use ($request) {
            $user = $request->user();
            $registroRetencion = RegistroRetencion::create([
                'id' => uniqid('r' . date('ymdHis'), true),
                'empresa_id' => $user->empresa_id,
                'numero_documento' => $this->obtenerNumeroDocumento(),
                'lugar' => $request->input('lugar'),
                'tipo_transporte' => $request->input('tipo_transporte'),
                'nombre_transporte' => $request->input('nombre_transporte'),
                'destino' => $request->input('destino'),
                'procedencia' => $request->input('procedencia'),
                'fecha' => new Carbon($request->input('fecha')),
                'retencion' => $request->input('retencion') ? 'S' : 'N',
                'rechazo' => $request->input('rechazo') ? 'S' : 'N',
                'inspeccion_origen' => $request->input('inspeccion_origen'),
                'inspector_responsable' => $request->input('inspector_responsable'),
                'fecha_inspeccion' => new Carbon($request->input('fecha_inspeccion')),
                'numero_guia_sanitaria' => $request->input('numero_guia_sanitaria'),
                'numero_candado' => $request->input('numero_candado'),
                'nombre_completo' => $request->input('nombre_completo'),
                'direccion' => $request->input('direccion'),
                'numero_identificacion' => $request->input('numero_identificacion'),
                'tipo_residencia' => $request->input('tipo_residencia'),
                'observaciones' => $request->input('observaciones'),
                'numero_guia_transporte' => $request->input('numero_guia_transporte'),
                'porcentaje_mal_estado' => $request->input('porcentaje_mal_estado'),
                'porcentaje_plagados' => $request->input('porcentaje_plagados'),
                'retencion_patio' => $request->input('retencion_patio'),
                'nombre_inspector_responsable' => $request->input('nombre_inspector_responsable'),
                'identificacion_inspector_responsable' => $request->input('identificacion_inspector_responsable'),
                'nombre_testigo' => $request->input('nombre_testigo'),
                'identificacion_testigo' => $request->input('identificacion_testigo'),
                'creador_id' => $user->id,
            ]);
            $productos = $request->input('productos');
            foreach ($productos as $producto) {
                $registroRetencion->productos()->create([
                    'id' => uniqid('p' . date('ymdHis'), true),
                    'producto_id' => $producto['producto_id'],
                    'peso' => $producto['peso'],
                    'cantidad' => $producto['cantidad'],
                    'categoria' => $producto['categoria'],
                    'razon_retencion' => $producto['razon_retencion'],
                    'destino_producto' => $producto['destino_producto'],
                    'transportado_en' => $producto['transportado_en']
                ]);
            }
        });
    }
    public function index(Request $request)
    {
        $sortBy = $request->input('sort_by');
        $status = $request->input('status');
        $search = $request->input('search');
        $currentPage = $request->input('current_page');
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });
        $declaraciones = RegistroRetencion::with('productos.producto')->where(function ($query) use ($search) {
            return $query->where('numero_identificacion', $search)->orWhere('numero_documento', 'like', "%$search");
        });
        if (isset($sortBy) && $sortBy !== '')
            $declaraciones->orderBy($sortBy, $request->input('sort_order'));
        if ($status !== 'T')
            $declaraciones->where('estado', $status);
        return $declaraciones->paginate($request->input('per_page'));
    }
    public function destroy(Request $request)
    {
        $request->validate([
            'retenciones' => 'required|array',
            'estado' => 'required|max:1'
        ]);
        $user = $request->user();
        $retenciones = $request->input('retenciones');
        RegistroRetencion::whereIn('id', $retenciones)
            ->update([
                'estado' =>
                DB::raw('if(estado = "A", "I", "A")'),
                'modificador_id' => $user->id
            ]);
    }
}
