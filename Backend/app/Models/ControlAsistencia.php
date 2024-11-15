<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlAsistencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'empleado_tipo_id',
        'numero_asistencias',
        'numero_inasistencias',
        'numero_tardanzas',
        'periodo',
        'numero_permisos',
        'estado'
    ];

    // Relación con el modelo EmpleadoTipo
    public function empleadoTipo()
    {
        return $this->belongsTo(EmpleadoTipo::class);
    }
}
