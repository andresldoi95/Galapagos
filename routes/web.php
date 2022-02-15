<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'exportar'], function () {
    Route::get('declaraciones-juramentadas', 'DeclaracionJuramentadaController@index');
    Route::get('retenciones', 'RegistroRetencionController@excel');
});
Route::any('/{any}', function () {
    return view('welcome');
})->where('any', '.*');
