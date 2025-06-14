@extends('layouts.app')

@section('title', 'Crear cuenta')

@section('content')

    <section class="contact-public">
        <div class="row g-0">
            {{-- Columna 1: Formulario --}}
            <div class="col-12 col-lg-6 form-column ">
                <div class="form-container">
                    <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate>
                        @csrf

                        <h1 class="text-center">Crear cuenta</h1>

                        {{-- Nombre --}}
                        <div class="form-floating mb-4">
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

                        {{-- Apellidos --}}
                        <div class="form-floating mb-4">
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
                                    {{ $message }}
                                @else
                                    Indica tus apellidos.
                                @enderror
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="form-floating mb-4">
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
                        <div class="form-floating mb-4">
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
                        <div class="d-flex justify-content-end mb-5">
                            <button type="submit" class="btn-custom">Registrarme</button>
                        </div>

                        {{-- Enlace a login --}}
                        <p class="text-center mt-4">
                            ¿Ya tienes cuenta?
                            <a href="{{ route('login') }}">
                                Iniciar sesión
                            </a>
                        </p>
                    </form>
                </div>
            </div>

            {{-- Columna 2: Imagen --}}
            <div class="col-12 col-lg-6 image-column">
                <img src="{{ asset('images/fondo.jpg') }}" alt="Imagen decorativa de registro" class="img-fluid h-100 object-fit-cover">
            </div>
        </div>
    </section>

@endsection