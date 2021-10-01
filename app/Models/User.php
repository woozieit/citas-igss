<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ADMIN = 'Admin';
    const AFILIADO = 'Afiliado';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'nombres_apellidos',
        'dpi',
        'correo',
        'direccion',
        'rol',
        'telefono',
        'acreditacion',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function scopeAfiliados( $query )
    {
        return $query->where('rol', 'Afiliado')->where('acreditacion', true);
    }


}
