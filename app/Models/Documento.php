<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    // Campos rellenables
    protected $fillable = [
        'nombre',
        'tipo',
        'fecha_vigencia',
        'fecha_fin',
        'estado',
    ];

    /**
     * Relación uno a muchos con Parametro.
     * Un Documento puede tener múltiples Parametros asociados.
     */
    public function parametros()
    {
        return $this->hasMany(Parametro::class, 'documento_id');
    }
}
