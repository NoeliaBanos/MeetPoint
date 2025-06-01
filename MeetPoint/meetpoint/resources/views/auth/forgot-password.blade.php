@extends('layouts.app')

@section('title', 'Recuperar contraseña')

@section('content')
<div class="max-w-md mx-auto py-10 px-4">
    <div class="bg-white shadow rounded-xl p-8 space-y-6">
        <h1 class="text-2xl font-semibold text-center mb-4">¿Olvidaste tu contraseña?</h1>

        <p class="text-sm text-gray-600">
            Introduce tu email y te enviaremos un enlace para que puedas establecer una nueva contraseña.
        </p>

        {{-- Mensaje de estado --}}
        @if (session('status'))
            <p class="text-green-600 text-sm text-center">{{ session('status') }}</p>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block font-medium mb-1">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       required autofocus
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-400">
                @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="btn-custom w-full">
                Enviar enlace
            </button>
        </form>
    </div>
</div>

@include('partials.footer')
@endsection
