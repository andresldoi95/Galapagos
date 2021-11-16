<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'es_superadmin', 'creador_id', 'modificador_id', 'estado', 'empresa_id', 'token_recuperacion'
    ];

    public function roles()
    {
        return $this->belongsToMany('App\Rol', 'privilegios', 'usuario_id', 'rol_id');
    }

    public function empresa()
    {
        return $this->belongsTo('App\Empresa')->active();
    }

    public function scopeActive($query)
    {
        return $query->where('estado', 'A');
    }
    public function creador()
    {
        return $this->belongsTo('App\User');
    }

    public function modificador()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
