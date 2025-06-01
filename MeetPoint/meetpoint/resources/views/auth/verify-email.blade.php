@extends('layouts.app')

@section('title', 'Verifica tu correo')

@section('content')
<div class="max-w-md mx-auto py-10 px-4">
    <div class="bg-white rounded-xl shadow p-6 mb-6 space-y-4">
        <p class="text-gray-700">
            Gracias por registrarte. Te hemos enviado un email con un enlace de verificación.
            Si no lo has recibido, pulsa «Reenviar».
        </p>

        @if (session('status') == 'verification-link-sent')
            <p class="text-green-600 text-sm">
                Se ha enviado un nuevo enlace a tu correo.
            </p>
        @endif

        {{-- Reenviar --}}
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn-custom w-full">
                Reenviar correo de verificación
            </button>
        </form>

        {{-- Cerrar sesión --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-custom-sec w-full">
                Cerrar sesión
            </button>
        </form>

        {{-- Volver a login --}}
        <div class="text-center">
            <a href="{{ route('login') }}" class="text-teal-500 hover:underline text-sm">
                &larr; Volver a iniciar sesión
            </a>
        </div>
    </div>
</div>

@include('partials.footer')
@endsection
