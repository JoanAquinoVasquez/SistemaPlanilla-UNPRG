<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    use HasFactory;

    protected $fillable = [
        'empleado_tipo_id',
        'empleado_tipo_num_doc_iden',
        'sueldo_bruto',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'tipo_documento',
        'numero_documento',
        'regimen_laboral',
        'horas_trabajo',
    ];

    /**
     * Relación muchos a uno con EmpleadoTipo.
     * Un Contrato pertenece a un EmpleadoTipo.
     */
    public function empleadoTipo()
    {
        return $this->belongsTo(EmpleadoTipo::class, 'empleado_tipo_id', 'id_tipo_empleado')
                    ->where('empleado_tipo_num_doc_iden', 'num_doc_iden');
    }
}
