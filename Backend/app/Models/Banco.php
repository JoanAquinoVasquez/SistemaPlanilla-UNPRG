<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    /** @use HasFactory<\Database\Factories\BancoFactory> */
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    /**
     * Relación uno a muchos con EmpleadoTipo.
     * Un Banco puede tener múltiples cuentas de empleados.
     */
    public function empleadoTipos()
    {
        return $this->hasMany(EmpleadoTipo::class, 'banco_id');
    }

    /**
     * Relación uno a muchos con Prestamo.
     * Un Banco puede tener múltiples préstamos asociados.
     */
    public function prestamos()
    {
        return $this->hasMany(Prestamo::class, 'banco_id');
    }
}
