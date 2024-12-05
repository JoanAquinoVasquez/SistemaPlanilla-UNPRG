<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parametro extends Model
{
    /** @use HasFactory<\Database\Factories\ParametroFactory> */
    use HasFactory;

    // Campos rellenables
    protected $fillable = [
        'nombre',
        'valor',
        'documento_id',
        'estado',
    ];

    /**
     * Relación muchos a uno con Documento.
     * Un Parametro pertenece a un Documento.
     */
    public function documento()
    {
        return $this->belongsTo(Documento::class);
    }

    public function formulaParametros()
    {
        return $this->hasMany(FormulaParametro::class);
    } 
    
}
