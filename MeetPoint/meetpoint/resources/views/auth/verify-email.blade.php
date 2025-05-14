@extends('layouts.app')

@section('title', 'Verifica tu correo')

@section('content')
<div class="max-w-md mx-auto py-8 px-4">
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <p class="text-gray-700">
            Gracias por registrarte. Antes de continuar, ¿podrías verificar tu correo
            haciendo clic en el enlace que te hemos enviado? Si no lo has recibido,
            con gusto te enviaremos otro.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="bg-green-100 border border-green-300 text-green-700 rounded-xl p-4 mb-6">
            <p>Hemos enviado un nuevo enlace de verificación a tu correo.</p>
        </div>
    @endif

    <div class="space-y-4">
        {{-- Reenviar correo --}}
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button
                type="submit"
                class="w-full bg-teal-400 hover:bg-teal-500 text-white font-bold py-3 rounded-full"
            >
                Reenviar correo de verificación
            </button>
        </form>

        {{-- Cerrar sesión --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button
                type="submit"
                class="w-full bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-3 rounded-full"
            >
                Cerrar sesión
            </button>
        </form>
    </div>
</div>

@include('partials.footer')
@endsection
