@extends('layouts.app')

@section('title', 'Reservas')

@section('content')
    <h1>Mis Reservas</h1>
    <ul>
        @foreach ($reservas as $reserva)
            <li>
                <strong>Espacio:</strong> {{ $reserva->espacio->nombre }} <br>
                <strong>Fecha:</strong> {{ $reserva->fecha }} <br>
                <form action="{{ route('reservas.destroy', $reserva->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Eliminar Reserva</button>
                </form>
            </li>
        @endforeach
    </ul>

@endsection