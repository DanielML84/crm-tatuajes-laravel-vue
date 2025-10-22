<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\EstadoHito;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    public function index()
    {
        return Cita::with(['cliente', 'artista'])->get();
    }

    // MÉTODO STORE MODIFICADO
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'cliente_id'  => 'required|exists:clientes,id',
            'artista_id'  => 'required|exists:artistas,id',
            'fecha_hora'  => 'required|date',
            'descripcion' => 'nullable|string',
        ]);

        // 2. Creamos la cita como antes
        $cita = Cita::create($validatedData);

        // --- INICIO DE LA NUEVA LÓGICA ---
        // 3. Buscamos el ID del estado "Pendiente" (más seguro que hardcodear 1)
        $estadoPendienteId = EstadoHito::where('nombre', 'Pendiente')->firstOrFail()->id;

        // 4. Creamos los tres hitos por defecto asociados a la nueva cita
        $cita->hitos()->createMany([
            [
                'titulo' => 'Firma del consentimiento informado',
                'estado_hito_id' => $estadoPendienteId
            ],
            [
                'titulo' => 'Pago de señal',
                'estado_hito_id' => $estadoPendienteId
            ],
            [
                'titulo' => 'Pago de tatuaje',
                'estado_hito_id' => $estadoPendienteId
            ]
        ]);
        // --- FIN DE LA NUEVA LÓGICA ---

        // Devolvemos la cita creada (el frontend recargará los hitos al expandir)
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