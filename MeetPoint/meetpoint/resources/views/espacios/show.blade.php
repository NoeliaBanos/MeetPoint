@extends('layouts.app')

@section('title', $espacio->nombre)

@section('content')
    <div class="espacio-detail">
        <!-- Hero Section -->
        <div class="espacio-hero">
            <img src="{{ asset($espacio->imagen_url) }}" alt="{{ $espacio->nombre }}" class="espacio-hero-img">
            <div class="espacio-hero-overlay">
                <div class="container">
                    <div class="espacio-hero-content">
                        <h1 class="espacio-title">{{ $espacio->nombre }}</h1>
                        <div class="espacio-meta">
                            <span class="meta-item">
                                <i class="fas fa-users"></i> Aforo: {{ $espacio->capacidad }} personas
                            </span>
                            <span class="meta-item">
                                <i class="fas fa-euro-sign"></i> {{ number_format($espacio->precio_hora, 2) }} €/hora
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container espacio-container">
            <div class="row">
                <!-- Descripción y reserva -->
                <div class="col-lg-8">
                    <section class="espacio-section">
                        <h2 class="section-title">Descripción</h2>
                        <p class="espacio-description">{{ $espacio->descripcion }}</p>
                    </section>

                    <section class="espacio-section">
                        <h2 class="section-title">Equipamiento</h2>
                        <div class="equipment-list">
                            @foreach (explode(',', $espacio->equipamiento) as $equipo)
                                <span class="equipment-item">{{ trim($equipo) }}</span>
                            @endforeach
                        </div>
                    </section>
                </div>

                <!-- Sidebar de reserva -->
                <div class="col-lg-4">
                    <div class="reserva-card">
                        @auth
                            <a href="{{ route('reservas.create', $espacio) }}" class="btn-custom  btn-reservar">
                                <i class="fas fa-calendar-alt"></i> Reservar ahora
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary btn-reservar">
                                <i class="fas fa-sign-in-alt"></i> Iniciar sesión para reservar
                            </a>
                        @endauth
                        <div class="reserva-info">
                            <div class="info-item">
                                <i class="fas fa-clock"></i>
                                <span>Horario: 8:00 - 22:00</span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-euro-sign"></i>
                                <span>Precio: {{ number_format($espacio->precio_hora, 2) }} €/hora</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reseñas -->
            <section class="espacio-section espacio-reviews">
                <div class="section-header">
                    <h2 class="section-title">Reseñas</h2>
                    <div class="rating-summary">
                        @php
                            $averageRating = $espacio->resenas->avg('calificacion');
                            $reviewCount = $espacio->resenas->count();
                        @endphp
                        <div class="average-rating">
                            {{ number_format($averageRating, 1) }} <i class="fas fa-star"></i>
                        </div>
                        <div class="review-count">{{ $reviewCount }} reseñas</div>
                    </div>
                </div>

                @if ($espacio->resenas->isEmpty())
                    <div class="no-reviews">
                        <i class="far fa-comment-dots"></i>
                        <p>Aún no hay reseñas para este espacio.</p>
                    </div>
                @else
                    <div class="reviews-grid">
                        @foreach ($espacio->resenas as $resena)
                            <div class="review-card">
                                <div class="review-header">
                                    <div class="user-avatar">
                                        @php
                                            $user = $resena->user;
                                            $imagenPath = 'img_subidas/users/' . $user->imagen_url;
                                            $hasValidImage =
                                                !empty($user->imagen_url) && file_exists(public_path($imagenPath));
                                            $avatarSrc = $hasValidImage
                                                ? asset($imagenPath)
                                                : asset('images/profile.png');
                                        @endphp
                                        <img src="{{ $avatarSrc }}" alt="{{ $user->name }}" class="avatar-img">
                                    </div>
                                    <div class="user-info">
                                        <div class="user-name">{{ $user->name }}</div>
                                        <div class="review-date">{{ $resena->created_at->format('d/m/Y') }}</div>
                                    </div>
                                </div>
                                <div class="resena-stars" aria-label="Calificación: {{ $resena->calificacion }} de 5">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @php
                                            $diff = $resena->calificacion - $i + 1;
                                            if ($diff >= 1) {
                                                $img = 'star-2.png'; // llena
                                            } elseif ($diff >= 0.5) {
                                                $img = 'star-1.png'; // media
                                            } else {
                                                $img = 'star-0.png'; // vacía
                                            }
                                        @endphp
                                        <img src="{{ asset('images/' . $img) }}" alt="Estrella">
                                    @endfor
                                </div>
                                <div class="review-content">
                                    {{ $resena->comentario }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
        </div>
    </div>

    @include('partials.footer')
@endsection
