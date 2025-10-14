<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Artista;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // <-- Añade esta línea

class ArtistaController extends Controller
{
    public function index(Request $request)
    {
        $query = Artista::query();

        // Si en la URL nos llega un parámetro "search"
        if ($request->has('search')) {
            $searchTerm = $request->search;
            // Buscamos el término en las columnas 'nombre', 'apellidos' y 'email'
            $query->where(function($q) use ($searchTerm) {
                $q->where('nombre', 'like', "%{$searchTerm}%")
                  ->orWhere('apellidos', 'like', "%{$searchTerm}%")
                  ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }

        // Devolvemos los resultados paginados (10 por página)
        return $query->paginate(10);
    }

    public function store(Request $request)
    {
        // Añadimos las reglas de validación para crear
        $validatedData = $request->validate([
            'nombre'    => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email'     => 'required|email|unique:artistas,email',
            'telefono'  => 'required|string|max:20',
        ]);

        $artista = Artista::create($validatedData);
        return response()->json($artista, 201);
    }

    public function show(Artista $artista)
    {
        return $artista;
    }

    public function update(Request $request, Artista $artista)
    {
        // Añadimos las reglas de validación para actualizar
        $validatedData = $request->validate([
            'nombre'    => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email'     => [
                'required',
                'email',
                Rule::unique('artistas')->ignore($artista->id), // Ignora el email del propio artista
            ],
            'telefono'  => 'required|string|max:20',
        ]);

        $artista->update($validatedData);
        return response()->json($artista, 200);
    }

    public function destroy(Artista $artista)
    {
        $artista->delete();
        return response()->json(null, 204);
    }
}