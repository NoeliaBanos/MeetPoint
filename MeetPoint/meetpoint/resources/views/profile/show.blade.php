@extends('layouts.app')

@section('title', 'Mi perfil')

@section('content')
    <div class=" mx-auto py-8 px-4 container">

        @if ($user->role === 'admin')
            {{-- Panel Administrador --}}
            <h2 class="admin-panel-title">Panel administrador</h2>

            <div class="admin-stats-container">
                <div class="stat-card">
                    <div class="stat-content">
                        <h3 class="stat-value">{{ \App\Models\Espacio::count() }}</h3>
                        <p class="stat-label">Espacios en total</p>
                    </div>
                    <div class="stat-actions">
                        <a href="{{ route('espacios.index') }}" class="btn-primary">VER LISTA</a>
                        <a href="{{ route('espacios.create') }}" class="btn-secondary">AÑADIR</a>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-content">
                        <h3 class="stat-value">{{ \App\Models\Resena::count() }}</h3>
                        <p class="stat-label">Reseñas en total</p>
                    </div>
                    <div class="stat-actions">
                        <a href="{{ route('resenas.index') }}" class="btn-primary">VER LISTA</a>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="logout-form">
                    @csrf
                    <button type="submit" class="btn-logout">CERRAR SESIÓN</button>
                </form>
            </div>
        @else
            {{-- Perfil Usuario --}}
            <div class="bg-white shadow rounded p-4 m-4 space-y-6">

                {{-- Datos personales --}}
                <section>
                    @php
                        $avatarSrc = $user->imagen_url
                            ? asset('img_subidas/users/' . $user->imagen_url)
                            : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&size=64';
                    @endphp

                    <div style="width: 70px;">
                        <img src="{{ $avatarSrc }}" alt="Avatar de {{ $user->name }}" width="64" height="64"
                            style="border-radius:50%; object-fit:cover;">
                    </div>

                    <h1 class="text-2xl font-semibold">{{ $user->name }} {{ $user->apellidos }}</h1>
                    <p class="text-gray-600">{{ $user->email }}</p>
                    <a href="{{ route('profile.edit') }}" class="btn-custom w-50">Modificar datos</a>

                    @auth
                        <div class="text-end mb-4">
                            <a href="{{ route('espacios.create') }}" class="btn-custom-sec w-50 mt-2">
                                <i class="bi bi-plus-circle me-1"></i> Crear sala
                            </a>
                        </div>
                    @endauth
                </section>

                {{-- Salas futuras --}}
                @php
                    $upcoming = $user->reservas
                        ->where('fecha', '>=', now())
                        ->sortBy('fecha_hora')
                        ->groupBy(fn($r) => $r->espacio_id . '—' . $r->fecha->toDateString());
                @endphp

                <h2 class="text-xl font-semibold mb-2">Salas reservadas</h2>

                @forelse ($upcoming as $group)
                    @php
                        $first = $group->first();
                        $horas = $group
                            ->pluck('fecha_hora')
                            ->unique(fn($h) => $h->format('H:i'))
                            ->map->format('H:i')
                            ->implode(', ');
                    @endphp

                    <p class="mb-1">
                        <b>{{ $first->espacio->nombre }}</b> — {{ $first->fecha_hora->format('d/m/Y') }}
                        – <b>Horas:</b> {{ $horas }}
                    </p>
                @empty
                    <p class="text-gray-500">No tienes reservas.</p>
                @endforelse

                {{-- Salas pasadas --}}
                {{-- Salas pasadas --}}
                @php
                    // 1. Reseñas realizadas por el usuario
                    $userReviews = $user->resenas()->with('espacio')->get();

                    // 2. Reservas pasadas sin reseña
                    $pastReservations = $user
                        ->reservas()
                        ->where('fecha', '<', now())
                        ->doesntHave('resena')
                        ->with('espacio')
                        ->get();
                @endphp

                {{-- … sección de datos personales, próximas reservas, etc. … --}}

                <section class="pt-4">
                    {{-- 1. Reseñas realizadas --}}
                    <h2 class="text-xl font-semibold mb-4">Reseñas realizadas</h2>
                    @forelse($userReviews as $review)
                        <div class="mb-4 p-3 border border-gray-200 rounded shadow-sm bg-white">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <strong>{{ $review->espacio->nombre }}</strong><br>
                                    <small class="text-muted">{{ $review->created_at->format('d/m/Y') }}</small>
                                </div>
                                <div class="text-end">
                                    <span class="fw-bold text-dark">{{ $review->calificacion }}/5</span>
                                </div>
                            </div>
                            @if ($review->comentario)
                                <div class="text-sm text-gray-700 fst-italic">
                                    “{{ $review->comentario }}”
                                </div>
                            @endif
                        </div>
                    @empty
                        <p class="text-gray-500">Aún no has realizado ninguna reseña.</p>
                    @endforelse

                    {{-- 2. Salas pasadas pendientes de reseña --}}
                    <h2 class="text-xl font-semibold mb-4 mt-6">Salas pendientes de reseña</h2>
                    @forelse($pastReservations as $reserva)
                        <div class="mb-4 p-3 border border-dashed border-gray-300 rounded bg-gray-50">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $reserva->espacio->nombre }}</strong><br>
                                    <small
                                        class="text-sm text-muted">{{ $reserva->fecha_hora->format('d/m/Y H:i') }}</small>
                                </div>
                                <div class="text-end">
                                    <button class="btn btn-sm btn-custom" data-bs-toggle="modal"
                                        data-bs-target="#crearResenaModal" data-espacio-id="{{ $reserva->espacio->id }}"
                                        data-espacio-nombre="{{ $reserva->espacio->nombre }}">
                                        Puntuar
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">No tienes salas pendientes de reseñar.</p>
                    @endforelse
                </section>



                {{-- Cerrar sesión --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-custom-sec w-100">CERRAR SESIÓN</button>
                </form>
            </div>
        @endif

        {{-- Modal Reseña --}}
        <div class="modal fade" id="crearResenaModal" tabindex="-1" aria-labelledby="crearResenaModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content rounded-xl shadow">
                    <div class="modal-header">
                        <h3 class="pt-2 ps-2">
                            Reseña para <span id="modalNombreSala" class="text-muted small"></span>
                        </h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <form method="POST" action="{{ route('resenas.store') }}">
                        @csrf
                        <input type="hidden" name="espacio_id" id="modalEspacioId">

                        <div class="modal-body">
                            <div class="form-floating mb-3">
                                <input type="number" name="calificacion" id="modalCalificacion" min="1"
                                    max="5" step="1" class="form-control" placeholder="Puntuación del 1 al 5"
                                    required>
                                <label for="modalCalificacion">Puntuación (1-5)</label>
                                @error('calificacion')
                                    <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-floating mb-3">
                                <textarea name="comentario" id="modalComentario" class="form-control" placeholder="Escribe tu reseña"
                                    style="height: 120px" required>{{ old('comentario') }}</textarea>
                                <label for="modalComentario">Reseña</label>
                                @error('comentario')
                                    <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn-custom">Confirmar</button>
                            <button type="button" class="btn btn-custom-sec" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Script del Modal --}}
        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const modal = document.getElementById('crearResenaModal');
                    modal.addEventListener('show.bs.modal', function(event) {
                        const button = event.relatedTarget;
                        const espacioId = button.getAttribute('data-espacio-id');
                        const espacioNombre = button.getAttribute('data-espacio-nombre');
                        document.getElementById('modalEspacioId').value = espacioId;
                        document.getElementById('modalNombreSala').textContent = espacioNombre;
                    });
                });
            </script>
        @endpush

    </div>

    {{-- Footer --}}
    @include('partials.footer')
@endsection
