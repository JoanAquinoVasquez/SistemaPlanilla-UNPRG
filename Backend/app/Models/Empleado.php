<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $primaryKey = 'num_doc_iden';
    public $incrementing = false;
    protected $keyType = 'string';

    // Campos rellenables
    protected $fillable = [
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'tipo_doc_iden',
        'fecha_nacimiento',
        'sexo',
        'estado_civil',
        'direccion',
        'telefono',
        'email',
        'estado',
    ];

    /**
     * Relación uno a muchos con DetalleFamilia.
     * Un Empleado puede tener varios DetalleFamilia (familiares).
     */
    public function familiares()
    {
        return $this->hasMany(DetalleFamilia::class, 'empleado_num_doc_iden');
    }

    /**
     * Relación muchos a muchos con TipoEmpleado a través de EmpleadoTipo.
     * Un Empleado puede tener múltiples TipoEmpleado.
     */
    public function tipos()
    {
        return $this->belongsToMany(TipoEmpleado::class, 'empleado_tipos', 'empleado_num_doc_iden', 'tipo_empleado_id')
            ->withPivot('aportacion_id', 'banco_id', 'tipo_cuenta', 'cci', 'numero_cuenta', 'estado')
            ->withTimestamps();
    }
}
