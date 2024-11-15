<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remuneracion extends Model
{
    use HasFactory;

    // Campos rellenables
    protected $fillable = [
        'planilla_id',
        'empleado_tipo_id',
        'sueldo_bruto',
        'total_ingreso',
        'total_egreso',
        'sueldo_aporte',
        'sueldo_neto'
    ];

    /**
     * Relación muchos a uno con EmpleadoTipo.
     * Una Remuneracion pertenece a un EmpleadoTipo específico.
     */
    public function empleadoTipo()
    {
        return $this->belongsTo(EmpleadoTipo::class);
    }

    /**
     * Relación muchos a uno con Planilla.
     * Una Remuneracion pertenece a una Planilla.
     */
    public function planilla()
    {
        return $this->belongsTo(Planilla::class);
    }

    /**
     * Relación uno a muchos con DetalleAportacion.
     * Una Remuneracion puede tener múltiples DetalleAportacion.
     */
    public function detalleAportaciones()
    {
        return $this->hasMany(DetalleAportacion::class);
    }

    /**
     * Relación uno a muchos con DetalleEgreso.
     * Una Remuneracion puede tener múltiples DetalleEgreso.
     */
    public function detallesEgreso()
    {
        return $this->hasMany(DetalleEgreso::class);
    }

    /**
     * Relación uno a muchos con DetalleIngreso.
     * Una Remuneracion puede tener múltiples DetalleIngreso.
     */
    public function detallesIngreso()
    {
        return $this->hasMany(DetalleIngreso::class);
    }
}
