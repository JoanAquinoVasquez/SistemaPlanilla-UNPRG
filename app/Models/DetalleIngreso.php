<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleIngreso extends Model
{
    use HasFactory;

    // Campos rellenables
    protected $fillable = [
        'empleado_tipo_id',
        'remuneracion_id',
        'ingreso_id',
        'monto'
    ];

    /**
     * Relación muchos a uno con Aportacion.
     * Un DetalleIngreso pertenece a una Aportacion.
     */
    public function ingresos()
    {
        return $this->belongsTo(Ingreso::class);
    }

    /**
     * Relación muchos a uno con Remuneracion.
     * Un DetalleIngreso pertenece a una Remuneracion.
     */
    public function remuneracion()
    {
        return $this->belongsTo(Remuneracion::class);
    }

    /**
     * Relación muchos a uno con EmpleadoTipo.
     * Un DetalleIngreso pertenece a un EmpleadoTipo.
     */
    public function empleadoTipo()
    {
        return $this->belongsTo(EmpleadoTipo::class);
    }
}
