<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $fillable = [
        'nombre', 'descripcion', 'estado', 'creador_id', 'modificador_id'
    ];
    public function modulos()
    {
        return $this->belongsToMany('App\Modulo', 'modulos_empresa', 'empresa_id', 'modulo_id');
    }
    public function creador()
    {
        return $this->belongsTo('App\User');
    }
    public function modificador()
    {
        return $this->belongsTo('App\User');
    }
    public function scopeActive($query)
    {
        return $query->where('estado', 'A');
    }
}
