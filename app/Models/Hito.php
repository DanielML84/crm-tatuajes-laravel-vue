<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hito extends Model
{
    use HasFactory;

    // Definimos todos los campos que se podrán rellenar desde un formulario.
    protected $fillable = [
        'cita_id',
        'estado_hito_id',
        'titulo',
        'descripcion',
        'fecha_limite',
    ];

    /**
     * Un hito pertenece a una sola Cita.
     */
    public function cita()
    {
        return $this->belongsTo(Cita::class);
    }

    /**
     * Un hito tiene un solo Estado.
     * El nombre del método es 'estadoHito' para no confundir con la columna 'estado_hito_id'.
     */
    public function estadoHito()
    {
        return $this->belongsTo(EstadoHito::class);
    }
}