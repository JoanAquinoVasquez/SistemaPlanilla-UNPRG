<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parametro extends Model
{
    /** @use HasFactory<\Database\Factories\ParametroFactory> */
    use HasFactory;

    // Agrega los campos que permiten asignación masiva
    protected $fillable = ['nombre', 'valor'];

    public function documento()
    {
        return $this->belongsTo(Documento::class);
    }

    public function formulaParametros()
    {
        return $this->hasMany(FormulaParametro::class);
    }
}
