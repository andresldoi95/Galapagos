<?php

namespace App\Http\Controllers;

use App\Producto;
use Illuminate\Pagination\Paginator;
use Illuminate\Http\Request;
use DB;

class ProductoApiController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'categoria' => 'nullable'
        ]);
        $sortBy = $request->input('sort_by');
        $status = $request->input('status');
        $search = $request->input('search');
        $categoria = $request->input('categoria');
        $currentPage = $request->input('current_page');
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });
        $user = $request->user();
        $productos = Producto::current($user->empresa_id)->where(function ($query) use ($search) {
            return $query->where('descripcion', 'like', "%$search%")->orWhere('descripcion', 'like', "%$search%");
        });
        if ($status !== 'T')
            $productos->where('estado', $status);
        if (isset($sortBy) && $sortBy !== '')
            $productos->orderBy($sortBy, $request->input('sort_order'));
        if (isset($categoria) && $categoria !== 'T')
            $productos->where('categoria', $categoria);
        return $productos->paginate($request->input('per_page'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|max:40|unique:productos',
            'descripcion' => 'required|max:255',
            'categoria' => 'required|max:2',
            'foto' => 'nullable|image',
            'informacion_adicional' => 'nullable'
        ]);
        DB::transaction(function () use ($request) {
            $user = $request->user();
            Producto::create([
                'codigo' => $request->input('codigo'),
                'descripcion' => $request->input('descripcion'),
                'categoria' => $request->input('categoria'),
                'creador_id' => $user->id,
                'empresa_id' => $user->empresa_id,
                'informacion_adicional' => $request->input('informacion_adicional'),
                'path_foto' => $request->hasFile('foto') ? $request->file('foto')->storeAs('/productos', $request->input('codigo') . '-' . date('YmdHis') . '.' . $request->file('foto')->extension()) : null
            ]);
        });
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'descripcion' => 'required|max:255',
            'categoria' => 'required|max:2',
            'informacion_adicional' => 'nullable',
            'foto' => 'nullable|image',
        ]);
        DB::transaction(function () use ($request, $id) {
            $user = $request->user();
            $producto = Producto::findOrFail($id);
            $producto->descripcion = $request->input('descripcion');
            $producto->categoria = $request->input('categoria');
            $producto->modificador_id = $user->id;
            $producto->informacion_adicional = $request->input('informacion_adicional');
            if ($request->hasFile('foto')) {
                $producto->path_foto = $request->file('foto')->storeAs('/productos', $request->input('codigo') . '-' . date('YmdHis') . '.' . $request->file('foto')->extension());
            }
            $producto->save();
        });
    }
    public function destroy(Request $request)
    {
        $request->validate([
            'productos' => 'required|array'
        ]);
        $user = $request->user();
        $productos = $request->input('productos');
        Producto::whereIn('id', $productos)
            ->update([
                'estado' => DB::raw('if(estado = "A", "I", "A")'),
                'modificador_id' => $user->id
            ]);
    }
    public function search(Request $request)
    {
        $request->validate([
            'search' => 'nullable'
        ]);
        $search = $request->input('search');
        $productos = Producto::active()->orderBy('descripcion')->where(function ($query) use ($search) {
            return $query->where('descripcion', 'like', "%$search%")->orWhere('codigo', 'like', "%$search%");
        })->select(['id', 'descripcion', 'categoria', 'path_foto', 'codigo'])->get();
        return $productos;
    }
}
