<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Artista;
use Illuminate\Http\Request;

class ArtistaController extends Controller
{
    public function index()
    {
        return Artista::all();
    }

    public function store(Request $request)
    {
        $artista = Artista::create($request->all());
        return response()->json($artista, 201);
    }

    public function show(Artista $artista)
    {
        return $artista;
    }

    public function update(Request $request, Artista $artista)
    {
        $artista->update($request->all());
        return response()->json($artista, 200);
    }

    public function destroy(Artista $artista)
    {
        $artista->delete();
        return response()->json(null, 204);
    }
}