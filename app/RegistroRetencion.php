<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistroRetencion extends Model
{
    protected $table = 'registro_retenciones';
    protected $dates = [
        'fecha'
    ];
    protected $fillable = [
        'id', 'empresa_id', 'lugar', 'tipo_transporte', 'nombre_transporte', 'destino',
        'procedencia', 'numero_documento', 'fecha', 'retencion', 'rechazo',
        'inspeccion_origen', 'inspector_responsable', 'fecha_inspeccion',
        'numero_guia_sanitaria', 'numero_candado', 'nombre_completo', 'direccion',
        'numero_identificacion', 'tipo_residencia', 'observaciones', 'numero_guia_transporte',
        'porcentaje_mal_estado', 'porcentaje_plagados', 'retencion_patio', 'nombre_inspector_responsable',
        'identificacion_inspector_responsable', 'nombre_testigo', 'identificacion_testigo',
        'creador_id', 'modificador_id', 'estado'
    ];
    public $incrementing = false;
    public function creador()
    {
        return $this->belongsTo('App\User');
    }
    public function modificador()
    {
        return $this->belongsTo('App\User');
    }
    public function productos()
    {
        return $this->hasMany('App\ProductoRetenido', 'retencion_id');
    }
}
