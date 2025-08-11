<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    public function index()
    {
        // Usamos with() para cargar las relaciones y evitar el problema N+1
        return Cita::with(['cliente', 'artista'])->get();
    }

    public function store(Request $request)
    {
        $cita = Cita::create($request->all());
        return response()->json($cita, 201);
    }

    public function show(Cita $cita)
    {
        // Cargamos las relaciones para una única cita
        return $cita->load(['cliente', 'artista']);
    }

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