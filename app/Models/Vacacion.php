<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacacion extends Model
{
    use HasFactory;
    protected $table = 'vacaciones';


    // Campos rellenables
    protected $fillable = [
        'empleado_tipo_id',
        'estado',
        'numero_dias',
        'periodo',
        'detalle'
    ];

    // Relación con el modelo EmpleadoTipo
    public function empleadoTipo()
    {
        return $this->belongsTo(EmpleadoTipo::class);
    }
}
