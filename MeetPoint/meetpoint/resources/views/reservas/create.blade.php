@extends('layouts.app')

@section('title', 'Reservar Sala')

@section('content')
<div class="max-w-md mx-auto py-8 px-4">
    <h2 class="text-3xl font-semibold text-center text-teal-400 mb-6">
        Reservar: {{ $espacio->nombre }}
    </h2>

    <form action="{{ route('reservas.store') }}" method="POST" class="space-y-4">
        @csrf

        {{-- Hidden espacio_id --}}
        <input type="hidden" name="espacio_id" value="{{ $espacio->id }}">

        {{-- Fecha --}}
        <div>
            <label for="date" class="block text-gray-700 mb-1">Fecha</label>
            <input type="date" name="date" id="date"
                   class="w-full p-3 rounded-xl shadow-inner focus:outline-none"
                   value="{{ old('date') }}" required>
            @error('date')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Horas --}}
        <div>
            <p class="text-gray-700 mb-2">Selecciona las horas:</p>
            <div class="grid grid-cols-4 gap-2">
                @foreach($hours as $h)
                    <label class="inline-flex items-center">
                        <input type="checkbox"
                               name="hours[]"
                               value="{{ $h }}"
                               class="form-checkbox">
                        <span class="ml-2">{{ $h }}:00 – {{ $h+1 }}:00</span>
                    </label>
                @endforeach
            </div>
            @error('hours')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Botón --}}
        <button type="submit"
                class="w-full bg-teal-400 hover:bg-teal-500 text-white font-bold py-3 rounded-full">
            Confirmar Reserva
        </button>
    </form>
</div>

@include('partials.footer')
@endsection
