@extends('layouts.app')

@section('title', 'Restablecer contraseña')

@section('content')
{{-- ------------------------------------------------------------------ --}}
{{--  Layout 50 / 50  – formulario + imagen                            --}}
{{-- ------------------------------------------------------------------ --}}
<section class="container-fluid py-5">
    <div class="row g-0">

        {{-- Columna 1: Formulario ------------------------------------- --}}
        <div class="col-12 col-lg-6 p-4 d-flex align-items-center justify-content-center">

            <div class="w-100" style="max-width:460px"> {{-- ancho máx. opcional --}}
                <form method="POST" action="{{ route('password.store') }}"
                      class="needs-validation" novalidate>
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <h2 class="mb-4 text-center">Restablecer contraseña</h2>

                    {{-- Email --}}
                    <div class="form-floating mb-3">
                        <input  type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                id="email"
                                name="email"
                                placeholder="nombre@ejemplo.com"
                                value="{{ old('email', $request->email) }}"
                                required
                                autofocus>
                        <label for="email">Email</label>
                        <div class="invalid-feedback">
                            @error('email') {{ $message }} @else Introduce un correo válido. @enderror
                        </div>
                    </div>

                    {{-- Nueva contraseña --}}
                    <div class="form-floating mb-3">
                        <input  type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                id="password"
                                name="password"
                                placeholder="Nueva contraseña"
                                required
                                autocomplete="new-password">
                        <label for="password">Nueva contraseña</label>
                        <div class="invalid-feedback">
                            @error('password') {{ $message }} @else Introduce la nueva contraseña. @enderror
                        </div>
                    </div>

                    {{-- Confirmación --}}
                    <div class="form-floating mb-4">
                        <input  type="password"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                id="password_confirmation"
                                name="password_confirmation"
                                placeholder="Confirmar contraseña"
                                required
                                autocomplete="new-password">
                        <label for="password_confirmation">Confirmar contraseña</label>
                        <div class="invalid-feedback">
                            @error('password_confirmation') {{ $message }} @else Repite la contraseña. @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Restablecer contraseña
                    </button>
                </form>
            </div>
        </div>

        {{-- Columna 2: Imagen ----------------------------------------- --}}
        <div class="col-12 col-lg-6">
            {{-- Sustituye la ruta por la imagen que quieras mostrar --}}
            <img  src="{{ asset('images/reset-bg.jpg') }}"
                  alt="Imagen decorativa de restablecer contraseña"
                  class="object-fit-cover w-100 h-100">
        </div>

    </div>
</section>

@include('partials.footer')
@endsection
