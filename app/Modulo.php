<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    protected $fillable = [
        'id', 'nombre', 'estado'
    ];
    public function scopeActive($query)
    {
        return $query->where('estado', 'A');
    }
    public $incrementing = false;
}
