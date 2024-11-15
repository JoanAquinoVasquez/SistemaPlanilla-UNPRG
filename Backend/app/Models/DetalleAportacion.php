<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleAportacion extends Model
{
    use HasFactory;

    // Campos rellenables
    protected $fillable = [
        'empleado_tipo_id',
        'remuneracion_id',
        'aportacions_id',
        'monto'
    ];

    /**
     * Relación muchos a uno con EmpleadoTipo.
     * Un DetalleAportacion pertenece a un EmpleadoTipo.
     */
    public function empleadoTipo()
    {
        return $this->belongsTo(EmpleadoTipo::class);
    }

    /**
     * Relación muchos a uno con Aportacion.
     * Un DetalleAportacion pertenece a una Aportacion.
     */
    public function aportacion()
    {
        return $this->belongsTo(Aportacion::class);
    }

    /**
     * Relación muchos a uno con Remuneracion.
     * Un DetalleAportacion pertenece a una Remuneracion.
     */
    public function remuneracion()
    {
        return $this->belongsTo(Remuneracion::class);
    }
}
