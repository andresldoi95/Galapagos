<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class DeclaracionJuramentada extends Model
{
    protected $table = 'declaraciones_juramentadas';
    protected $fillable = [
        'id', 'apellidos', 'nombres', 'numero_identificacion',
        'telefono', 'correo_electronico', 'lugar_residencia',
        'nacionalidad', 'direccion_domicilio', 'linea_aerea',
        'numero_vuelo', 'aeropuerto_origen', 'alimentos_procesados',
        'lugares_concentracion', 'equipos_campamento', 'fecha',
        'codigo', 'estado', 'usuario_id'
    ];
    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
    protected $dates = [
        'fecha'
    ];
    public $incrementing = false;
}
