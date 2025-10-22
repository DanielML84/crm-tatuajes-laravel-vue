<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
// QUITA: use App\Models\EstadoHito;
use Illuminate\Http\Request;
// AÑADE: Importa el Facade DB
use Illuminate\Support\Facades\DB; 

class EstadoHitoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Usa DB::table() en lugar de Eloquent
        return DB::table('estados_hitos')->get(); 
    }
}