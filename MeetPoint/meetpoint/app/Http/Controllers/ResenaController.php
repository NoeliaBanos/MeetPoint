<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resena;
use App\Models\Espacio;
use Illuminate\Support\Facades\Auth;

class ResenaController extends Controller
{
    public function index()
    {
        $resenas = Resena::all();
        return view('resenas.index', compact('resenas'));
    }

    public function create(Request $request)
    {
        $espacioId = $request->input('espacio');
        $espacios = Espacio::all();

        return view('resenas.create', compact('espacios', 'espacioId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'espacio_id'   => 'required|exists:espacios,id',
            'calificacion' => 'required|integer|min:1|max:5',
            'comentario'   => 'required|string|max:1000',
        ]);

        Resena::create([
            'user_id'      => Auth::user()->id, // Sin warning si usas el facade
            'espacio_id'   => $request->espacio_id,
            'calificacion' => $request->calificacion,
            'comentario'   => $request->comentario,
        ]);

        return redirect()->back()->with('success', '¡Reseña guardada correctamente!');
    }

    public function edit($id)
    {
        $resena = Resena::findOrFail($id);
        return view('resenas.edit', compact('resena'));
    }

    public function update(Request $request, $id)
    {
        $resena = Resena::findOrFail($id);

        $request->validate([
            'calificacion' => 'required|integer|min:1|max:5',
            'comentario'   => 'required|string|max:1000',
        ]);

        $resena->update([
            'calificacion' => $request->calificacion,
            'comentario'   => $request->comentario,
        ]);

        return redirect()->route('resenas.index')->with('success', 'Reseña actualizada.');
    }

    public function destroy($id)
    {
        $resena = Resena::findOrFail($id);
        $resena->delete();

        return redirect()->route('resenas.index')->with('success', 'Reseña eliminada.');
    }

    public function show($id)
    {
        $resena = Resena::findOrFail($id);
        return view('resenas.show', compact('resena'));
    }
}
