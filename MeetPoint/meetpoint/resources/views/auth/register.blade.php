@extends('layouts.app')

@section('title', 'Crear cuenta')

@section('content')
    {{-- ------------------------------------------------------------------ --}}
    {{--  Layout 50 / 50  – formulario + imagen                            --}}
    {{-- ------------------------------------------------------------------ --}}
    <section class="container-fluid py-5">
        <div class="row g-0">

            {{-- Columna 1: Formulario ------------------------------------- --}}
            <div class="col-12 col-lg-6 p-4 d-flex align-items-center justify-content-center">

                <div class="w-100" style="max-width:460px"> {{-- ancho máx. opcional --}}
                    <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate>
                        @csrf

                        <h2 class="mb-4 text-center">Crear cuenta</h2>

                        {{-- Nombre --}}
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" placeholder="Nombre" value="{{ old('name') }}" required autofocus>
                            <label for="name">Nombre</label>
                            <div class="invalid-feedback">
                                @error('name')
                                    {{ $message }}
                                @else
                                    Indica tu nombre.
                                @enderror
                            </div>
                        </div>
{{-- Apellidos (obligatorio) --}}
<div class="form-floating mb-3">
    <input type="text"
           class="form-control @error('apellidos') is-invalid @enderror"
           id="apellidos"
           name="apellidos"
           placeholder="Apellidos"
           value="{{ old('apellidos') }}"
           required>
    <label for="apellidos">Apellidos</label>
    <div class="invalid-feedback">
        @error('apellidos')
            {{ $message }}   {{-- mensaje que venga de la validación --}}
        @else
            Indica tus apellidos.
        @enderror
    </div>
</div>


                        {{-- Email --}}
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" placeholder="nombre@ejemplo.com" value="{{ old('email') }}" required
                                autocomplete="username">
                            <label for="email">Email</label>
                            <div class="invalid-feedback">
                                @error('email')
                                    {{ $message }}
                                @else
                                    Introduce un correo válido.
                                @enderror
                            </div>
                        </div>

                        {{-- Contraseña --}}
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" placeholder="Contraseña" required
                                autocomplete="new-password">
                            <label for="password">Contraseña</label>
                            <div class="invalid-feedback">
                                @error('password')
                                    {{ $message }}
                                @else
                                    Introduce una contraseña.
                                @enderror
                            </div>
                        </div>

                        {{-- Confirmar contraseña --}}
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" placeholder="Confirmar contraseña" required
                                autocomplete="new-password">
                            <label for="password_confirmation">Confirmar contraseña</label>
                            <div class="invalid-feedback">
                                Repite la contraseña.
                            </div>
                        </div>

                        {{-- Acción --}}
                        <button type="submit" class="btn-custom w-100">
                            Registrarme
                        </button>

                        {{-- Enlace a login --}}
                        <p class="text-center small mt-4">
                            ¿Ya tienes cuenta?
                            <a href="{{ route('login') }}" class="text-decoration-none fw-semibold">
                                Iniciar sesión
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

    @include('partials.footer')
@endsection
