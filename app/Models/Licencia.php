<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Licencia extends Model
{
    use HasFactory;

    // Campos rellenables
    protected $fillable = [
        'empleado_tipo_id',
        'estado',
        'numero_dias',
        'goze',
        'detalle'
    ];

    /**
     * Relación muchos a uno con EmpleadoTipo.
     * Una Vacacion pertenece a un EmpleadoTipo.
     */
    public function empleadoTipo()
    {
        return $this->belongsTo(EmpleadoTipo::class);
    }
}
