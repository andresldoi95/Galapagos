<?php

namespace App\Http\Controllers;

use App\Modulo;
use Illuminate\Http\Request;

class ModuloApiController extends Controller
{
    public function index()
    {
        return Modulo::active()->orderBy('nombre')->get();
    }
}
