<?php

namespace App\Http\Controllers;

use App\Models\Espacio;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservaController extends Controller
{
    /**
     * 1) Mostrar formulario de creación de reserva
     */
    public function create(Espacio $espacio)
    {
        return view('reservas.create', compact('espacio'));
    }

    /**
     * 2) Almacenar la reserva y redirigir al pago
     */
    public function store(Request $request, Espacio $espacio)
    {
        $data = $request->validate([
            'fecha'        => 'required|date|after_or_equal:today',
            'hora_entrada' => 'required|date_format:H:i:s',
            'hora_salida'  => 'required|date_format:H:i:s|after:hora_entrada',
            'importe'      => 'required|numeric|min:0',
        ]);

        $reserva = $espacio->reservas()->create([
            'user_id'      => Auth::id(),
            'fecha'        => $data['fecha'],
            'hora_entrada' => $data['hora_entrada'],
            'hora_salida'  => $data['hora_salida'],
            'pago_estado'  => 'pendiente',
            'importe'      => $data['importe'],
        ]);

        return redirect()->route('reservas.pay', $reserva);
    }

    /**
     * 3) Devuelve por JSON las franjas ya reservadas (AJAX)
     */
    public function reservedIntervals(Request $request, Espacio $espacio)
    {
        $request->validate(['fecha' => 'required|date']);

        $intervals = $espacio->reservas()
            ->where('fecha', $request->fecha)
            ->get(['hora_entrada', 'hora_salida']);

        return response()->json($intervals);
    }

    /**
     * 4) Mostrar la vista de pago
     */
    public function pay(Reserva $reserva)
    {
        return view('reservas.pay', compact('reserva'));
    }

    /**
     * 5) Cancelar (borrar) la reserva
     */
    public function cancelar(Reserva $reserva)
    {
        // Si necesitas control de autorización, descomenta la línea siguiente:
        // $this->authorize('cancelar', $reserva);

        $reserva->delete();

        return back()->with('status', 'Reserva cancelada correctamente.');
    }
}
