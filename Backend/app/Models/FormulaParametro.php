<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormulaParametro extends Model
{
    /** @use HasFactory<\Database\Factories\FormulaParametroFactory> */
    use HasFactory;

    protected $fillable = [
        'formula_id',
        'parametro_id',
        'operacion',
        'estado',
    ];

    public function formula()
    {
        return $this->belongsTo(Formula::class);
    }

    public function parametro()
    {
        return $this->belongsTo(Parametro::class);
    }

    /**
     * Relación uno a uno con Egreso.
     * Un FormulaParametro tiene un Egreso asociado.
     */
    public function egreso()
    {
        return $this->hasOne(Egreso::class, 'formula_parametro_id');
    }

    /**
     * Relación uno a uno con Ingreso.
     * Un FormulaParametro tiene un Ingreso asociado.
     */
    public function ingreso()
    {
        return $this->hasOne(Ingreso::class, 'formula_parametro_id');
    }

    /**
     * Relación uno a uno con Egreso.
     * Un FormulaParametro tiene una Aportacion asociado.
     */
    public function aportacion()
    {
        return $this->hasOne(Aportacion::class, 'formula_parametro_id');
    }

}
