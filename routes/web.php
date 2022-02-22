<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'exportar'], function () {
    Route::get('declaraciones-juramentadas', 'DeclaracionJuramentadaController@index');
    Route::get('retenciones', 'RegistroRetencionController@excel');
    Route::get('{id}/declaracion-juramentada', 'DeclaracionJuramentadaController@show')->name('declaracion-juramentada');
    Route::get('{id}/retencion', 'RegistroRetencionController@show')->name('retencion');
});
Route::any('/{any}', function () {
    return view('welcome');
})->where('any', '.*');
