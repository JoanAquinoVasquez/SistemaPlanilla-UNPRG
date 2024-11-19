<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubTipoEmpleado extends Model
{
    /** @use HasFactory<\Database\Factories\SubTipoEmpleadoFactory> */
    use HasFactory;

    protected $fillable = [
        'tipo_empleado_id',
        'nombre',
        'descripcion',
        'estado'
    ];

    // Ocultar los campos created_at y updated_at
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Relación muchos a uno con TipoEmpleado.
     * Un SubTipoEmpleado pertenece a un TipoEmpleado.
     */
    public function tipoEmpleado()
    {
        return $this->belongsTo(TipoEmpleado::class, 'tipo_empleado_id');
    }

    /**
     * Relación uno a muchos con CategoriaEmpleado.
     * Un SubTipoEmpleado puede tener muchas CategoriaEmpleado.
     */
    public function categorias()
    {
        return $this->hasMany(CategoriaEmpleado::class, 'sub_tipo_empleado_id');
    }

    public function empleadoTipos()
    {
        return $this->hasMany(EmpleadoTipo::class);
    }
}
