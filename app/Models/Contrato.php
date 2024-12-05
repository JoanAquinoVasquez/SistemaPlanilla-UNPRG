<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    use HasFactory;

    protected $fillable = [
        'empleado_tipo_id',
        'sueldo_bruto',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'tipo_documento',
        'numero_documento',
        'regimen_laboral',
        'horas_trabajo'
    ];

    // Relación con el modelo EmpleadoTipo
    public function empleadoTipo()
    {
        return $this->belongsTo(EmpleadoTipo::class);
    }
}
