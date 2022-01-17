<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $appends = [
        'url_foto'
    ];
    public function getUrlFotoAttribute()
    {
        $path_foto = $this->path_foto;
        if (isset($path_foto))
            return url('/storage/' . $this->path_foto);
        else
            return null;
    }
    protected $fillable = [
        'codigo', 'descripcion', 'path_foto', 'categoria', 'estado',
        'creador_id', 'modificador_id', 'empresa_id', 'informacion_adicional'
    ];
    public function empresa()
    {
        return $this->belongsTo('App\Empresa');
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
