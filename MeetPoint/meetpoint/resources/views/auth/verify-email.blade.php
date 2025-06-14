@extends('layouts.app')

@section('title', 'Verifica tu correo')

@section('content')

    <section class="contact-public">
        <div class="row g-0">
            {{-- Columna 1: Contenido --}}
            <div class="col-12 col-lg-6 form-column">
                <div class="form-container">
                    <h1 class="text-center mb-4">Verifica tu correo</h1>

                    <p class="mb-4 text-center">
                        Te hemos enviado un enlace de verificación a
                        <strong>{{ auth()->user()->email }}</strong>.
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <div class="alert alert-success text-center mb-4">
                            ¡Te acabamos de mandar un nuevo enlace! Revisa tu bandeja de entrada.
                        </div>
                    @endif

                    {{-- Reenviar enlace --}}
                    <form method="POST" action="{{ route('verification.send') }}" class="mb-4">
                        @csrf
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn-custom">
                                Reenviar correo de verificación
                            </button>
                        </div>
                    </form>

                    {{-- Ir a mi perfil --}}
                    <div class="mb-4">
                        <a href="{{ route('profile.show', auth()->id()) }}"
                           class="btn-custom-sec w-100 text-center">
                            Ir a mi perfil
                        </a>
                    </div>

                    {{-- Cerrar sesión --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn-custom">
                                Cerrar sesión
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Columna 2: Imagen --}}
            <div class="col-12 col-lg-6 image-column">
                <img src="{{ asset('images/verify-bg.jpg') }}"
                     alt="Imagen de verificación"
                     class="img-fluid h-100 object-fit-cover">
            </div>
        </div>
    </section>

@endsection