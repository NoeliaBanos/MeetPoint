{{-- resources/views/profile/edit-password.blade.php --}}
@extends('layouts.app')

@section('title', 'Cambiar contraseña')

@section('content')
    <div class="container py-5">
        <h1 class="display-6 text-center mb-4">Cambiar contraseña</h1>

        {{-- Mensaje de éxito --}}
        @if(session('status'))
            <div class="alert alert-success text-center">
                {{ session('status') }}
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-12 col-md-6">

                <form action="{{ route('profile.password.update') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')

                    {{-- Contraseña actual --}}
                    <div class="form-floating mb-3">
                        <input type="password"
                               name="current_password"
                               id="current_password"
                               class="form-control @error('current_password') is-invalid @enderror"
                               placeholder=" "
                               required>
                        <label for="current_password">Contraseña actual</label>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Nueva contraseña --}}
                    <div class="form-floating mb-3">
                        <input type="password"
                               name="password"
                               id="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder=" "
                               required>
                        <label for="password">Nueva contraseña</label>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Confirmar nueva contraseña --}}
                    <div class="form-floating mb-4">
                        <input type="password"
                               name="password_confirmation"
                               id="password_confirmation"
                               class="form-control"
                               placeholder=" "
                               required>
                        <label for="password_confirmation">Confirmar contraseña</label>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn-custom">Actualizar contraseña</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
