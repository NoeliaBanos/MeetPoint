@extends('layouts.app')

@section('title', 'Iniciar sesión')

@section('content')
{{-- ------------------------------------------------------------------ --}}
{{--  Layout 50 / 50  – formulario + imagen                            --}}
{{-- ------------------------------------------------------------------ --}}
<section class="container-fluid py-5">
    <div class="row g-0">

        {{-- Columna 1: Formulario ------------------------------------- --}}
        <div class="col-12 col-lg-6 p-4 d-flex align-items-center justify-content-center">

            <div class="w-100" style="max-width:420px"> {{-- ancho máx. opcional --}}
                {{-- Mensaje de estado (p.e. “Contraseña restablecida”) --}}
                @if(session('status'))
                    <div class="alert alert-success text-center mb-4">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}"
                      class="needs-validation" novalidate>
                    @csrf

                    <h2 class="mb-4 text-center">Iniciar sesión</h2>

                    {{-- Email --}}
                    <div class="form-floating mb-3">
                        <input  type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                id="email"
                                name="email"
                                placeholder="nombre@ejemplo.com"
                                value="{{ old('email') }}"
                                required
                                autofocus>
                        <label for="email">Email</label>
                        <div class="invalid-feedback">
                            @error('email') {{ $message }} @else Introduce un correo válido. @enderror
                        </div>
                    </div>

                    {{-- Contraseña --}}
                    <div class="form-floating mb-3">
                        <input  type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                id="password"
                                name="password"
                                placeholder="Contraseña"
                                required>
                        <label for="password">Contraseña</label>
                        <div class="invalid-feedback">
                            @error('password') {{ $message }} @else Introduce tu contraseña. @enderror
                        </div>
                    </div>

                    {{-- Recordarme --}}
                    <div class="form-check mb-3">
                        <input  class="form-check-input"
                                type="checkbox"
                                id="remember_me"
                                name="remember">
                        <label class="form-check-label" for="remember_me">Recuérdame</label>
                    </div>

                    {{-- Acción --}}
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        @if (Route::has('password.request'))
                            <a  href="{{ route('password.request') }}"
                                class="small text-teal-600 text-decoration-none">
                                ¿Olvidaste tu contraseña?
                            </a>
                        @endif
                        <button type="submit" class="btn-custom">Entrar</button>
                    </div>

                    {{-- Enlace a registro --}}
                    <p class="text-center small">
                        ¿No tienes cuenta?
                        <a href="{{ route('register') }}" class="text-decoration-none fw-semibold">
                            Regístrate
                        </a>
                    </p>
                </form>
            </div>
        </div>

        {{-- Columna 2: Imagen ----------------------------------------- --}}
         <div class="col-12 col-lg-6  p-0 img-half ">
            <img src="{{ asset('images/fondo.jpg') }}" alt="Imagen decorativa de contacto"
                class="img-fluid object-fit-cover">
        </div>

    </div>
</section>

{{-- Si tu layout no incluye el footer, lo añades aquí --}}
@include('partials.footer')
@endsection
