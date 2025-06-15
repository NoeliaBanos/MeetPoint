{{-- resources/views/profile/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Mi perfil')

@section('content')
<div class="container profile-container">
    @if ($user->role === 'admin')
        @include('profile._admin')
    @else
        <div class="profile-card">

            {{-- Datos personales --}}
            <div class="profile-header">
                @php
                    $imgPath   = 'img_subidas/users/' . $user->imagen_url;
                    $avatarSrc = !empty($user->imagen_url) && file_exists(public_path($imgPath))
                                ? asset($imgPath)
                                : asset('images/profile.png');
                @endphp
                <div class="avatar-wrapper">
                    <img src="{{ $avatarSrc }}" alt="Avatar de {{ $user->name }}">
                </div>
                <div class="profile-info">
                    <h1 class="profile-name">{{ $user->name }} {{ $user->apellidos }}</h1>
                    <div class="profile-meta">
                        <span class="profile-email">{{ $user->email }}</span>
                        @if (auth()->user()->email_verified_at)
                            <span class="verified-badge">
                                <i class="bi bi-check-circle-fill"></i> Verificado
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Botones de acción --}}
            <div class="action-buttons">
                <div class="button-group">
                    <a href="{{ route('profile.edit') }}" class="btn-custom">Modificar datos</a>
                    <a href="{{ route('profile.password.edit') }}" class="btn-custom-dark">Cambiar contraseña</a>
                    @unless (auth()->user()->email_verified_at)
                        <form method="POST" action="{{ route('verification.send') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn-custom-sec">Verificar correo</button>
                        </form>
                    @endunless
                    @if (auth()->user()->email_verified_at)
                        <a href="{{ route('espacios.create') }}" class="btn-custom-sec">Crear sala</a>
                    @endif
                </div>
            </div>

            {{-- Salas reservadas --}}
            @php
                // Agrupamos reservas futuras por espacio + fecha
                $upcoming = $user->reservas
                    ->where('fecha', '>=', now()->toDateString())
                    ->filter(fn($r) => \Carbon\Carbon::parse($r->fecha->toDateString().' '.$r->hora_entrada) >= now())
                    ->groupBy(fn($r) => $r->espacio_id.'—'.$r->fecha->toDateString());
            @endphp

            <section class="profile-section">
                <div class="section-header"><h1>Salas reservadas</h1></div>
                <div class="reservations-grid">
                    @forelse ($upcoming as $group)
                        @php
                            $first     = $group->first();
                            $fechaYmd  = $first->fecha->toDateString();                   // "2025-06-24"
                            $inicio    = \Carbon\Carbon::parse($fechaYmd.' '.$first->hora_entrada);
                            $fin       = \Carbon\Carbon::parse($fechaYmd.' '.$first->hora_salida);
                            $horasRest = now()->diffInHours($inicio);
                        @endphp

                        <div class="reservation-item" id="reserva-{{ $first->id }}">
                            <div class="reservation-main">
                                <h3>{{ $first->espacio->nombre }}</h3>
                                <span class="reservation-date">
                                    <i class="bi bi-calendar-event"></i>
                                    {{ $inicio->format('d/m/Y') }}
                                </span>
                            </div>
                            <div class="reservation-times">
                                <div class="time-block">
                                    <span class="time-icon"><i class="bi bi-clock"></i></span>
                                    <span class="time-value">{{ $inicio->format('H:i') }}</span>
                                </div>
                                <div class="time-block">
                                    <span class="time-icon"><i class="bi bi-clock-fill"></i></span>
                                    <span class="time-value">{{ $fin->format('H:i') }}</span>
                                </div>
                            </div>

                            @if($horasRest >= 24)
                                <form method="POST"
                                      action="{{ route('reservas.cancelar', $first) }}"
                                      class="mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-custom-sec">
                                        No asistir
                                    </button>
                                </form>
                            @endif
                        </div>
                    @empty
                        <div class="empty-state">
                            <div class="empty-icon"><i class="bi bi-calendar-x"></i></div>
                            <h3>No tienes reservas</h3>
                            <p>Cuando hagas reservas, aparecerán aquí.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            {{-- Reseñas realizadas --}}
            @php $userReviews = $user->resenas()->with('espacio')->get(); @endphp
            <section class="profile-section">
                <div class="section-header"><h1>Reseñas realizadas</h1></div>
                <div class="reviews-grid">
                    @forelse($userReviews as $review)
                        <div class="review-item">
                            <div class="review-header">
                                <h3>{{ $review->espacio->nombre }}</h3>
                                <div class="review-meta">
                                    <span class="review-date">{{ $review->created_at->format('d/m/Y') }}</span>
                                    <div class="review-rating">{{ $review->calificacion }}/5</div>
                                </div>
                            </div>
                            @if ($review->comentario)
                                <div class="review-comment"><p>{{ $review->comentario }}</p></div>
                            @endif
                        </div>
                    @empty
                        <div class="empty-state">
                            <div class="empty-icon"><i class="bi bi-chat-square-text"></i></div>
                            <h3>Aún no has realizado reseñas</h3>
                            <p>Cuando evalúes salas, tus reseñas aparecerán aquí.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            {{-- Pendientes de reseña --}}
            @php
                $reseñados = $user->resenas()->pluck('espacio_id')->toArray();
                $pendientes = $user->reservas()
                    ->whereRaw("CONCAT(fecha,' ',hora_salida) <= ?", [now()->toDateTimeString()])
                    ->with('espacio')
                    ->get()
                    ->filter(fn($r) => !in_array($r->espacio_id, $reseñados))
                    ->unique('espacio_id');
            @endphp
            <section class="profile-section">
                <div class="section-header"><h2>Pendientes de reseña</h2></div>
                <div class="pending-grid">
                    @forelse($pendientes as $reserva)
                        <div class="pending-item">
                            <div class="pending-content">
                                <h3>{{ $reserva->espacio->nombre }}</h3>
                                <span class="pending-date">
                                    <i class="bi bi-calendar-event"></i>
                                    {{ \Carbon\Carbon::parse($reserva->fecha->toDateString().' '.$reserva->hora_salida)
                                        ->format('d/m/Y H:i') }}
                                </span>
                            </div>
                            <button
                                class="review-btn"
                                data-bs-toggle="modal"
                                data-bs-target="#crearResenaModal"
                                data-espacio-id="{{ $reserva->espacio->id }}"
                                data-espacio-nombre="{{ $reserva->espacio->nombre }}"
                            ><i class="bi bi-star"></i> Puntuar</button>
                        </div>
                    @empty
                        <div class="empty-state">
                            <div class="empty-icon"><i class="bi bi-check-circle"></i></div>
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
                    <button type="submit" class="btn-custom-dark w-100">Cerrar sesión</button>
                </form>
            </div>
        </div>
    @endif

    {{-- Mensaje flash --}}
    @if(session('status'))
        <div class="alert alert-success mt-3">{{ session('status') }}</div>
    @endif
</div>
@endsection
