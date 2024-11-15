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
        'banco_id',
        'fecha_inicio',
        'fecha_fin',
        'monto_prestado',
        'monto_restante',
        'numero_cuotas',
        'estado'
    ];

    /**
     * Relación muchos a uno con EmpleadoTipo.
     * Un Prestamo pertenece a un EmpleadoTipo.
     */
    public function empleadoTipo()
    {
        return $this->belongsTo(EmpleadoTipo::class);
    }

    /**
     * Relación muchos a uno con Banco.
     * Un Prestamo pertenece a un Banco.
     */
    public function banco()
    {
        return $this->belongsTo(Banco::class);
    }

    /**
     * Relación uno a muchos con Cuota.
     * Un Prestamo puede tener múltiples Cuotas asociadas.
     */
    public function cuotas()
    {
        return $this->hasMany(Cuota::class);
    }
}
