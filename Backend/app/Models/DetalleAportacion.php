<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleAportacion extends Model
{
    use HasFactory;

    // Campos rellenables
    protected $fillable = [
        'aportacions_id',
        'remuneracion_id',
        'empleado_tipo_id',
        'empleado_tipo_num_doc_iden',
        'monto',
    ];

    /**
     * Relación muchos a uno con Aportacion.
     * Un DetalleAportacion pertenece a una Aportacion.
     */
    public function aportacion()
    {
        return $this->belongsTo(Aportacion::class, 'aportacions_id');
    }

    /**
     * Relación muchos a uno con Remuneracion.
     * Un DetalleAportacion pertenece a una Remuneracion.
     */
    public function remuneracion()
    {
        return $this->belongsTo(Remuneracion::class, 'remuneracion_id');
    }

    /**
     * Relación muchos a uno con EmpleadoTipo.
     * Un DetalleAportacion pertenece a un EmpleadoTipo.
     */
    public function empleadoTipo()
    {
        return $this->belongsTo(EmpleadoTipo::class, 'empleado_tipo_id', 'id_tipo_empleado')
            ->where('empleado_tipo_num_doc_iden', 'num_doc_iden');
    }
}
