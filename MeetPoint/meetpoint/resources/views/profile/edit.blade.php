@extends('layouts.app')

@section('title', 'Editar perfil')

@section('content')
    @php use Illuminate\Support\Facades\Storage; @endphp

    <div class="container py-5">
        {{-- Título --}}
        <h1 class="display-6 text-center mb-5">Editar perfil</h1>

        {{-- Mensaje flash --}}
        @if (session('status'))
            <div class="alert alert-success text-center">
                {{ session('status') }}
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-12 col-md-6">

                {{-- ─── Formulario: Datos básicos ─────────────────── --}}
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Nombre --}}
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">Nombre</label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}"
                            required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Apellidos --}}
                    <div class="mb-3">
                        <label for="apellidos" class="form-label fw-bold">Apellidos</label>
                        <input type="text" name="apellidos" id="apellidos"
                            class="form-control @error('apellidos') is-invalid @enderror"
                            value="{{ old('apellidos', $user->apellidos) }}">
                        @error('apellidos')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">Correo electrónico</label>
                        <input type="email" name="email" id="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Avatar --}}
                    <div class="mb-4">
                        <label for="avatar" class="form-label fw-bold">Foto de perfil</label>
                        <input type="file" name="avatar" id="avatar"
                            class="form-control @error('avatar') is-invalid @enderror" accept="image/*">
                        @error('avatar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        {{-- Vista previa: avatar de la BBDD o imagen por defecto --}}


                        @php
                            $avatarSrc = $user->imagen_url
                                ? asset('img_subidas/users/' . $user->imagen_url)
                                : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&size=64';
                        @endphp

                        <p class="py-2">Imagen anterior:</p>
                        <div style="width: 70px;">
                            <img src="{{ $avatarSrc }}" alt="Avatar de {{ $user->name }}"
                                style="border-radius:50%; object-fit:cover;">
                        </div>
                    </div>

                    {{-- Botones --}}
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('profile.show') }}" class="btn btn-secondary me-2">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </div>
                </form>

                {{-- Separador --}}
                <hr class="my-5">

                {{-- ─── Formulario: Cambiar contraseña ─────────────────── --}}
                <h2 class="fw-semibold text-center mb-4">Cambiar contraseña</h2>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('PUT')

                    {{-- Contraseña actual --}}
                    <div class="mb-3">
                        <label for="current_password" class="form-label fw-bold">Contraseña actual</label>
                        <input type="password" name="current_password" id="current_password"
                            class="form-control @error('current_password') is-invalid @enderror" required>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Nueva contraseña --}}
                    <div class="mb-3">
                        <label for="password" class="form-label fw-bold">Nueva contraseña</label>
                        <input type="password" name="password" id="password"
                            class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Confirmar contraseña --}}
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label fw-bold">Confirma la contraseña</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                            required>
                    </div>

                    {{-- Botón --}}
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Actualizar contraseña</button>
                    </div>
                </form>

            </div>{{-- /.col --}}
        </div>
    </div>

    @include('partials.footer')
@endsection
