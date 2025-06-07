@extends('layouts.app')

@section('title', 'Reseñas')

@section('content')
    <div class="container py-4">

        {{-- Título --}}
        <h1 class="text-center mb-4">Reseñas</h1>

        @if ($resenas->isEmpty())
            <p class="text-center text-muted">Aún no hay reseñas.</p>
        @else
            <section>
                @foreach ($resenas as $resena)
                    <article class="row align-items-start mb-4 pb-3 border-bottom">
                        {{-- Avatar del usuario --}}
                        <div class="col-auto">
                            @php
                                $user = $resena->user;
                                $imagenPath = 'img_subidas/users/' . $user->imagen_url;
                                $hasValidImage = !empty($user->imagen_url) && file_exists(public_path($imagenPath));
                                $avatarSrc = $hasValidImage
                                    ? asset($imagenPath)
                                    : asset('images/profile.png');
                            @endphp

                            <img src="{{ $avatarSrc }}" alt="Avatar de {{ $user->name }}"
                                 class="rounded-circle img-avatar"
                                 width="70" height="70"
                                 style="object-fit: cover;">
                        </div>

                        {{-- Contenido de la reseña --}}
                        <div class="col">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <div>
                                    <strong>{{ $user->name }}</strong>
                                    <small class="text-muted ms-2">
                                        en <a href="{{ route('espacios.show', $resena->espacio) }}" class="text-decoration-none">
                                            {{ $resena->espacio->nombre }}
                                        </a>
                                    </small>
                                </div>
                                <small class="text-muted">
                                    {{ $resena->created_at->format('d/m/Y') }}
                                </small>
                            </div>

                            {{-- Puntuación con estrellas --}}
                            <div class="mb-2" aria-label="Calificación: {{ $resena->calificacion }} de 5">
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
                                    <img src="{{ asset('images/' . $img) }}" alt="Estrella"
                                         class="me-1 d-inline-block stars"
                                         width="50" height="50">
                                @endfor
                            </div>

                            {{-- Comentario --}}
                            <p class="mb-0">{{ $resena->comentario }}</p>
                        </div>
                    </article>
                @endforeach
            </section>
        @endif

    </div>

    {{-- FOOTER --}}
    @include('partials.footer')
@endsection
