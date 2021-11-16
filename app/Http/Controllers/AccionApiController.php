<?php

namespace App\Http\Controllers;

use App\Accion;
use Illuminate\Http\Request;

class AccionApiController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        if ($user->empresa !== null) {
            return Accion::orderBy('descripcion')->whereIn('modulo_id', $user->empresa->modulos->pluck('id')->all())->get();
        } else
            return Accion::orderBy('descripcion')->get();
    }
}
