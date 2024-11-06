<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacacion extends Model
{
    use HasFactory;

    // Campos rellenables
    protected $fillable = [
        'empleado_tipo_id',
        'empleado_tipo_num_doc_iden',
        'estado',
        'numero_dias',
        'periodo',
        'detalle',
    ];

    /**
     * Relación muchos a uno con EmpleadoTipo.
     * Una Vacacion pertenece a un EmpleadoTipo.
     */
    public function empleadoTipo()
    {
        return $this->belongsTo(EmpleadoTipo::class, 'empleado_tipo_id', 'id_tipo_empleado')
                    ->where('empleado_tipo_num_doc_iden', 'num_doc_iden');
    }
}
