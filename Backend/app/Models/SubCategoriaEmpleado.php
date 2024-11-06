<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategoriaEmpleado extends Model
{
    use HasFactory;

    protected $fillable = [
        'categoria_empleado_id',
        'nombre',
        'descripcion',
    ];

    /**
     * Relación muchos a uno con CategoriaEmpleado.
     * Una SubCategoriaEmpleado pertenece a una CategoriaEmpleado.
     */
    public function categoriaEmpleado()
    {
        return $this->belongsTo(CategoriaEmpleado::class, 'categoria_empleado_id');
    }
}
