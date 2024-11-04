<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    /** @use HasFactory<\Database\Factories\DocumentoFactory> */
    use HasFactory;
    // Agrega los campos que permiten asignación masiva
    protected $fillable = ['nombre', 'tipo', 'anio'];
}
