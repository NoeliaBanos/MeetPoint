@extends('layouts.app')

@section('title', 'Crear Espacio')

@section('content')
<div class="max-w-md mx-auto py-8 px-4">
    <h2 class="text-3xl font-semibold text-center text-teal-400 mb-6">Espacio</h2>
    <form action="{{ route('espacios.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Nombre --}}
        <div class="bg-white rounded-xl shadow p-4 mb-4">
            <label for="nombre" class="block text-gray-700 mb-2">Nombre espacio</label>
            <input
                type="text"
                name="nombre"
                id="nombre"
                value="{{ old('nombre') }}"
                required
                class="w-full p-3 rounded-xl shadow-inner focus:outline-none"
                placeholder="Nombre espacio"
            >
            @error('nombre')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Precio por hora --}}
        <div class="bg-white rounded-xl shadow p-4 mb-4">
            <label for="precio_hora" class="block text-gray-700 mb-2">Precio por hora</label>
            <input
                type="number"
                name="precio_hora"
                id="precio_hora"
                value="{{ old('precio_hora') }}"
                step="0.01"
                required
                class="w-full p-3 rounded-xl shadow-inner focus:outline-none"
                placeholder="Precio por hora"
            >
            @error('precio_hora')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Equipamiento --}}
        <div class="bg-white rounded-xl shadow p-4 mb-4">
            <label for="equipamiento" class="block text-gray-700 mb-2">Equipamiento (separar por comas)</label>
            <input
                type="text"
                name="equipamiento"
                id="equipamiento"
                value="{{ old('equipamiento') }}"
                class="w-full p-3 rounded-xl shadow-inner focus:outline-none"
                placeholder="Proyector, WiFi, Pizarra..."
            >
            @error('equipamiento')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Descripción --}}
        <div class="bg-white rounded-xl shadow p-4 mb-4">
            <label for="descripcion" class="block text-gray-700 mb-2">Descripción</label>
            <textarea
                name="descripcion"
                id="descripcion"
                rows="4"
                class="w-full p-3 rounded-xl shadow-inner focus:outline-none"
                placeholder="Descripción del espacio"
            >{{ old('descripcion') }}</textarea>
            @error('descripcion')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Imagen principal --}}
        <div class="bg-white rounded-xl shadow p-4 mb-6">
            <label for="imagen" class="block text-gray-700 mb-2">Imagen principal</label>
            <input
                type="file"
                name="imagen"
                id="imagen"
                accept="image/*"
                class="w-full p-2 rounded-xl shadow-inner focus:outline-none"
            >
            @error('imagen')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Botón Confirmar --}}
        <button
            type="submit"
            class="w-full bg-teal-400 hover:bg-teal-500 text-white font-bold py-3 rounded-full"
        >
            CONFIRMAR
        </button>
    </form>
</div>

@include('partials.footer')
@endsection
