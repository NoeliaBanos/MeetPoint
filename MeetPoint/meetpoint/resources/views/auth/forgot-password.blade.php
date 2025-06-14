@extends('layouts.app')

@section('title', 'Recuperar contraseña')

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

                    <form method="POST" action="{{ route('password.email') }}" class="needs-validation" novalidate>
                        @csrf

                        <h1 class="text-center">Recupera tu contraseña</h1>
                        
                        <p class="text-center mb-4">
                            Introduce tu dirección de correo electrónico y te enviaremos un enlace para restablecer tu contraseña.
                        </p>

                        {{-- Email --}}
                        <div class="form-floating mb-4">
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   placeholder="nombre@ejemplo.com" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autofocus>
                            <label for="email">Correo electrónico</label>
                            <div class="invalid-feedback">
                                @error('email') 
                                    {{ $message }} 
                                @else 
                                    Introduce un correo válido. 
                                @enderror
                            </div>
                        </div>

                        {{-- Acción --}}
                        <div class="d-flex justify-content-end mb-5">
                            <button type="submit" class="btn-custom w-100">Enviar enlace</button>
                        </div>

                        {{-- Enlace a login --}}
                        <p class="text-center mt-4">
                            <a href="{{ route('login') }}">
                                Volver al inicio de sesión
                            </a>
                        </p>
                    </form>
                </div>
            </div>

            {{-- Columna 2: Imagen --}}
            <div class="col-12 col-lg-6 image-column">
                <img src="{{ asset('images/fondo.jpg') }}" 
                     alt="Imagen decorativa de recuperación de contraseña" 
                     class="img-fluid h-100 object-fit-cover">
            </div>
        </div>
    </section>

@endsection