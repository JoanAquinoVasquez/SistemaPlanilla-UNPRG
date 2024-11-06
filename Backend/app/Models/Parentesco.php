<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parentesco extends Model
{
    use HasFactory;

    protected $fillable = [
        'grado_parentesco',
    ];

    /**
     * Relación uno a muchos con DetalleFamilia.
     * Un Parentesco puede aplicarse a varios DetalleFamilia.
     */
    public function familiares()
    {
        return $this->hasMany(DetalleFamilia::class, 'parentesco_id');
    }
}
