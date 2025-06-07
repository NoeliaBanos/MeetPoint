@extends('layouts.app')

@section('title', 'Mi perfil')

@section('content')
    <div class="max-w-3xl mx-auto py-8 px-4 container">

        @if ($user->role === 'admin')
            {{-- Panel Administrador (sin cambios) --}}
            <h2 class="mt-4 text-center">Panel administrador</h2>

            <div class="space-y-6">
                {{-- Espacios --}}
                <div class="text-center">
                    <div class="pt-4">
                        <h3 class="display">{{ \App\Models\Espacio::count() }}</h3>
                        <p>Espacios en total</p>
                    </div>
                    <a href="{{ route('resenas.index') }}" class="btn-custom">VER LISTA</a>
                    <a href="{{ route('espacios.create') }}" class="mt-4 btn-custom-sec">AÑADIR</a>
                </div>

                {{-- Reseñas --}}
                <div class="text-center">
                    <div class="pt-4">
                        <h3 class="display">{{ \App\Models\Resena::count() }}</h3>
                        <p>Reseñas en total</p>
                    </div>
                    <a href="{{ route('resenas.index') }}" class="btn-custom">VER LISTA</a>
                </div>

                {{-- Cerrar sesión --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-custom-sec mt-4 w-100">CERRAR SESIÓN</button>
                </form>
            </div>
        @else
            {{-- Perfil de usuario normal --}}
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

                    <h1 class="text-2xl font-semibold">{{ $user->name }} {{ $user->apellido }}</h1>
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

                {{-- Salas reservadas (futuras) --}}
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

                {{-- Salas usadas (pasadas) --}}
                <section class="pt-4">
                    @php($past = $user->reservas->where('fecha', '<', now()))
                    <h2 class="text-xl font-semibold mb-2">Salas usadas</h2>

                    @forelse($past as $r)
                        <div class="d-flex justify-content-between align-items-center mb-2 border-bottom pb-2">
                            <div>
                                <strong>{{ $r->espacio->nombre }}</strong> — {{ $r->fecha_hora->format('d/m/Y') }}
                            </div>
                            <div>
                                @if ($r->resena)
                                    <span class="text-warning fw-semibold">
                                        {{ $r->resena->calificacion }}/5
                                    </span>
                                @else
                                    <button class="btn-custom" data-bs-toggle="modal" data-bs-target="#crearResenaModal"
                                        data-espacio-id="{{ $r->espacio->id }}"
                                        data-espacio-nombre="{{ $r->espacio->nombre }}">
                                        Puntuar
                                    </button>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">No has usado ninguna sala aún.</p>
                    @endforelse
                </section>

                {{-- Cerrar sesión --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-custom-sec w-100">CERRAR SESIÓN</button>
                </form>
            </div>
        @endif

        {{-- Modal de reseña --}}
        <div class="modal fade" id="crearResenaModal" tabindex="-1" aria-labelledby="crearResenaModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content rounded-xl shadow">
                    <div class="modal-header">
                        <h3 class="pt-2 ps-2">Reseña</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <form method="POST" action="{{ route('resenas.store') }}">
                        @csrf
                        <input type="hidden" name="espacio_id" id="modalEspacioId">

                        <div class="modal-body">

                            {{-- Puntuación --}}
                            <div class="form-floating mb-3">
                                <input type="number" name="calificacion" id="modalCalificacion" min="1"
                                    max="5" step="1" class="form-control" placeholder="Puntuación del 1 al 5"
                                    required>
                                <label for="modalCalificacion">Puntuación (1-5)</label>
                                @error('calificacion')
                                    <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Comentario --}}
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

        {{-- Script dinámico para rellenar modal --}}
        @push('scripts')
            <script>
                console.log("Espacio ID:", espacioId);

                const crearResenaModal = document.getElementById('crearResenaModal');
                crearResenaModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const espacioId = button.getAttribute('data-espacio-id');
                    const espacioNombre = button.getAttribute('data-espacio-nombre');

                    document.getElementById('modalEspacioId').value = espacioId;
                    document.getElementById('modalNombreSala').textContent = espacioNombre;
                });
            </script>
        @endpush


    </div>
    {{-- Footer --}}
    @include('partials.footer')
@endsection
