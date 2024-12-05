<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaEmpleadoTipo extends Model
{
    use HasFactory;

    protected $table = 'area_empleado_tipos';

    // Ocultar los campos created_at y updated_at
    protected $hidden = ['created_at', 'updated_at'];
    
    protected $fillable = [
        'empleado_tipo_id',
        'empleado_tipo_num_doc_iden',
        'area_id',
        'estado',
    ];

    /**
     * Relación con el modelo EmpleadoTipo.
     */
    public function empleadoTipo()
    {
        return $this->belongsTo(EmpleadoTipo::class, 'empleado_tipo_id', 'id_tipo_empleado');
    }

    /**
     * Relación con el modelo Area.
     */
    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
