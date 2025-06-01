@extends('layouts.app')

@section('title', 'Iniciar sesión')

@section('content')
<div class="max-w-md mx-auto py-10 px-4">
    <div class="bg-white shadow rounded-xl p-8 space-y-6">
        <h1 class="text-2xl font-semibold text-center mb-4">Iniciar sesión</h1>

        @if (session('status'))
            <div class="text-sm text-green-600 text-center mb-4">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            {{-- Email --}}
            <div>
                <label for="email" class="block font-medium mb-1">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       required autofocus autocomplete="username"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-400">
                @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Contraseña --}}
            <div>
                <label for="password" class="block font-medium mb-1">Contraseña</label>
                <input id="password" type="password" name="password" required
                       autocomplete="current-password"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-400">
                @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Recordarme --}}
            <div class="flex items-center">
                <input id="remember_me" type="checkbox" name="remember"
                       class="rounded border-gray-300 text-teal-600 shadow-sm focus:ring-teal-400">
                <label for="remember_me" class="ms-2 text-sm text-gray-600">Recuérdame</label>
            </div>

            {{-- Acción --}}
            <div class="flex items-center justify-between">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-teal-500 hover:underline">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif
                <button type="submit" class="btn-custom">Entrar</button>
            </div>
        </form>

        {{-- Enlace a registro --}}
        <p class="text-center text-sm mt-4">
            ¿No tienes cuenta?
            <a href="{{ route('register') }}" class="text-teal-500 font-semibold hover:underline">
                Haz clic aquí
            </a>
        </p>
    </div>
</div>

@include('partials.footer')
@endsection
