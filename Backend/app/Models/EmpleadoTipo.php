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

    // Ocultar los campos created_at y updated_at
    protected $hidden = ['created_at', 'updated_at'];

    // Campos rellenables
    protected $fillable = [
        'tipo_empleado_id',
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
        return $this->belongsTo(TipoEmpleado::class);
    }

    public function subTipoEmpleado()
    {
        return $this->belongsTo(SubTipoEmpleado::class);
    }

    public function categoriaEmpleado()
    {
        return $this->belongsTo(CategoriaEmpleado::class);
    }

    public function subCategoriaEmpleado()
    {
        return $this->belongsTo(SubCategoriaEmpleado::class);
    }

    /**
     * Relación muchos a uno con Empleado.
     * Un EmpleadoTipo pertenece a un Empleado.
     */
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_num_doc_iden', 'num_doc_iden');
    }

    /**
     * Relación muchos a uno con Banco.
     * Un EmpleadoTipo pertenece a un Banco.
     */
    public function banco()
    {
        return $this->belongsTo(Banco::class, 'banco_id');
    }

    // Definimos la relación uno a uno con Aportacion
    /* public function aportacion()
    {
        return $this->belongsTo(Aportacion::class, 'aportacion_id');
    } */

    /**
     * Relación uno a muchos con ControlAsistencia.
     * Un EmpleadoTipo puede tener múltiples registros de ControlAsistencia.
     */
    public function asistencias()
    {
        return $this->hasMany(ControlAsistencia::class);
    }

    /**
     * Relación uno a muchos con Contrato.
     * Un EmpleadoTipo puede tener múltiples Contratos.
     */
    public function contratos()
    {
        return $this->hasMany(Contrato::class);
    }

    /**
     * Relación uno a muchos con Prestamo.
     * Un EmpleadoTipo puede tener múltiples préstamos asociados.
     */
    public function prestamos()
    {
        return $this->hasMany(Prestamo::class);
    }

    /**
     * Relación uno a muchos con Vacacion.
     * Un EmpleadoTipo puede tener múltiples vacaciones asociadas.
     */
    public function vacaciones()
    {
        return $this->hasMany(Vacacion::class);
    }

    /**
     * Relación uno a muchos con Licencia.
     * Un EmpleadoTipo puede tener múltiples Licencias asociadas.
     */
    public function licencias()
    {
        return $this->hasMany(Licencia::class);
    }

    // Relación muchos a muchos con el modelo Area a través de area_empleado_tipos
    public function areas()
    {
        return $this->belongsToMany(Area::class, 'area_empleado_tipos')
            ->withPivot('estado') // Incluye el campo adicional 'estado' de la tabla pivot
            ->withTimestamps();   // Incluye timestamps en la relación pivot
    }

    public function areaActiva()
    {
        return $this->hasOne(AreaEmpleadoTipo::class)->where('estado', true);
    }

    /**
     * Relación uno a muchos con Remuneracion.
     * Un EmpleadoTipo puede estar en varias Remuneraciones.
     */
    public function remuneraciones()
    {
        return $this->hasMany(Remuneracion::class);
    }


    /**
     * Relación uno a muchos con DetalleEgreso.
     * Un EmpleadoTipo puede estar en varias DetalleEgreso.
     */
    public function detallesEgreso()
    {
        return $this->hasMany(DetalleEgreso::class);
    }

    /**
     * Relación uno a muchos con DetalleIngreso.
     * Un EmpleadoTipo puede estar en varios DetalleIngreso.
     */
    public function detallesIngreso()
    {
        return $this->hasMany(DetalleIngreso::class);
    }

    /**
     * Relación uno a muchos con DetalleAportacion.
     * Un EmpleadoTipo puede estar en varias DetalleAportacion.
     */
    public function detalleAportaciones()
    {
        return $this->hasMany(DetalleAportacion::class);
    }

    // Relación para obtener solo el tipo de aportación específico (AFP o ONP)
    public function aportacionPension()
    {
        return $this->hasOneThrough(Aportacion::class, DetalleAportacion::class, 'empleado_tipo_id', 'id', 'id', 'aportacions_id')
            ->where(function ($query) {
                $query->where('concepto', 'LIKE', '%AFP%')
                    ->orWhere('concepto', 'Aporte a ONP');
            });
    }
}
