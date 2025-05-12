@extends('layouts.app')

@section('title', 'Cambiar contraseña')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Cambiar contraseña</h1>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form action="{{ route('password.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="current_password" class="form-label">Contraseña actual</label>
            <input type="password" name="current_password" id="current_password"
                   class="form-control @error('current_password') is-invalid @enderror">
            @error('current_password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Nueva contraseña</label>
            <input type="password" name="password" id="password"
                   class="form-control @error('password') is-invalid @enderror">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Repite la contraseña</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                   class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Actualizar contraseña</button>
    </form>
</div>
@endsection
