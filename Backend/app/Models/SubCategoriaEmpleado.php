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
        'estado'
    ];

    // Ocultar los campos created_at y updated_at
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Relación muchos a uno con CategoriaEmpleado.
     * Una SubCategoriaEmpleado pertenece a una CategoriaEmpleado.
     */
    // Relación muchos a uno: Una SubCategoriaEmpleado pertenece a una CategoriaEmpleado
    public function categoriaEmpleado()
    {
        return $this->belongsTo(CategoriaEmpleado::class, 'id_categoria');
    }
}
