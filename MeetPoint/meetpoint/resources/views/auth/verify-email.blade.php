@extends('layouts.app')

@section('title', 'Verifica tu correo')

@section('content')
<div class="container py-5">

    <div class="row g-0 justify-content-center">

        {{-- Columna 1: tarjeta con acciones --}}
        <div class="col-12 col-lg-6">

            <div class="bg-white shadow rounded p-4">

                <p class="mb-4">
                    Gracias por registrarte. Te hemos enviado un enlace de verificación a
                    <strong>{{ auth()->user()->email }}</strong>.
                    Si no lo recibes en unos minutos, pulsa «Reenviar».
                </p>

                @if (session('status') === 'verification-link-sent')
                    <div class="alert alert-success small" role="alert">
                        ¡Te acabamos de mandar un nuevo enlace! Revisa tu bandeja de entrada.
                    </div>
                @endif

                {{-- Reenviar enlace --}}
                <form method="POST" action="{{ route('verification.send') }}" class="mb-3">
                    @csrf
                    <button type="submit" class="btn-custom w-100">
                        Reenviar correo de verificación
                    </button>
                </form>

                {{-- Ir a mi perfil (por si el usuario quiere revisar algo) --}}
                <a href="{{ route('profile.show', auth()->id()) }}"
                   class="btn-secondary w-100 mb-3 text-center">
                    Ir a mi perfil
                </a>

                {{-- Cerrar sesión --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-custom-sec w-100">
                        Cerrar sesión
                    </button>
                </form>

            </div>

        </div>

        {{-- Columna 2: imagen decorativa, sólo en pantallas ≥ lg --}}
        <div class="col-lg-6 d-none d-lg-block">
            <img src="{{ asset('images/verify-bg.jpg') }}"
                 alt="Imagen de verificación"
                 class="object-fit-cover w-100 h-100 rounded-end">
        </div>

    </div>
</div>
@endsection
