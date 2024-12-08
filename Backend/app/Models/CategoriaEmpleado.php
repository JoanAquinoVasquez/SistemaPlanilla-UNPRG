<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaEmpleado extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_tipo_empleado_id',
        'nombre',
        'descripcion',
        'estado'
    ];

    // Ocultar los campos created_at y updated_at
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Relación muchos a uno con SubTipoEmpleado.
     * Una CategoriaEmpleado pertenece a un SubTipoEmpleado.
     */
    public function subTipoEmpleado()
    {
        return $this->belongsTo(SubTipoEmpleado::class, 'sub_tipo_empleado_id');
    }

    /**
     * Relación uno a muchos con SubCategoriaEmpleado.
     * Una CategoriaEmpleado puede tener muchas SubCategoriaEmpleado.
     */
    public function subCategorias()
    {
        return $this->hasMany(SubCategoriaEmpleado::class, 'categoria_empleado_id');
    }

    public function empleadoTipos()
    {
        return $this->hasMany(EmpleadoTipo::class);
    }
}
