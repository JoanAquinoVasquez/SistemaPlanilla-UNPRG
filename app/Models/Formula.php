<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formula extends Model
{
    /** @use HasFactory<\Database\Factories\FormulaFactory> */
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion', 'estado'];

    public function formulaParametros()
    {
        return $this->hasMany(FormulaParametro::class);
    }
}
