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
        'empleado_tipo_num_doc_iden',
        'sueldo_bruto',
        'total_ingreso',
        'total_egreso',
        'sueldo_aporte',
        'sueldo_neto',
    ];

    /**
     * Relación muchos a uno con Planilla.
     * Una Remuneracion pertenece a una Planilla.
     */
    public function planilla()
    {
        return $this->belongsTo(Planilla::class, 'planilla_id');
    }

    /**
     * Relación muchos a uno con EmpleadoTipo.
     * Una Remuneracion pertenece a un EmpleadoTipo específico.
     */
    public function empleadoTipo()
    {
        return $this->belongsTo(EmpleadoTipo::class, 'empleado_tipo_id', 'id_tipo_empleado')
            ->where('empleado_tipo_num_doc_iden', 'num_doc_iden');
    }

    /**
     * Relación uno a muchos con DetalleAportacion.
     * Una Remuneracion puede tener múltiples DetalleAportacion.
     */
    public function detalleAportaciones()
    {
        return $this->hasMany(DetalleAportacion::class, 'remuneracion_id');
    }

    /**
     * Relación uno a muchos con DetalleEgreso.
     * Una Remuneracion puede tener múltiples DetalleEgreso.
     */
    public function detallesEgreso()
    {
        return $this->hasMany(DetalleEgreso::class, 'remuneracion_id');
    }

    /**
     * Relación uno a muchos con DetalleIngreso.
     * Una Remuneracion puede tener múltiples DetalleIngreso.
     */
    public function detallesIngreso()
    {
        return $this->hasMany(DetalleIngreso::class, 'remuneracion_id');
    }
}
