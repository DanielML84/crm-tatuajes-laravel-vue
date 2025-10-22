<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Hito;
use Illuminate\Http\Request;

class HitoController extends Controller
{
    // Muestra todos los hitos de una cita específica
    public function index(Cita $cita)
    {
        // Cargamos la relación 'estadoHito' para incluir el nombre del estado
        return $cita->hitos()->with('estadoHito')->get();
    }

    // Crea un nuevo hito para una cita específica
    public function store(Request $request, Cita $cita)
    {
        $validatedData = $request->validate([
            'titulo'           => 'required|string|max:255',
            'descripcion'      => 'nullable|string',
            'estado_hito_id'   => 'required|exists:estados_hitos,id',
            'fecha_limite'     => 'nullable|date',
        ]);

        $hito = $cita->hitos()->create($validatedData);

        return response()->json($hito->load('estadoHito'), 201);
    }

    // Muestra un hito específico
    public function show(Hito $hito)
    {
        return $hito->load('estadoHito');
    }

    // Actualiza un hito específico (ej. cambiar su estado)
    public function update(Request $request, Hito $hito)
    {
        $validatedData = $request->validate([
            'titulo'           => 'sometimes|required|string|max:255',
            'descripcion'      => 'sometimes|nullable|string',
            'estado_hito_id'   => 'sometimes|required|exists:estados_hitos,id',
            'fecha_limite'     => 'sometimes|nullable|date',
        ]);

        $hito->update($validatedData);

        return response()->json($hito->load('estadoHito'), 200);
    }

    // Elimina un hito específico
    public function destroy(Hito $hito)
    {
        $hito->delete();
        return response()->json(null, 204);
    }
}