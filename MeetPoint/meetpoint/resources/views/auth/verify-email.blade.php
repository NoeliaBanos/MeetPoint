@extends('layouts.app')

@section('title', 'Verifica tu correo')

@section('content')
{{-- ------------------------------------------------------------------ --}}
{{--  Layout 50 / 50  – texto + imagen                                 --}}
{{-- ------------------------------------------------------------------ --}}
<section class="container-fluid py-5">
    <div class="row g-0">

        {{-- Columna 1: Mensaje y acciones ----------------------------- --}}
        <div class="col-12 col-lg-6 p-4 d-flex align-items-center justify-content-center">

            <div class="w-100" style="max-width:460px"> {{-- ancho máx. opcional --}}
                <p class="mb-4">
                    Gracias por registrarte. Te hemos enviado un correo con un enlace de verificación.
                    Si no lo has recibido, pulsa «Reenviar».
                </p>

                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success small" role="alert">
                        Se ha enviado un nuevo enlace a tu correo.
                    </div>
                @endif

                {{-- Reenviar enlace --}}
                <form method="POST" action="{{ route('verification.send') }}" class="mb-3">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100">
                        Reenviar correo de verificación
                    </button>
                </form>

                {{-- Cerrar sesión --}}
                <form method="POST" action="{{ route('logout') }}" class="mb-3">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary w-100">
                        Cerrar sesión
                    </button>
                </form>

                {{-- Volver a login --}}
                <div class="text-center">
                    <a href="{{ route('login') }}" class="small text-decoration-none">
                        &larr; Volver a iniciar sesión
                    </a>
                </div>
            </div>
        </div>

        {{-- Columna 2: Imagen ----------------------------------------- --}}
        <div class="col-12 col-lg-6">
            {{-- Sustituye la ruta por la imagen que quieras mostrar --}}
            <img  src="{{ asset('images/verify-bg.jpg') }}"
                  alt="Imagen decorativa de verificación de correo"
                  class="object-fit-cover w-100 h-100">
        </div>

    </div>
</section>

@include('partials.footer')
@endsection
