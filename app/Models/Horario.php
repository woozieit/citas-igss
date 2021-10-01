<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinica_id',
        'dia_semana',
        'estado',

        'manana_inicio',
        'manana_fin',

        'tarde_inicio',
        'tarde_fin',
    ];

    public function clinica()
    {
        return $this->belongsTo(Clinica::class);
    }
}
