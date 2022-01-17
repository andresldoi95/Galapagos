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
    public function scopeActive($query)
    {
        return $query->where('estado', 'A');
    }
    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'productos_declaracion', 'declaracion_id', 'producto_id');
    }
    protected $dates = [
        'fecha'
    ];
    public $incrementing = false;
}
