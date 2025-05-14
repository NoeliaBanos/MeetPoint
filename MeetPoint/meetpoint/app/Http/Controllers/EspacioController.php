<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Espacio;

class EspacioController extends Controller
{  public function create()
    {
        return view('espacios.create');
    }

    public function index()
    {
        $espacios = Espacio::all();
        return view('espacios.index', compact('espacios')); // Asegúrate de tener la vista 'espacios.index'
    }

    public function show($id)
    {
        $espacio = Espacio::findOrFail($id);
        return view('espacios.show', compact('espacio')); // Asegúrate de tener la vista 'espacios.show'
    }

    public function adminDashboard()
    {
        return view('admin.dashboard'); // Asegúrate de tener la vista 'admin.dashboard'
    }
      public function store(Request $request)
    {
        // 1) Validación
        $data = $request->validate([
            'nombre'         => 'required|string|max:255',
            'precio_hora'    => 'required|numeric',
            'equipamiento'   => 'nullable|string',
            'descripcion'    => 'nullable|string',
            'imagen'         => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        // 2) Si subieron imagen, la guardamos en storage/app/public/espacios
        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('espacios', 'public');
            // guardamos la ruta relativa en la DB
            $data['imagen_url'] = 'storage/' . $path;
        }

        // 3) Crear registro
        Espacio::create($data);

        // 4) Redirigir de vuelta al index con mensaje
        return redirect()
               ->route('espacios.index')
               ->with('status', 'Espacio creado correctamente.');
    }
}
