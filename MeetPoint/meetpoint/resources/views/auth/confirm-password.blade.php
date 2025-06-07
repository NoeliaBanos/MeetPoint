@extends('layouts.app')

@section('title', 'Confirmar contraseña')

@section('content')
{{-- ------------------------------------------------------------------ --}}
{{--  Layout 50 / 50  – formulario + imagen                            --}}
{{-- ------------------------------------------------------------------ --}}
<section class="container-fluid py-5">
    <div class="row g-0">

        {{-- Columna 1: Formulario ------------------------------------- --}}
        <div class="col-12 col-lg-6 p-4 d-flex align-items-center justify-content-center">

            <div class="w-100" style="max-width:420px"> {{-- ancho máx. opcional --}}
                <h2 class="mb-3 text-center">Confirmar contraseña</h2>

                <p class="small text-muted mb-4 text-center">
                    Esta acción requiere tu contraseña. Por favor, confírmala para continuar.
                </p>

                <form method="POST" action="{{ route('password.confirm') }}"
                      class="needs-validation" novalidate>
                    @csrf

                    {{-- Contraseña --}}
                    <div class="form-floating mb-4">
                        <input  type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                id="password"
                                name="password"
                                placeholder="Contraseña"
                                required
                                autocomplete="current-password">
                        <label for="password">Contraseña</label>
                        <div class="invalid-feedback">
                            @error('password') {{ $message }} @else Introduce tu contraseña. @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Confirmar
                    </button>
                </form>
            </div>
        </div>

        {{-- Columna 2: Imagen ----------------------------------------- --}}
        <div class="col-12 col-lg-6">
            {{-- Sustituye la ruta por la imagen que quieras mostrar --}}
            <img  src="{{ asset('images/confirm-password-bg.jpg') }}"
                  alt="Imagen decorativa de confirmación de contraseña"
                  class="object-fit-cover w-100 h-100">
        </div>

    </div>
</section>

@include('partials.footer')
@endsection
