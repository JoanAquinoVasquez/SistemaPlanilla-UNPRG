<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'oficina',
        'unidad',
        'facultad',
        'escuela',
        'estado'
    ];

    // Ocultar los campos created_at y updated_at
    protected $hidden = ['created_at', 'updated_at'];

    // Relación muchos a muchos con el modelo EmpleadoTipo a través de area_empleado_tipos
    public function empleadoTipos()
    {
        return $this->belongsToMany(EmpleadoTipo::class, 'area_empleado_tipos')
            ->withPivot('estado') // Incluye el campo adicional 'estado' de la tabla pivot
            ->withTimestamps();   // Incluye timestamps en la relación pivot
    }
    
}
