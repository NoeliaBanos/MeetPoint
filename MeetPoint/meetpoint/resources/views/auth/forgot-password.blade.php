@extends('layouts.app')

@section('title', 'Recuperar contraseña')

@section('content')
{{-- ------------------------------------------------------------------ --}}
{{--  Layout 50 / 50  – texto + imagen                                 --}}
{{-- ------------------------------------------------------------------ --}}
<section class="container-fluid py-5">
    <div class="row g-0">

        {{-- Columna 1: Mensaje + formulario --------------------------- --}}
        <div class="col-12 col-lg-6 p-4 d-flex align-items-center justify-content-center">

            <div class="w-100" style="max-width:460px"> {{-- ancho máx. opcional --}}
                <h2 class="mb-3 text-center">¿Olvidaste tu contraseña?</h2>

                <p class="small text-muted mb-4">
                    Introduce tu email y te enviaremos un enlace para que puedas establecer una nueva contraseña.
                </p>

                {{-- Mensaje de estado --}}
                @if (session('status'))
                    <div class="alert alert-success small" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}"
                      class="needs-validation" novalidate>
                    @csrf

                    {{-- Email --}}
                    <div class="form-floating mb-4">
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

                    <button type="submit" class="btn btn-primary w-100">
                        Enviar enlace
                    </button>
                </form>
            </div>
        </div>

        {{-- Columna 2: Imagen ----------------------------------------- --}}
        <div class="col-12 col-lg-6">
            {{-- Sustituye la ruta por la imagen que quieras mostrar --}}
            <img  src="{{ asset('images/password-email-bg.jpg') }}"
                  alt="Imagen decorativa de recuperación de contraseña"
                  class="object-fit-cover w-100 h-100">
        </div>

    </div>
</section>

@include('partials.footer')
@endsection
