{{-- resources/views/profile/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Mi perfil')

@section('content')
    <div class="container profile-container">
        @if ($user->role === 'admin')
            @include('profile._admin')
        @else
            {{-- Perfil Usuario --}}
            <div class="profile-card">

                {{-- Datos personales --}}
                <div class="profile-header">
                    @php
                        $avatarSrc = $user->imagen_url ? asset($user->imagen_url) : asset('images/profile.png');
                    @endphp
                    <div class="avatar-wrapper">
                        @php
                            // Ruta relativa dentro de public/
                            $imgPath = 'img_subidas/users/' . $user->imagen_url;

                            // Si hay imagen y existe en disco, la usamos; si no, la genérica
                            $avatarSrc =
                                !empty($user->imagen_url) && file_exists(public_path($imgPath))
                                    ? asset($imgPath)
                                    : asset('images/profile.png');
                        @endphp

                        <div>
                            <img src="{{ $avatarSrc }}" alt="Avatar de {{ $user->name }}">
                        </div>
                    </div>

                    <div class="profile-info">
                        <h1 class="profile-name">{{ $user->name }} {{ $user->apellidos }}</h1>
                        <div class="profile-meta">
                            <span class="profile-email">{{ $user->email }}</span>
                            @if (auth()->user()->email_verified_at)
                                <span class="verified-badge"><i class="bi bi-check-circle-fill"></i> Verificado</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="action-buttons">
                    <div class="button-group">
                        {{-- Modificar datos --}}
                        <a href="{{ route('profile.edit') }}" class="btn-custom">
                            <i class="bi bi-pencil-square"></i> Modificar datos
                        </a>

                        {{-- Cambiar contraseña --}}
                        <a href="{{ route('profile.password.edit') }}" class="btn-custom-dark">
                            <i class="bi bi-key"></i> Cambiar contraseña
                        </a>
                    </div>

                    <div class="button-group">
                        {{-- Verificar correo --}}
                        @unless (auth()->user()->email_verified_at)
                            <form method="POST" action="{{ route('verification.send') }}" class="flex-fill">
                                @csrf
                                <button type="submit" class="btn-custom-sec">
                                    <i class="bi bi-envelope-check"></i> Verificar correo
                                </button>
                            </form>
                        @endunless

                        {{-- Crear sala --}}
                        @if (auth()->user()->email_verified_at)
                            <a href="{{ route('espacios.create') }}" class="btn-custom-sec">
                                <i class="bi bi-plus-circle"></i> Crear sala
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Salas futuras --}}
                @php
                    $upcoming = $user->reservas
                        ->where('fecha', '>=', now())
                        ->sortBy('fecha_hora')
                        ->groupBy(fn($r) => $r->espacio_id . '—' . $r->fecha->toDateString());
                @endphp

                <section class="profile-section">
                    <div class="section-header">
                        <h1> Salas reservadas</h1>
                    </div>

                    <div class="reservations-grid">
                        @forelse ($upcoming as $group)
                            @php
                                $first = $group->first();
                                $entrada = $group->min('fecha_hora')->format('H:i');
                                $ultima = $group->max('fecha_hora');
                                $salida = $ultima->copy()->addHour()->format('H:i');
                            @endphp

                            <div class="reservation-item">
                                <div class="reservation-content">
                                    <div class="reservation-main">
                                        <h3>{{ $first->espacio->nombre }}</h3>
                                        <span class="reservation-date">
                                            <i class="bi bi-calendar-event"></i>
                                            {{ $first->fecha_hora->format('d/m/Y') }}
                                        </span>
                                    </div>

                                    <div class="reservation-times">
                                        <div class="time-block">
                                            <span class="time-icon"><i class="bi bi-clock"></i></span>
                                            <span class="time-value">{{ $entrada }}</span>
                                        </div>
                                        <div class="time-block">
                                            <span class="time-icon"><i class="bi bi-clock-fill"></i></span>
                                            <span class="time-value">{{ $salida }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="bi bi-calendar-x"></i>
                                </div>
                                <h3>No tienes reservas</h3>
                                <p>Cuando hagas reservas, aparecerán aquí.</p>
                            </div>
                        @endforelse
                    </div>
                </section>

                {{-- Reseñas pasadas --}}
                @php
                    $userReviews = $user->resenas()->with('espacio')->get();
                @endphp

                <section class="profile-section">
                    <div class="section-header">
                        <h1> Reseñas realizadas</h1>
                    </div>

                    <div class="reviews-grid">
                        @forelse($userReviews as $review)
                            <div class="review-item">
                                <div class="review-header">
                                    <h3>{{ $review->espacio->nombre }}</h3>
                                    <div class="review-meta">
                                        <span class="review-date">{{ $review->created_at->format('d/m/Y') }}</span>
                                        <div class="review-rating">
                                            {{ $review->calificacion }}/5
                                        </div>
                                    </div>
                                </div>
                                @if ($review->comentario)
                                    <div class="review-comment">
                                        <p>{{ $review->comentario }}</p>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="bi bi-chat-square-text"></i>
                                </div>
                                <h3>Aún no has realizado reseñas</h3>
                                <p>Cuando evalúes salas, tus reseñas aparecerán aquí.</p>
                            </div>
                        @endforelse
                    </div>
                </section>

                @php
                    // IDs de espacios ya reseñados por el usuario
                    $reseñados = $user->resenas()->pluck('espacio_id')->toArray();

                    // Traigo todas las reservas pasadas sin importar si tienen reseña anidada
                    $todasPast = $user
                        ->reservas()
                        ->where('fecha_hora', '<=', now()->subHour())
                        ->with('espacio')
                        ->get();

                    // Me quedo solo con las que NO estén en el array de espacios reseñados
                    $pendientes = $todasPast
                        ->filter(function ($reserva) use ($reseñados) {
                            return !in_array($reserva->espacio_id, $reseñados);
                        })
                        ->unique('espacio_id');
                @endphp

                <section class="profile-section">
                    <div class="section-header">
                        <h2><i class="bi bi-pencil-square"></i> Pendientes de reseña</h2>
                    </div>

                    <div class="pending-grid">
                        @forelse($pendientes as $reserva)
                            <div class="pending-item">
                                <div class="pending-content">
                                    <h3>{{ $reserva->espacio->nombre }}</h3>
                                    <span class="pending-date">
                                        <i class="bi bi-calendar-event"></i>
                                        {{ $reserva->fecha_hora->format('d/m/Y H:i') }}
                                    </span>
                                </div>
                                <button class="review-btn" data-bs-toggle="modal" data-bs-target="#crearResenaModal"
                                    data-espacio-id="{{ $reserva->espacio->id }}"
                                    data-espacio-nombre="{{ $reserva->espacio->nombre }}">
                                    <i class="bi bi-star"></i> Puntuar
                                </button>
                            </div>
                        @empty
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="bi bi-check-circle"></i>
                                </div>
                                <h3>Todo al día</h3>
                                <p>No tienes salas pendientes de reseñar.</p>
                            </div>
                        @endforelse
                    </div>
                </section>

                {{-- Cerrar sesión --}}
                <div class="logout-section">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-custom-dark w-100">
                             Cerrar sesión
                        </button>
                    </form>
                </div>
            </div>
        @endif

        {{-- Modal Reseña --}}
        <div class="modal fade" id="crearResenaModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">
                            <i class="bi bi-star-fill"></i>
                            Reseña para <span id="modalNombreSala"></span>
                        </h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <form method="POST" action="{{ route('resenas.store') }}">
                        @csrf
                        <input type="hidden" name="espacio_id" id="modalEspacioId">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="modalCalificacion">Puntuación (1-5)</label>
                                <input type="number" name="calificacion" id="modalCalificacion" min="1"
                                    max="5" class="form-control" required>
                                @error('calificacion')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="modalComentario">Tu reseña</label>
                                <textarea name="comentario" id="modalComentario" class="form-control" rows="4" required>{{ old('comentario') }}</textarea>
                                @error('comentario')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn-custom-sec" data-bs-dismiss="modal">
                                <i class="bi bi-x-circle"></i> Cancelar
                            </button>
                            <button type="submit" class="btn-custom">
                                <i class="bi bi-check-circle"></i> Enviar reseña
                            </button>
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
