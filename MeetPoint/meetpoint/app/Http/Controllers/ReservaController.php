<?php

namespace App\Http\Controllers;

use App\Models\Espacio;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservaController extends Controller
{
    // 1) Mostrar formulario
    public function create(Espacio $espacio)
    {
        return view('reservas.create', compact('espacio'));
    }

    // 2) Almacenar y redirigir a pagar
    public function store(Request $request, Espacio $espacio)
    {
        $data = $request->validate([
            'fecha'        => 'required|date|after_or_equal:today',
            'hora_entrada' => 'required|date_format:H:i:s',   // ya viene HH:MM:SS
            'hora_salida'  => 'required|date_format:H:i:s|after:hora_entrada',
            'importe'      => 'required|numeric|min:0',
            'fecha_hora'   => 'required|date_format:Y-m-d H:i:s',
        ]);

        $reserva = $espacio->reservas()->create([
            'user_id'    => Auth::id(),
            //     'user_id'    => Auth::id(),
            'fecha'        => $data['fecha'],
            'fecha_hora'   => $data['fecha_hora'],
            'hora_entrada' => $data['hora_entrada'],
            'hora_salida'  => $data['hora_salida'],
            'pago_estado'  => 'pendiente',
            'importe'      => $data['importe'],
        ]);

        return redirect()->route('reservas.pay', $reserva);
    }

    // 3) AJAX para franjas ocupadas
    public function reservedIntervals(Request $req, Espacio $espacio)
    {
        $req->validate(['fecha' => 'required|date']);
        $intervals = $espacio->reservas()
            ->where('fecha', $req->fecha)
            ->get(['hora_entrada', 'hora_salida']);
        return response()->json($intervals);
    }

    // 4) Vista de pago
    public function pay(Reserva $reserva)
    {
        return view('reservas.pay', compact('reserva'));
    }
}
