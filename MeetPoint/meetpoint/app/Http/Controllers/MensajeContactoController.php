<?php

namespace App\Http\Controllers;

use App\Models\MensajeContacto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MensajeContactoController extends Controller
{
    /**
     * Mostrar FAQ + formulario o listado de mensajes si es admin.
     */
    public function create()
    {
        // Si el usuario está autenticado y es admin, cargamos los mensajes
        if (Auth::check() && Auth::user()->role === 'admin') {
            $mensajes = MensajeContacto::latest()->get();
        } else {
            // Para invitados o usuarios normales, devolvemos un conjunto vacío
            $mensajes = collect();
        }

        return view('contacto.create', compact('mensajes'));
    }

    /**
     * Almacenar un nuevo mensaje de contacto.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'asunto'   => 'required|string|max:255',
            'email'    => 'required|email',
            'telefono' => 'nullable|string|max:20',
            'mensaje'  => 'required|string',
        ]);

        MensajeContacto::create($data);

        return back()->with('status', 'Tu mensaje ha sido enviado.');
    }

  
public function destroy(MensajeContacto $mensaje)
{
    // Solo admin
    if (! Auth::check() || Auth::user()->role !== 'admin') {
        abort(403, 'No autorizado');
    }

    $mensaje->delete();

    return back()->with('status', 'Mensaje eliminado.');
}
}