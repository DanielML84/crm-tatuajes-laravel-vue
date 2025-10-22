<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoHito extends Model
{
    use HasFactory;
// === AÑADE ESTA LÍNEA ===
    /**
     * El nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'estados_hitos';
    // =========================
    // Indicamos que solo el campo 'nombre' se puede asignar masivamente.
    protected $fillable = ['nombre'];

    /**
     * Un estado puede tener muchos hitos.
     */
    public function hitos()
    {
        return $this->hasMany(Hito::class);
    }
}