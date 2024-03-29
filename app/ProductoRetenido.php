<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductoRetenido extends Model
{
    protected $table = 'productos_retenidos';
    protected $fillable = [
        'id', 'retencion_id', 'producto_id', 'cantidad', 'peso', 'categoria',
        'razon_retencion', 'destino_producto', 'transportado_en', 'observacion', 'unidad'
    ];
    public $incrementing = false;
    public function producto()
    {
        return $this->belongsTo('App\Producto');
    }
    public function retencion()
    {
        return $this->belongsTo('App\RegistroRetencion');
    }
}
