<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as ControllersController;
use App\Models\Espacio;
use Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EspacioController extends ControllersController
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
     * Formulario de creación – usuarios autenticados (protegido en rutas).
     */
    public function create()
    {
        return view('espacios.create');
    }

    /**
     * Almacenar nuevo espacio – usuarios autenticados.
     * Arranca siempre como no_disponible (pendiente de aprobación).
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'       => 'required|string|max:255',
            'precio_hora'  => 'required|numeric',
            'equipamiento' => 'nullable|string',
            'descripcion'  => 'nullable|string',
            'imagen'       => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('espacios', 'public');
            $data['imagen_url'] = 'storage/' . $path;
        }

        $data['estado_espacio'] = 'no_disponible';

        Espacio::create($data);

        return redirect()
            ->route('profile.show')
            ->with('pending', 'Su sala está siendo aprobada por nuestro equipo');
    }

    /**
     * Formulario de edición – solo ADMIN (comprobado en rutas o aquí).
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
            'nombre'       => 'required|string|max:255',
            'precio_hora'  => 'required|numeric',
            'equipamiento' => 'nullable|string',
            'descripcion'  => 'nullable|string',
            'imagen'       => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            if ($espacio->imagen_url) {
                Storage::disk('public')
                    ->delete(str_replace('storage/', '', $espacio->imagen_url));
            }
            $path = $request->file('imagen')->store('espacios', 'public');
            $data['imagen_url'] = 'storage/' . $path;
        }

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
            Storage::disk('public')
                ->delete(str_replace('storage/', '', $espacio->imagen_url));
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

        $espacio->estado_espacio = 'disponible';
        $espacio->save();

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

        $espacio->estado_espacio = 'no_disponible';
        $espacio->save();

        return back()->with('status', 'Espacio marcado como NO APTA.');
    }
}
