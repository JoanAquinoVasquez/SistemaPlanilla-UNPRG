<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planilla extends Model
{
    use HasFactory;

    // Campos rellenables
    protected $fillable = [
        'user_id',
        'fecha_inicio',
        'fecha_fin',
        'fecha_generacion',
        'estado',
    ];

    /**
     * Relación muchos a uno con User.
     * Una Planilla pertenece a un User.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación uno a muchos con Remuneracion.
     * Una Planilla puede tener múltiples Remuneraciones.
     */
    public function remuneraciones()
    {
        return $this->hasMany(Remuneracion::class, 'planilla_id');
    }
}
