<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $fillable = [
        'afiliado_id',
        'clinica_id',
        'created_by',

        'fecha_cita',
        'hora_cita',
    ];

    public function afiliado()
    {
        return $this->belongsTo(User::class, 'afiliado_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function clinica()
    {
        return $this->belongsTo(Clinica::class);
    }
}
