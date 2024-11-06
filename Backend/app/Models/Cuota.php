<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuota extends Model
{
    use HasFactory;

    // Campos rellenables
    protected $fillable = [
        'prestamo_id',
        'fecha',
        'monto',
        'estado',
    ];

    /**
     * Relación muchos a uno con Prestamo.
     * Una Cuota pertenece a un Prestamo.
     */
    public function prestamo()
    {
        return $this->belongsTo(Prestamo::class, 'prestamo_id');
    }
}
