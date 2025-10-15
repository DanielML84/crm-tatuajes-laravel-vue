<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // <-- Importante: Añade esta línea al principio

class ClienteController extends Controller
{
     public function index(Request $request)
    {
        $query = Cliente::query();

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

        // Devolvemos los resultados paginados (por defecto, 10 por página)
        return $query->paginate(10);
    }

    public function store(Request $request)
    {
        // 1. Definimos las reglas de validación para crear un cliente
        $validatedData = $request->validate([
            'nombre'    => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email'     => 'required|email|unique:clientes,email', // Requerido, formato email y único en la tabla 'clientes'
            'telefono'  => 'required|string|max:20',
        ]);

        // 2. Si la validación pasa, creamos el cliente solo con los datos validados
        $cliente = Cliente::create($validatedData);

        return response()->json($cliente, 201);
    }

    public function show(Cliente $cliente)
    {
        return $cliente;
    }

    public function update(Request $request, Cliente $cliente)
    {
        // 1. Las reglas de validación para actualizar son similares
        $validatedData = $request->validate([
            'nombre'    => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email'     => [
                'required',
                'email',
                // 2. La regla 'unique' aquí es especial. Le decimos que el email
                // debe ser único, PERO ignorando el del propio cliente que estamos editando.
                // Si no hiciéramos esto, nos daría error al guardar sin cambiar el email.
                Rule::unique('clientes')->ignore($cliente->id),
            ],
            'telefono'  => 'required|string|max:20',
        ]);

        // 3. Actualizamos el cliente con los datos validados
        $cliente->update($validatedData);

        return response()->json($cliente, 200);
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return response()->json(null, 204);
    }
    
    public function list()
    {
        return Cliente::orderBy('nombre')->get(['id', 'nombre', 'apellidos']);
    }
}