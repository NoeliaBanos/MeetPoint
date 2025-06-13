<?php

namespace App\Http\Controllers;

use App\Models\Espacio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EspacioController extends Controller
{
    /**
     * Listado público de espacios.
     */
    public function index()
    {
        $espacios = Espacio::all();
        return view('espacios.index', compact('espacios'));
    }

    /**
     * Detalle público de un espacio.
     */
    public function show(Espacio $espacio)
    {
        return view('espacios.show', compact('espacio'));
    }

    /**
     * Formulario de creación – usuarios autenticados.
     */
    public function create()
    {
        return view('espacios.create');
    }

    /**
     * Almacenar nuevo espacio – usuarios autenticados.
     * Arranca siempre como no_disponible.
     */
    public function store(Request $request)
    {
        // 1) Validación de entrada
        $data = $request->validate([
            'nombre'               => 'required|string|max:255',
            'precio_hora'          => 'required|numeric',
            'capacidad'            => 'required|integer|min:1',
            'descripcion'          => 'nullable|string',
            'equipamiento'         => 'nullable|array',
            'equipamiento.*'       => 'string',
            'equipamiento_otros'   => 'nullable|string',
            'imagen'               => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
            'estado_espacio'       => 'required|in:disponible,no_disponible',
            'fecha_hora'           => 'required|date',
        ]);

        // 2) Si el usuario ha rellenado "Otros", lo añadimos al array
        if (!empty($data['equipamiento_otros'])) {
            $data['equipamiento'][] = $data['equipamiento_otros'];
        }

        // 3) Convertimos el array de equipamiento en cadena separada por comas
        $data['equipamiento'] = isset($data['equipamiento'])
            ? implode(',', $data['equipamiento'])
            : null;

        // 4) Procesamos la imagen y guardamos la ruta en imagen_url
        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('espacios', 'public');
            $data['imagen_url'] = 'storage/' . $path;
        }

        // 5) Limpiamos las claves que no existen en la tabla
        unset($data['imagen'], $data['equipamiento_otros']);

        // 6) Garantizamos un estado por defecto
        $data['estado_espacio'] = $data['estado_espacio'] ?? 'no_disponible';

        // 7) Creamos el registro
        Espacio::create($data);

        // 8) Redirigimos con flag de éxito para mostrar modal en la vista
        return redirect()
            ->route('espacios.create')
            ->with('success', 'El espacio se ha creado correctamente.');
    }

    /**
     * Formulario de edición – solo ADMIN.
     */
    public function edit(Espacio $espacio)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acceso denegado');
        }
        return view('espacios.edit', compact('espacio'));
    }

    /**
     * Actualizar espacio – solo ADMIN.
     */
    public function update(Request $request, Espacio $espacio)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acceso denegado');
        }

        $data = $request->validate([
            'nombre'             => 'required|string|max:255',
            'precio_hora'        => 'required|numeric',
            'capacidad'          => 'required|integer|min:1',
            'descripcion'        => 'nullable|string',
            'equipamiento'       => 'nullable|array',
            'equipamiento.*'     => 'string',
            'equipamiento_otros' => 'nullable|string',
            'imagen'             => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
            'estado_espacio'     => 'required|in:disponible,no_disponible',
            'fecha_hora'         => 'required|date',
        ]);

        if (!empty($data['equipamiento_otros'])) {
            $data['equipamiento'][] = $data['equipamiento_otros'];
        }
        $data['equipamiento'] = isset($data['equipamiento'])
            ? implode(',', $data['equipamiento'])
            : null;

        if ($request->hasFile('imagen')) {
            if ($espacio->imagen_url) {
                Storage::disk('public')->delete(
                    str_replace('storage/', '', $espacio->imagen_url)
                );
            }
            $path = $request->file('imagen')->store('espacios', 'public');
            $data['imagen_url'] = 'storage/' . $path;
        }

        unset($data['imagen'], $data['equipamiento_otros']);

        $espacio->update($data);

        return back()->with('status', 'Espacio actualizado correctamente.');
    }

    /**
     * Eliminar espacio – solo ADMIN.
     */
    public function destroy(Espacio $espacio)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acceso denegado');
        }
        if ($espacio->imagen_url) {
            Storage::disk('public')->delete(
                str_replace('storage/', '', $espacio->imagen_url)
            );
        }
        $espacio->delete();
        return redirect()
            ->route('espacios.index')
            ->with('status', 'Espacio eliminado correctamente.');
    }

    /**
     * Marcar como APTA – solo ADMIN.
     */
    public function markApta(Espacio $espacio)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acceso denegado');
        }
        $espacio->update(['estado_espacio' => 'disponible']);
        return back()->with('status', 'Espacio marcado como APTA.');
    }

    /**
     * Marcar como NO APTA – solo ADMIN.
     */
    public function markNoApta(Espacio $espacio)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acceso denegado');
        }
        $espacio->update(['estado_espacio' => 'no_disponible']);
        return back()->with('status', 'Espacio marcado como NO APTA.');
    }
}
