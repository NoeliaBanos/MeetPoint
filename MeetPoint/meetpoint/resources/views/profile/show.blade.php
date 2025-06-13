{{-- resources/views/profile/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Mi perfil')

@section('content')
    <div class="container py-5">
        @if ($user->role === 'admin')
            @include('profile._admin')
        @else
            {{-- Perfil Usuario --}}
            <div class="bg-white shadow rounded p-4">

                {{-- Datos personales --}}
                <div class="d-flex flex-column align-items-center mb-4 w-100">
                    @php
                        $avatarSrc = $user->imagen_url ? asset($user->imagen_url) : asset('images/profile.png');
                    @endphp
                    <img src="{{ $avatarSrc }}" alt="Avatar de {{ $user->name }}" class="rounded-circle mb-2"
                        style="width: 100px; height: 100px; object-fit: cover;">
                    <h1 class="text-center mb-1">{{ $user->name }} {{ $user->apellidos }}</h1>
                    <small class="text-muted text-center">{{ $user->email }}</small>
                </div>


                <!-- Botones de acción -->
                <div class="d-flex flex-wrap gap-2">

                    {{-- Modificar datos --}}
                    <a href="{{ route('profile.edit') }}" class="btn-custom flex-fill text-center">
                        Modificar datos
                    </a>

                    {{-- Cambiar contraseña --}}
                    <a href="{{ route('profile.password.edit') }}" class="btn-secondary text-center">
                        Cambiar contraseña
                    </a>

                    {{-- Verificar correo (solo si NO está verificado) --}}
                    @unless (auth()->user()->email_verified_at)
                        <form method="POST" action="{{ route('verification.send') }}" class="flex-fill">
                            @csrf
                            <button type="submit" class="btn-custom-sec w-100 text-center">
                                Verificar correo
                            </button>
                        </form>
                    @endunless

                </div>


                <!-- Crear sala (solo usuarios verificados) -->
                @if (auth()->user()->email_verified_at)
                    <a href="{{ route('espacios.create') }}" class="btn-custom-sec text-center">
                        Crear sala
                    </a>
                @endif

            </div>


            {{-- Salas futuras --}}
            @php
                $upcoming = $user->reservas
                    ->where('fecha', '>=', now())
                    ->sortBy('fecha_hora')
                    ->groupBy(fn($r) => $r->espacio_id . '—' . $r->fecha->toDateString());
            @endphp

            <h2 class="text-xl font-semibold ">Salas reservadas</h2>
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
                    <b>{{ $first->espacio->nombre }}</b> —
                    {{ $first->fecha_hora->format('d/m/Y') }} –
                    <b>Horas:</b> {{ $horas }}
                </p>
            @empty
                <p class="text-gray-500">No tienes reservas.</p>
            @endforelse

            {{-- Reseñas pasadas --}}
            @php
                $userReviews = $user->resenas()->with('espacio')->get();
                $pastReservations = $user
                    ->reservas()
                    // Si cada reserva dura 1 h a partir de fecha_hora:
                    ->where('fecha_hora', '<=', now()->subHour()) // <- ya terminó
                    ->doesntHave('resena')
                    ->with('espacio')
                    ->get();
            @endphp

            <h2 class="text-xl font-semibold ">Reseñas realizadas</h2>
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
                        <div class="text-sm fst-italic">
                            “{{ $review->comentario }}”
                        </div>
                    @endif
                </div>
            @empty
                <p class="text-gray-500">Aún no has realizado ninguna reseña.</p>
            @endforelse

            <h2 class="text-xl font-semibold">Salas pendientes de reseña</h2>
            @forelse($pastReservations as $reserva)
                <div class="mb-4 p-3 border border-dashed border-gray-300 rounded bg-gray-50">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $reserva->espacio->nombre }}</strong><br>
                            <small class="text-sm text-muted">{{ $reserva->fecha_hora->format('d/m/Y H:i') }}</small>
                        </div>
                        <div class="text-end">
                            <button class="btn btn-sm btn-custom" data-bs-toggle="modal" data-bs-target="#crearResenaModal"
                                data-espacio-id="{{ $reserva->espacio->id }}"
                                data-espacio-nombre="{{ $reserva->espacio->nombre }}">
                                Puntuar
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">No tienes salas pendientes de reseñar.</p>
            @endforelse

            {{-- Cerrar sesión --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-custom-sec w-100">CERRAR SESIÓN</button>
            </form>
    </div>
    @endif

    {{-- Modal Reseña --}}
    <div class="modal fade" id="crearResenaModal" tabindex="-1" aria-hidden="true">
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
                            <input type="number" name="calificacion" id="modalCalificacion" min="1" max="5"
                                step="1" class="form-control" placeholder="Puntuación del 1 al 5" required>
                            <label for="modalCalificacion">Puntuación (1-5)</label>
                            @error('calificacion')
                                <div class="text-danger mt-1 small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <textarea name="comentario" id="modalComentario" class="form-control" placeholder="Escribe tu reseña"
                                style="height:120px" required>{{ old('comentario') }}</textarea>
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
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Inicializar modal de reseña
            const modal = document.getElementById('crearResenaModal');
            modal.addEventListener('show.bs.modal', event => {
                const btn = event.relatedTarget;
                document.getElementById('modalEspacioId').value = btn.dataset.espacioId;
                document.getElementById('modalNombreSala').textContent = btn.dataset.espacioNombre;
            });
        });
    </script>
@endpush
