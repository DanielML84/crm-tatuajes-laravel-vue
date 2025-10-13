<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    public function index()
    {
        return Cita::with(['cliente', 'artista'])->get();
    }

    public function store(Request $request)
    {
        // Añadimos las reglas de validación para crear una cita
        $validatedData = $request->validate([
            // Requerido y debe existir en la tabla 'clientes' en la columna 'id'
            'cliente_id'  => 'required|exists:clientes,id', 
            // Requerido y debe existir en la tabla 'artistas' en la columna 'id'
            'artista_id'  => 'required|exists:artistas,id',
            'fecha_hora'  => 'required|date',
            'descripcion' => 'nullable|string', // La descripción puede estar vacía
        ]);

        $cita = Cita::create($validatedData);
        return response()->json($cita, 201);
    }

    public function show(Cita $cita)
    {
        return $cita->load(['cliente', 'artista']);
    }

    // Nota: Aún no hemos implementado la edición de citas, por lo que
    // no añadimos validación en el método update() por ahora.
    public function update(Request $request, Cita $cita)
    {
        $cita->update($request->all());
        return response()->json($cita, 200);
    }

    public function destroy(Cita $cita)
    {
        $cita->delete();
        return response()->json(null, 204);
    }
}