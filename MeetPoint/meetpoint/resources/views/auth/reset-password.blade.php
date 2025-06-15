@extends('layouts.app')

@section('title', 'Recuperar contraseña')

@section('content')

<section class="contact-public">
    <div class="row g-0">
        {{-- Columna 1: Formulario --}}
        <div class="col-12 col-lg-6 form-column">
            <div class="form-wrapper">
                <div class="form-intro">
                    <div class="password-icon">
                       
                    </div>
                    <h1 class="form-title">¿Olvidaste tu contraseña?</h1>
                    <p class="form-description">
                        No te preocupes, te enviaremos un enlace seguro para que puedas crear una nueva contraseña.
                    </p>
                </div>

                @if (session('status'))
                    <div class="alert-message success">
                       
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="auth-form">
                    @csrf

                    <div class="form-group">
                        <label for="email" class="input-label">
                           
                            <span>Correo electrónico</span>
                        </label>
                        <input type="email" 
                               class="form-input @error('email') error @enderror" 
                               id="email" 
                               name="email" 
                               placeholder="tucorreo@ejemplo.com" 
                               value="{{ old('email') }}" 
                               required 
                               autofocus>
                        @error('email')
                            <p class="error-message">{{ $message }}</p>
                        @else
                            <p class="helper-text">Introduce el email asociado a tu cuenta</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn-custom w-100">
                      
                        <span >Enviar enlace de recuperación</span>
                    </button>

                    <div class="form-footer pt-2 text-center">
                        <a href="{{ route('login') }}" class="text-link mt-4">
                           
                            <span>Volver al inicio de sesión</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Columna 2: Imagen --}}
        <div class="col-12 col-lg-6 image-column">
            <div class="image-overlay"></div>
            <img src="{{ asset('images/fondo.jpg') }}" 
                 alt="Imagen decorativa de recuperación de contraseña" 
                 class="auth-image">
            <div class="image-credits">
                <span>© 2023 TuEmpresa. Todos los derechos reservados.</span>
            </div>
        </div>
    </div>
</section>

@endsection