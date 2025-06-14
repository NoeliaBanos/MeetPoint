@extends('layouts.app')

@section('title', 'Iniciar sesión')

@section('content')

    <section class="contact-public">
        <div class="row g-0">
            {{-- Columna 1: Formulario --}}
            <div class="col-12 col-lg-6 form-column">
                <div class="form-container">
                    @if (session('status'))
                        <div class="alert alert-success text-center mb-4">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
                        @csrf

                        <h1 class="text-center">Iniciar sesión</h1>

                        {{-- Email --}}
                        <div class="form-floating mb-4">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" placeholder="nombre@ejemplo.com" value="{{ old('email') }}" required
                                autofocus>
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
                                id="password" name="password" placeholder="Contraseña" required>
                            <label for="password">Contraseña</label>
                            <div class="invalid-feedback">
                                @error('password')
                                    {{ $message }}
                                @else
                                    Introduce tu contraseña.
                                @enderror
                            </div>
                        </div>

                        {{-- Recordarme --}}
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                            <label class="form-check-label" for="remember_me">Recuérdame</label>
                        </div>

                        {{-- Acción --}}
                        <div class="d-flex justify-content-between align-items-center mb-5">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="pe-4">
                                    ¿Olvidaste tu contraseña?
                                </a>
                            @endif
                            <button type="submit" class="btn-custom">Entrar</button>
                        </div>

                        {{-- Enlace a registro --}}
                        <p class="text-center mt-4">
                            ¿No tienes cuenta?
                            <a href="{{ route('register') }}">
                                Regístrate
                            </a>
                        </p>
                    </form>
                </div>
            </div>

            {{-- Columna 2: Imagen --}}
            <div class="col-12 col-lg-6 image-column">
                <img src="{{ asset('images/fondo.jpg') }}" alt="Imagen decorativa de iniciar sesión" class="img-fluid h-70">
            </div>
        </div>
    </section>

@endsection
