<?php

namespace App\Http\Controllers;

use App\Models\Espacio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EspacioController extends Controller
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'equipamiento',    // lo guardas como JSON o coma-separado
        'estado_espacio',
        'precio_hora',
        'imagen_url',
        'capacidad',
        'fecha_hora',
    ];
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
    // 1) validación acorde a tus columnas
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

    // 2) Tratamiento de "Otros" en equipamiento
    if (!empty($data['equipamiento_otros'])) {
        $data['equipamiento'][] = $data['equipamiento_otros'];
    }

    // 3) Convertimos a JSON (o concatenamos con ',') para la columna equipamiento
    $data['equipamiento'] = json_encode($data['equipamiento']);

    // 4) Procesamos la imagen y creamos el campo imagen_url
    if ($request->hasFile('imagen')) {
        $path = $request->file('imagen')->store('espacios', 'public');
        $data['imagen_url'] = 'storage/' . $path;
    }

    // 5) Limpiamos claves que no existen en la tabla
    unset($data['imagen'], $data['equipamiento_otros']);

    // 6) Garantizamos un estado por defecto
    $data['estado_espacio'] = $data['estado_espacio'] ?? 'no_disponible';

    // 7) Creamos registro
    Espacio::create($data);

    // 8) Redirigimos con flag de éxito
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
            'nombre'       => 'required|string|max:255',
            'precio_hora'  => 'required|numeric',
            'equipamiento' => 'nullable|array',
            'equipamiento.*' => 'string',
            'descripcion'  => 'nullable|string',
            'imagen'       => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            if ($espacio->imagen_url) {
                Storage::disk('public')->delete(
                    str_replace('storage/', '', $espacio->imagen_url)
                );
            }
            $path = $request->file('imagen')->store('espacios', 'public');
            $data['imagen_url'] = 'storage/' . $path;
        }

        // Si vienen "Otros" en edición, podrías tratarlo igual que en create

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
