<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resena;

class ResenaController extends Controller
{
    public function index()
    {
        $resenas = Resena::all();
        return view('resenas.index', compact('resenas')); // Asegúrate de tener la vista 'resenas.index'
    }

    public function store()
    {
        // Lógica para guardar una reseña
    }

    public function destroy($id)
    {
        $resena = Resena::findOrFail($id);
        $resena->delete();
        return redirect()->route('resenas.index');
    }
}