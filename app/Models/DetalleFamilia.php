<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleFamilia extends Model
{
    use HasFactory;
    
    // Definimos la clave primaria personalizada
    protected $primaryKey = 'dni';
    public $incrementing = false;
    protected $keyType = 'string';

    // Campos rellenables
    protected $fillable = [
        'empleado_num_doc_iden',
        'parentesco_id',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'telefono',
        'fecha_nacimiento',
        'nivel_escolaridad',
        'dependiente',
        'discapacidad',
        'estado',
    ];

    /**
     * Relación muchos a uno con Empleado.
     * Un DetalleFamilia pertenece a un Empleado.
     */
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_num_doc_iden');
    }

    /**
     * Relación muchos a uno con Parentesco.
     * Un DetalleFamilia pertenece a un Parentesco.
     */
    public function parentesco()
    {
        return $this->belongsTo(Parentesco::class, 'parentesco_id');
    }
}
