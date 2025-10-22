<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cliente_id',
        'artista_id',
        'fecha_hora',
        'descripcion',
        'estado',
    ];

    /**
     * Define la relación: una Cita pertenece a un Cliente.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Define la relación: una Cita pertenece a un Artista.
     */
    public function artista()
    {
        return $this->belongsTo(Artista::class);
    }
    /**
     * Define la relación: una Cita tiene muchos Hitos.
     */
    public function hitos()
    {
        return $this->hasMany(Hito::class);
    }
}
