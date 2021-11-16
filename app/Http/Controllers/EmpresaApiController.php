<?php

namespace App\Http\Controllers;

use App\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmpresaApiController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');
        $search = $request->input('search');
        return Empresa::with('modulos')->orderBy('nombre')
            ->orderBy('descripcion')
            ->where(function ($query) use ($status) {
                if ($status !== 'T')
                    return $query->where('estado', $status);
                else
                    return $query;
            })
            ->where(function ($query) use ($search) {
                return $query->where('nombre', 'like', "%$search%")->orWhere('descripcion', 'like', "%$search%");
            })
            ->get();
    }
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'descripcion' => 'nullable|max:500',
            'modulos' => 'nullable|array'
        ]);
        $user = $request->user();
        $empresa = Empresa::create([
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
            'creador_id' => $user->id
        ]);
        $modulos = $request->input('modulos');
        if (isset($modulos))
            $empresa->modulos()->sync($modulos);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'descripcion' => 'nullable|max:500'
        ]);
        $empresa = Empresa::findOrFail($id);
        $empresa->nombre = $request->input('nombre');
        $empresa->descripcion = $request->input('descripcion');
        $empresa->modificador_id = $request->user()->id;
        $empresa->save();
        $modulos = $request->input('modulos');
        if (isset($modulos))
            $empresa->modulos()->sync($modulos);
        else
            $empresa->modulos()->dettach();
    }
    public function destroy(Request $request)
    {
        $request->validate([
            'empresas' => 'required|array'
        ]);
        $empresas = $request->input('empresas');
        Empresa::whereIn('id', $empresas)
            ->update([
                'estado' => DB::raw('if(estado = "A", "I", "A")')
            ]);
    }
}
