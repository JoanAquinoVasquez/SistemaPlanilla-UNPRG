<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlAsistencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'empleado_tipo_id',
        'empleado_tipo_num_doc_iden',
        'numero_asistencias',
        'numero_inaasistencias',
        'numero_tardanzas',
        'periodo',
        'numero_permisos',
    ];

    /**
     * Relación muchos a uno con EmpleadoTipo.
     * Un ControlAsistencia pertenece a un EmpleadoTipo.
     */
    public function empleadoTipo()
    {
        return $this->belongsTo(EmpleadoTipo::class, 'empleado_tipo_id', 'id_tipo_empleado')
                    ->where('empleado_tipo_num_doc_iden', 'num_doc_iden');
    }
}
