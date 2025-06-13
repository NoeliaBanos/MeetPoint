@extends('layouts.app')

@section('title', 'Crear Reseña')

@section('content')
    <div class="max-w-md mx-auto py-8 px-4">
        <h2 class="text-3xl font-semibold text-center text-teal-400 mb-6">Reseña</h2>

        <form action="{{ route('resenas.store') }}" method="POST">
            @csrf

            {{-- Espacio --}}
            <div class="bg-white rounded-xl shadow p-4 mb-4">
                <label for="espacio_id" class="block text-gray-700 mb-2">Nombre de espacio</label>
                <select name="espacio_id" id="espacio_id" required
                    class="w-full p-3 rounded-xl shadow-inner focus:outline-none">
                    <option value="" disabled {{ empty(old('espacio_id', $espacioId ?? null)) ? 'selected' : '' }}>
                        Selecciona un espacio
                    </option>
                    @foreach ($espacios as $espacio)
                        <option value="{{ $espacio->id }}"
                            {{ old('espacio_id', $espacioId ?? null) == $espacio->id ? 'selected' : '' }}>
                            {{ $espacio->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('espacio_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Puntuación --}}
            <div class="bg-white rounded-xl shadow p-4 mb-4">
                <label for="calificacion" class="block text-gray-700 mb-2">Puntuación</label>
                <input type="number" name="calificacion" id="calificacion" min="1" max="5" step="1"
                    value="{{ old('calificacion') }}" required class="w-full p-3 rounded-xl shadow-inner focus:outline-none"
                    placeholder="Del 1 al 5">
                @error('calificacion')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Comentario --}}
            <div class="bg-white rounded-xl shadow p-4 mb-6">
                <label for="comentario" class="block text-gray-700 mb-2">Reseña</label>
                <textarea name="comentario" id="comentario" rows="4" class="w-full p-3 rounded-xl shadow-inner focus:outline-none"
                    placeholder="Escribe tu reseña...">{{ old('comentario') }}</textarea>
                @error('comentario')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Botón Confirmar --}}
            <button type="submit" class="w-full bg-teal-400 hover:bg-teal-500 text-white font-bold py-3 rounded-full">
                CONFIRMAR
            </button>
        </form>
    </div>

@endsection
