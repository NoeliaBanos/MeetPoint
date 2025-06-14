@extends('layouts.app')

@section('title', 'Confirmar contraseña')

@section('content')

<section class="confirm-password-section">
    <div class="row g-0">
        {{-- Columna 1: Formulario --}}
        <div class="col-12 col-lg-6 form-column">
            <div class="form-container">
                <div class="form-header">
                    <i class="fas fa-shield-alt icon"></i>
                    <h1>Confirmar contraseña</h1>
                    <p class="instruction-text">
                        Por seguridad, confirma tu contraseña para continuar con esta acción.
                    </p>
                </div>

                <form method="POST" action="{{ route('password.confirm') }}" class="needs-validation" novalidate>
                    @csrf

                    {{-- Contraseña --}}
                    <div class="form-floating mb-4">
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               placeholder="Contraseña" 
                               required 
                               autocomplete="current-password">
                        <label for="password">
                            <i class="fas fa-lock"></i> Contraseña
                        </label>
                        <div class="invalid-feedback">
                            @error('password') {{ $message }} @else Introduce tu contraseña. @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn-custom w-100">
                        <i class="fas fa-check-circle"></i> Confirmar
                    </button>

                    @if (Route::has('password.request'))
                        <div class="text-center mt-4">
                            <a href="{{ route('password.request') }}" class="forgot-password-link">
                                <i class="fas fa-question-circle"></i> ¿Olvidaste tu contraseña?
                            </a>
                        </div>
                    @endif
                </form>
            </div>
        </div>

        {{-- Columna 2: Imagen --}}
        <div class="col-12 col-lg-6 image-column">
            <div class="image-overlay"></div>
            <img src="{{ asset('images/confirm-password-bg.jpg') }}" 
                 alt="Imagen decorativa de confirmación de contraseña" 
                 class="img-fluid h-100">
        </div>
    </div>
</section>

@endsection