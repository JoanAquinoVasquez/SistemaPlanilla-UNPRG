<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    use HasFactory;

    // Campos rellenables
    protected $fillable = [
        'empleado_tipo_id',
        'empleado_tipo_num_doc_iden',
        'banco_id',
        'fecha_inicio',
        'fecha_fin',
        'monto_prestado',
        'monto_restante',
        'numero_cuotas',
        'estado',
    ];

    /**
     * Relación muchos a uno con EmpleadoTipo.
     * Un Prestamo pertenece a un EmpleadoTipo.
     */
    public function empleadoTipo()
    {
        return $this->belongsTo(EmpleadoTipo::class, 'empleado_tipo_id', 'id_tipo_empleado')
            ->where('empleado_tipo_num_doc_iden', 'num_doc_iden');
    }

    /**
     * Relación muchos a uno con Banco.
     * Un Prestamo pertenece a un Banco.
     */
    public function banco()
    {
        return $this->belongsTo(Banco::class, 'banco_id');
    }

    /**
     * Relación uno a muchos con Cuota.
     * Un Prestamo puede tener múltiples Cuotas asociadas.
     */
    public function cuotas()
    {
        return $this->hasMany(Cuota::class, 'prestamo_id');
    }

}
