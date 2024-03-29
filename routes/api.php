<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:api'], function () {
    Route::group(['prefix' => 'usuario'], function () {
        Route::put('/{empresaId}', 'UsuarioApiController@cambiarEmpresaActual');
        Route::delete('/', 'UsuarioApiController@destroy');
        Route::post('/perfil', 'UsuarioApiController@perfil');
        Route::get('/datos', 'UsuarioApiController@datos');
    });
    Route::group(['prefix' => 'usuarios'], function () {
        Route::get('/', 'UsuarioApiController@search');
    });
    Route::resource('usuario', 'UsuarioApiController', [
        'except' => [
            'create', 'edit'
        ]
    ]);
    Route::resource('empresas', 'EmpresaApiController', [
        'except' => [
            'create', 'edit'
        ]
    ]);
    Route::group(['prefix' => 'empresas'], function () {
        Route::delete('/', 'EmpresaApiController@destroy');
    });

    Route::group(['prefix' => 'roles'], function () {
        Route::get('/listado', 'RolApiController@listado');
    });

    Route::resource('roles', 'RolApiController', [
        'except' => [
            'create', 'edit', 'show'
        ]
    ]);
    Route::group(['prefix' => 'roles'], function () {
        Route::delete('/', 'RolApiController@destroy');
    });

    Route::get('modulos', 'ModuloApiController@index');

    Route::get('acciones', 'AccionApiController@index');
    Route::group(['prefix' => 'declaraciones-juramentadas'], function () {
        Route::get('/', 'DeclaracionJuramentadaApiController@index');
        Route::delete('/', 'DeclaracionJuramentadaApiController@destroy');
        Route::get('/{numeroDeclaracion}', 'DeclaracionJuramentadaApiController@show');
    });
    Route::group(['prefix' => 'producto'], function () {
        Route::delete('/', 'ProductoApiController@destroy');
    });

    Route::resource('productos', 'ProductoApiController', [
        'except' => ['create', 'edit', 'show', 'destroy', 'index']
    ]);
    Route::prefix('registro-retencion')->group(function () {
        Route::delete('/', 'RegistroRetencionController@destroy');
        Route::get('/datos', 'RegistroRetencionController@cargarDatos');
    });
    Route::resource('registro-retencion', 'RegistroRetencionController', [
        'only' => ['index', 'store', 'update']
    ]);
    Route::get('dashboard', 'DashboardApiController@index');
});

Route::post('/reset', 'UsuarioApiController@reset');
Route::post('/set-password', 'UsuarioApiController@setPassword');
Route::post('/declaracion-juramentada', 'DeclaracionJuramentadaApiController@store');
Route::get('/productos', 'ProductoApiController@index');
Route::group(['prefix' => 'productos'], function () {
    Route::get('/search', 'ProductoApiController@search');
});
