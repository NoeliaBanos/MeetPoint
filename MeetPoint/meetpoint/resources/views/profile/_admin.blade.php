 @section('title', 'Mi perfil')

@section('content')
 {{-- Panel Administrador --}}
            <h1 class="text-center">Panel administrador</h1>

            <div class="admin-stats-container">
                <div class="stat-card">
                    <div class="stat-content">
                        <h3 class="stat-value">{{ \App\Models\Espacio::count() }}</h3>
                        <p class="stat-label">Espacios en total</p>
                    </div>
                    <div class="stat-actions">
                        <a href="{{ route('espacios.index') }}" class="btn-custom">VER LISTA</a>
                        <a href="{{ route('espacios.create') }}" class="btn-custom-sec">AÑADIR</a>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-content">
                        <h3 class="stat-value">{{ \App\Models\Resena::count() }}</h3>
                        <p class="stat-label">Reseñas en total</p>
                    </div>
                    <div class="stat-actions">
                        <a href="{{ route('resenas.index') }}" class="btn-custom">VER LISTA</a>
                    </div>
                </div>
                

                <form method="POST" action="{{ route('logout') }}" class="logout-form">
                    @csrf
                    <button type="submit" class="btn-custom-dark w-100">CERRAR SESIÓN</button>
                </form>
            </div>
            @extends('layouts.app')


@endsection