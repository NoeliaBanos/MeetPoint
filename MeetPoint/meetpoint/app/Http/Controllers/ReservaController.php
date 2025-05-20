<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Reserva;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ReservaController extends Controller
{
    /**
     * Mostrar formulario de reserva para un espacio.
     */
    public function create(Request $request, $espacioId)
    {
        $hours = range(8, 21);
        return view('reservas.create', [
            'espacio' => \App\Models\Espacio::findOrFail($espacioId),
            'hours'   => $hours,
        ]);
    }

    /**
     * Procesar reserva via AJAX y devolver JSON.
     */
    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'espacio_id' => 'required|exists:espacios,id',
            'date'       => 'required|date',
            'hours'      => 'required|array',
            'hours.*'    => 'integer|min:8|max:21',
        ]);

        if ($v->fails()) {
            return response()->json([
                'errors' => $v->errors()
            ], 422);
        }

        $data = $v->validated();

        foreach ($data['hours'] as $hour) {
            $fechaHora = Carbon::parse($data['date'])
                               ->setHour($hour)
                               ->setMinute(0)
                               ->setSecond(0);

            Reserva::create([
                'user_id' => Auth::id(),
                'espacio_id' => $data['espacio_id'],
                'fecha_hora' => $fechaHora,
            ]);
        }

        return response()->json(['status' => 'ok']);
    }

    /**
     * Listado de todas las reservas (página de admin/dashboard).
     */
    public function index()
    {
        $reservas = Reserva::all();
        return view('reservas.index', compact('reservas'));
    }

    /**
     * Eliminar una reserva.
     */
    public function destroy($id)
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->delete();
        return redirect()->route('reservas.index')
                         ->with('status', 'Reserva eliminada correctamente.');
    }
}