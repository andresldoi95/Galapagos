<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'roles';
    protected $fillable = [
        'nombre', 'descripcion', 'estado', 'creador_id', 'modificador_id', 'empresa_id'
    ];
    public function empresa()
    {
        return $this->belongsTo('App\Empresa');
    }
    public function acciones()
    {
        return $this->belongsToMany('App\Accion', 'permisos', 'rol_id', 'accion_id');
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
    public function scopeCurrent($query, $empresaId)
    {
        return $query->where('empresa_id', $empresaId);
    }
}
