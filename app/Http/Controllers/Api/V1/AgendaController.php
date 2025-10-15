<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cita;

class AgendaController extends Controller
{
    public function index()
    {
        // 1. Obtenemos todas las citas con la información de su cliente y artista
        $citas = Cita::with(['cliente', 'artista'])->get();

        // 2. Transformamos los datos al formato que necesita FullCalendar
        $eventos = $citas->map(function ($cita) {
            return [
                'title' => $cita->cliente->nombre . ' - ' . $cita->artista->nombre, // Título del evento
                'start' => $cita->fecha_hora, // Fecha de inicio
                // Podríamos añadir una fecha de fin si nuestras citas tuvieran duración
            ];
        });

        // 3. Devolvemos la colección de eventos en formato JSON
        return response()->json($eventos);
    }
}