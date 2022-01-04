<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rol;

class RolApiController extends Controller
{
    public function listado(Request $request)
    {
        $user = $request->user();
        return Rol::active()->orderBy('nombre')->current($user->empresa_id)->get();
    }
    public function index(Request $request)
    {
        $user = $request->user();
        $status = $request->input('status');
        $search = $request->input('search');
        return Rol::with('acciones')->where('empresa_id', $user->empresa_id)->orderBy('nombre')
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
            'descripcion' => 'required|max:500',
            'acciones' => 'nullable|array'
        ]);
        $user = $request->user();
        $rol = Rol::create([
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
            'creador_id' => $user->id,
            'empresa_id' => $user->empresa_id
        ]);
        $acciones = $request->input('acciones');
        if (isset($acciones))
            $rol->acciones()->sync($acciones);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'descripcion' => 'nullable|max:500'
        ]);
        $rol = Rol::findOrFail($id);
        $rol->nombre = $request->input('nombre');
        $rol->descripcion = $request->input('descripcion');
        $rol->modificador_id = $request->user()->id;
        $rol->save();
        $acciones = $request->input('acciones');
        if (isset($acciones))
            $rol->acciones()->sync($acciones);
        else
            $rol->acciones()->dettach();
    }
    public function destroy(Request $request)
    {
        $request->validate([
            'roles' => 'required|array'
        ]);
        $roles = $request->input('roles');
        $user = $request->user();
        Rol::whereIn('id', $roles)
            ->update([
                'estado' => DB::raw('if(estado = "A", "I", "A")'),
                'modificador_id' => $user->id
            ]);
    }
}
