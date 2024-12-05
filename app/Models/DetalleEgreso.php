<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleEgreso extends Model
{
    use HasFactory;

    // Campos rellenables
    protected $fillable = [
        'empleado_tipo_id',
        'remuneracion_id',
        'egreso_id',
        'monto'
    ];

    /**
     * Relación muchos a uno con Aportacion.
     * Un DetalleEgreso pertenece a una Aportacion.
     */
    public function egresos()
    {
        return $this->belongsTo(Egreso::class);
    }

    /**
     * Relación muchos a uno con Remuneracion.
     * Un DetalleEgreso pertenece a una Remuneracion.
     */
    public function remuneracion()
    {
        return $this->belongsTo(Remuneracion::class);
    }

    /**
     * Relación muchos a uno con EmpleadoTipo.
     * Un DetalleEgreso pertenece a un EmpleadoTipo.
     */
    public function empleadoTipo()
    {
        return $this->belongsTo(EmpleadoTipo::class);
    }
}
