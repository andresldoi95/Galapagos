<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accion extends Model
{
    protected $fillable = [
        'id', 'descripcion', 'estado'
    ];
    public function scopeActive($query)
    {
        return $query->where('estado', 'A');
    }
    protected $table = 'acciones';
    public $incrementing = false;
}
