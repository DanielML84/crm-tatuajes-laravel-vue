<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artista extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'apellidos',
        'email',
        'telefono',
    ];

    /**
     * Define la relación: un Artista tiene muchas Citas.
     */
    public function citas()
    {
        return $this->hasMany(Cita::class);
    }
}
