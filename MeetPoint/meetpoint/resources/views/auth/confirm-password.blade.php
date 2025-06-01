@extends('layouts.app')

@section('title', 'Confirmar contraseña')

@section('content')
<div class="max-w-md mx-auto py-10 px-4">
    <div class="bg-white shadow rounded-xl p-8 space-y-6">
        <h1 class="text-2xl font-semibold text-center mb-4">Confirmar contraseña</h1>

        <p class="text-sm text-gray-600">
            Esta acción requiere tu contraseña. Por favor, confírmala para continuar.
        </p>

        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
            @csrf

            <div>
                <label for="password" class="block font-medium mb-1">Contraseña</label>
                <input id="password" type="password" name="password" required
                       autocomplete="current-password"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-400">
                @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="btn-custom w-full">
                Confirmar
            </button>
        </form>
    </div>
</div>

@include('partials.footer')
@endsection
