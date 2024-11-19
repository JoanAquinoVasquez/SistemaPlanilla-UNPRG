<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEmpleado extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'estado'
    ];

    // Ocultar los campos created_at y updated_at
    protected $hidden = ['created_at', 'updated_at'];

    public function subTipoEmpleado()
    {
        return $this->hasMany(SubTipoEmpleado::class, 'tipo_empleado_id');
    }

    /**
     * Relación muchos a muchos con Empleado a través de EmpleadoTipo.
     * Un TipoEmpleado puede asociarse a varios Empleados.
     */
    public function empleados()
    {
        return $this->belongsToMany(Empleado::class, 'empleado_tipos', 'tipo_empleado_id', 'empleado_num_doc_iden')
            ->withPivot('aportacion_id', 'banco_id', 'tipo_cuenta', 'cci', 'numero_cuenta', 'estado')
            ->withTimestamps();
    }
}
