<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormulaParametro extends Model
{
    /** @use HasFactory<\Database\Factories\FormulaParametroFactory> */
    use HasFactory;
    
    protected $fillable = ['formula_id', 'parametro_id', 'operacion'];

    public function formula()
    {
        return $this->belongsTo(Formula::class);
    }

    public function parametro()
    {
        return $this->belongsTo(Parametro::class);
    }
}
