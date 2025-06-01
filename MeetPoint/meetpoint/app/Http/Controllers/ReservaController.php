<?php

namespace App\Http\Controllers;

use App\Models\Espacio;
use App\Models\Reserva;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservaController extends Controller
{
    
    /* -------- 1. Selector -------- */
    public function create(Espacio $espacio)
    {
        return view('reservas.create', compact('espacio'));
    }

    /* -------- 2. Guardar y redirigir -------- */
   public function store(Request $request, Espacio $espacio)
{
    $request->validate([
        'fecha'    => 'required|date|after_or_equal:today',
        'hours'    => 'required|array|min:1',
        'hours.*'  => 'integer|between:9,21',
    ]);

    $firstReserva = null; // guardaremos la primera para la redirección

    foreach ($request->hours as $hour) {
        $hour = (int) $hour;                                           // ← cast

        $fechaHora = Carbon::parse($request->fecha)
                           ->setHour($hour)
                           ->setMinute(0)
                           ->setSecond(0);

        $reserva = Reserva::create([
            'user_id'    => Auth::id(),
            'espacio_id' => $espacio->id,
            'fecha'      => $request->fecha,
            'fecha_hora' => $fechaHora,
            'importe'    => $espacio->precio_hora,
        ]);

        $firstReserva ??= $reserva;    // almacena la primera creada
    }

    /* redirige usando la clave explícita */
    return redirect()->route('reservas.pay', ['reserva' => $firstReserva]);
}


    /* -------- 3. Horas disponibles AJAX -------- */
  public function availableHours(Request $request, Espacio $espacio)
{
    $request->validate(['date' => 'required|date']);

    // horas ya reservadas (9-21)
    $ocupadas = Reserva::where('espacio_id', $espacio->id)
                       ->whereDate('fecha', $request->date)
                       ->pluck('fecha_hora')
                       ->map(fn ($fh) => (int) Carbon::parse($fh)->format('H'));

    $libres = collect(range(9, 21))
              ->diff($ocupadas)
              ->values();          // p.ej. [9, 10, 11, 14]

    return response()->json($libres);
}



    /* -------- 4. Pagar -------- */
    public function pay(Reserva $reserva)
    {
        $paypalUser = config('services.paypalme.user');

        return view('reservas.pay', compact('reserva', 'paypalUser'));
    }
    public function markPaid(Request $request, Reserva $reserva)
{
    // si la reserva ya existe, solo cambia el estado:
    $reserva->update(['pago_estado' => 'pagado']);

    /* Si quisieras crear la fila aquí (en lugar de antes),
       tendrás que recibir espacio_id, fecha y hours vía $request
       y hacer el create() igual que en store(). */

    return response()->json(['ok' => true]);
}

}
