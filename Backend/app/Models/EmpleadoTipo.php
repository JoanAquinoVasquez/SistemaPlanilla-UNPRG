<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpleadoTipo extends Model
{
    use HasFactory;

    // Desactivamos el timestamp y primary key autoincremental ya que usa claves compuestas
    public $timestamps = false;
    public $incrementing = false;

    // Campos rellenables
    protected $fillable = [
        'id_tipo_empleado',
        'num_doc_iden',
        'banco_id',
        'tipo_cuenta',
        'cci',
        'numero_cuenta',
        'estado',
    ];

    /**
     * Relación muchos a uno con TipoEmpleado.
     * Un EmpleadoTipo pertenece a un TipoEmpleado.
     */
    public function tipoEmpleado()
    {
        return $this->belongsTo(TipoEmpleado::class, 'id_tipo_empleado');
    }

    /**
     * Relación muchos a uno con Empleado.
     * Un EmpleadoTipo pertenece a un Empleado.
     */
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'num_doc_iden');
    }

    /**
     * Relación muchos a uno con Banco.
     * Un EmpleadoTipo pertenece a un Banco.
     */
    public function banco()
    {
        return $this->belongsTo(Banco::class, 'banco_id');
    }

    /**
     * Relación uno a muchos con ControlAsistencia.
     * Un EmpleadoTipo puede tener múltiples registros de ControlAsistencia.
     */
    public function asistencias()
    {
        return $this->hasMany(ControlAsistencia::class, 'empleado_tipo_id', 'id_tipo_empleado')
                    ->where('empleado_tipo_num_doc_iden', $this->num_doc_iden);
    }

    /**
     * Relación uno a muchos con Contrato.
     * Un EmpleadoTipo puede tener múltiples Contratos.
     */
    public function contratos()
    {
        return $this->hasMany(Contrato::class, 'empleado_tipo_id', 'id_tipo_empleado')
                    ->where('empleado_tipo_num_doc_iden', $this->num_doc_iden);
    }
    
    /**
     * Relación uno a muchos con Prestamo.
     * Un EmpleadoTipo puede tener múltiples préstamos asociados.
     */
    public function prestamos()
    {
        return $this->hasMany(Prestamo::class, 'empleado_tipo_id', 'id_tipo_empleado')
                    ->where('empleado_tipo_num_doc_iden', $this->num_doc_iden);
    }

    /**
     * Relación uno a muchos con Vacacion.
     * Un EmpleadoTipo puede tener múltiples vacaciones asociadas.
     */
    public function vacaciones()
    {
        return $this->hasMany(Vacacion::class, 'empleado_tipo_id', 'id_tipo_empleado')
                    ->where('empleado_tipo_num_doc_iden', $this->num_doc_iden);
    }

    /**
     * Relación uno a muchos con Licencia.
     * Un EmpleadoTipo puede tener múltiples Licencias asociadas.
     */
    public function licencias()
    {
        return $this->hasMany(Licencia::class, 'empleado_tipo_id', 'id_tipo_empleado')
                    ->where('empleado_tipo_num_doc_iden', $this->num_doc_iden);
    }

    /**
     * Relación uno a muchos con Remuneracion.
     * Un EmpleadoTipo puede estar en varias Remuneraciones.
     */
    public function remuneraciones()
    {
        return $this->hasMany(Remuneracion::class, 'empleado_tipo_id', 'id_tipo_empleado')
                    ->where('empleado_tipo_num_doc_iden', $this->num_doc_iden);
    }

    /**
     * Relación uno a muchos con DetalleAportacion.
     * Un EmpleadoTipo puede estar en varias DetalleAportacion.
     */
    public function detalleAportaciones()
    {
        return $this->hasMany(DetalleAportacion::class, 'empleado_tipo_id', 'id_tipo_empleado')
                    ->where('empleado_tipo_num_doc_iden', $this->num_doc_iden);
    }

    /**
     * Relación uno a muchos con DetalleEgreso.
     * Un EmpleadoTipo puede estar en varias DetalleEgreso.
     */
    public function detallesEgreso()
    {
        return $this->hasMany(DetalleEgreso::class, 'empleado_tipo_id', 'id_tipo_empleado')
                    ->where('empleado_tipo_num_doc_iden', $this->num_doc_iden);
    }

    /**
     * Relación uno a muchos con DetalleIngreso.
     * Un EmpleadoTipo puede estar en varios DetalleIngreso.
     */
    public function detallesIngreso()
    {
        return $this->hasMany(DetalleIngreso::class, 'empleado_tipo_id', 'id_tipo_empleado')
                    ->where('empleado_tipo_num_doc_iden', $this->num_doc_iden);
    }
}
