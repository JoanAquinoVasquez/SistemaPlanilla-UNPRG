<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Egreso extends Model
{
    use HasFactory;
    
    // Campos rellenables
    protected $fillable = [
        'formula_parametro_id',
        'concept',
        'sujeto_ley',
    ];

    /**
     * Relación uno a uno con FormulaParametro.
     * Un Egreso pertenece a un FormulaParametro.
     */
    public function formulaParametro()
    {
        return $this->belongsTo(FormulaParametro::class, 'formula_parametro_id');
    }
}