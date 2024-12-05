<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aportacion extends Model
{
    use HasFactory;

    // Campos rellenables
    protected $fillable = [
        'formula_parametro_id',
        'concepto',
        'sujeto_ley',
    ];

    // Ocultar los campos created_at y updated_at
    protected $hidden = ['created_at', 'updated_at'];
    
    /**
     * Relación uno a uno con FormulaParametro.
     * Un Egreso pertenece a un FormulaParametro.
     */
    public function formulaParametro()
    {
        return $this->belongsTo(FormulaParametro::class, 'formula_parametro_id');
    }

    /**
     * Relación uno a muchos con DetalleAportacion.
     * Una Aportacion puede tener múltiples DetalleAportacion.
     */
    public function detalleAportaciones()
    {
        return $this->hasMany(DetalleAportacion::class, 'aportacion_id');
    }

    /**
     * Relación uno a muchos con DetalleEgreso.
     * Una Aportacion puede tener múltiples DetalleEgreso.
     */
    public function detallesEgresos()
    {
        return $this->hasMany(DetalleEgreso::class, 'aportacions_id');
    }

    /**
     * Relación uno a muchos con DetalleIngreso.
     * Una Aportacion puede tener múltiples DetalleIngreso.
     */
    public function detallesIngresos()
    {
        return $this->hasMany(DetalleIngreso::class, 'aportacions_id');
    }


    // Definimos la relación uno a uno con EmpleadoTipo
    /* public function empleadoTipo()
    {
        return $this->hasOne(EmpleadoTipo::class, 'aportacion_id');
    } */
}
