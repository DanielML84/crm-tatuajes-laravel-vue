<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cita;

class AgendaController extends Controller
{
    public function index(Request $request)
    {
        // 1. Empezamos la consulta, pero no la ejecutamos todavía
        $query = Cita::with(['cliente', 'artista']);

        // 2. Si la petición incluye un 'artista_id', añadimos un filtro
        if ($request->has('artista_id')) {
            $query->where('artista_id', $request->artista_id);
        }

        // 3. Ahora sí, ejecutamos la consulta (con el filtro si aplica)
        $citas = $query->get();

        // El resto del código para transformar los datos no cambia
        $eventos = $citas->map(function ($cita) {
            return [
                'title' => $cita->cliente->nombre . ' - ' . $cita->artista->nombre,
                'start' => $cita->fecha_hora,
            ];
        });

        return response()->json($eventos);
    }
}