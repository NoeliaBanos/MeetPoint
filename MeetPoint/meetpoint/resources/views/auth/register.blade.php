@extends('layouts.app')

@section('title', 'Crear cuenta')

@section('content')
<div class="max-w-md mx-auto py-10 px-4">
    <div class="bg-white shadow rounded-xl p-8 space-y-6">
        <h1 class="text-2xl font-semibold text-center mb-4">Crear cuenta</h1>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            {{-- Nombre --}}
            <div>
                <label for="name" class="block font-medium mb-1">Nombre</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}"
                       required autofocus
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-400">
                @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Apellido (opcional) --}}
            <div>
                <label for="apellido" class="block font-medium mb-1">Apellido</label>
                <input id="apellido" type="text" name="apellido" value="{{ old('apellido') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-400">
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block font-medium mb-1">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       required autocomplete="username"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-400">
                @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Contraseña --}}
            <div>
                <label for="password" class="block font-medium mb-1">Contraseña</label>
                <input id="password" type="password" name="password" required
                       autocomplete="new-password"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-400">
                @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Confirmar contraseña --}}
            <div>
                <label for="password_confirmation" class="block font-medium mb-1">Confirmar contraseña</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                       autocomplete="new-password"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-400">
            </div>

            {{-- Acción --}}
            <button type="submit" class="btn-custom w-full">
                Registrarme
            </button>
        </form>

        {{-- Enlace a login --}}
        <p class="text-center text-sm mt-4">
            ¿Ya tienes cuenta?
            <a href="{{ route('login') }}" class="text-teal-500 font-semibold hover:underline">
                Iniciar sesión
            </a>
        </p>
    </div>
</div>

@include('partials.footer')
@endsection
