@extends('layouts.app')

@section('title', 'Restablecer contraseña')

@section('content')
<div class="max-w-md mx-auto py-10 px-4">
    <div class="bg-white shadow rounded-xl p-8 space-y-6">
        <h1 class="text-2xl font-semibold text-center mb-4">Restablecer contraseña</h1>

        <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            {{-- Email --}}
            <div>
                <label for="email" class="block font-medium mb-1">Email</label>
                <input id="email" type="email" name="email"
                       value="{{ old('email', $request->email) }}"
                       required autofocus
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-400">
                @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Contraseña nueva --}}
            <div>
                <label for="password" class="block font-medium mb-1">Nueva contraseña</label>
                <input id="password" type="password" name="password" required
                       autocomplete="new-password"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-400">
                @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Confirmación --}}
            <div>
                <label for="password_confirmation" class="block font-medium mb-1">Confirmar contraseña</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                       autocomplete="new-password"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-400">
                @error('password_confirmation') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="btn-custom w-full">
                Restablecer contraseña
            </button>
        </form>
    </div>
</div>

@include('partials.footer')
@endsection
