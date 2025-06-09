@extends('layouts.app')

@section('title', 'Reseñas')

@section('content')
    <div class="resenas-container">
        <div class="container">
            <h1>Reseñas</h1>

            @if ($resenas->isEmpty())
                <p class="no-resenas">Aún no hay reseñas.</p>
            @else
                <div class="resenas-grid">
                    @foreach ($resenas as $resena)
                        <div class="resena-card">
                            <div class="resena-header">
                                <div class="resena-avatar">
                                    @php
                                        $user = $resena->user;
                                        $imagenPath = 'img_subidas/users/' . $user->imagen_url;
                                        $hasValidImage = !empty($user->imagen_url) && file_exists(public_path($imagenPath));
                                        $avatarSrc = $hasValidImage
                                            ? asset($imagenPath)
                                            : asset('images/profile.png');
                                    @endphp
                                    <img src="{{ $avatarSrc }}" alt="Avatar de {{ $user->name }}">
                                </div>
                                <div class="resena-user">
                                    <div class="user-name">{{ $user->name }}</div>
                                    <a href="{{ route('espacios.show', $resena->espacio) }}" class="espacio-link">
                                        {{ $resena->espacio->nombre }}
                                    </a>
                                    <div class="resena-date">
                                        {{ $resena->created_at->format('d/m/Y') }}
                                    </div>
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

                            <p class="resena-comment">{{ $resena->comentario }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    @include('partials.footer')
@endsection