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
                        {{-- Oculta la tarjeta a usuarios no-admin si visible = false --}}
                        @continue(
                            !$resena->visible &&
                            !(auth()->check() && auth()->user()->role === 'admin')
                        )

                        <div class="resena-card">
                            {{-- ── Cabecera: avatar + datos ─────────────────────────── --}}
                            <div class="resena-header">
                                <div class="resena-avatar">
                                    @php
                                        $user      = $resena->user;
                                        $imgPath   = 'img_subidas/users/' . $user->imagen_url;
                                        $avatarSrc = (!empty($user->imagen_url) && file_exists(public_path($imgPath)))
                                                     ? asset($imgPath)
                                                     : asset('images/profile.png');
                                    @endphp
                                    <img src="{{ $avatarSrc }}" alt="Avatar de {{ $user->name }}">
                                </div>

                                <div class="resena-user">
                                    <div class="user-name">{{ $user->name }}</div>

                                    <a href="{{ route('espacios.show', $resena->espacio) }}"
                                       class="espacio-link">
                                        {{ $resena->espacio->nombre }}
                                    </a>

                                    <div class="resena-date">
                                        {{ $resena->created_at->format('d/m/Y') }}
                                    </div>
                                </div>
                            </div>

                            {{-- ── Estrellas de calificación ───────────────────────── --}}
                            <div class="resena-stars"
                                 aria-label="Calificación: {{ $resena->calificacion }} de 5">
                                @for ($i = 1; $i <= 5; $i++)
                                    @php
                                        $diff = $resena->calificacion - $i + 1;
                                        $img  = $diff >= 1   ? 'star-2.png'
                                              : ($diff >= .5 ? 'star-1.png'
                                                             : 'star-0.png');
                                    @endphp
                                    <img src="{{ asset('images/' . $img) }}" alt="Estrella">
                                @endfor
                            </div>

                            {{-- ── Comentario ──────────────────────────────────────── --}}
                            <p class="resena-comment">{{ $resena->comentario }}</p>

                            {{-- ── Acciones para ADMIN ─────────────────────────────── --}}
                            @if(auth()->check() && auth()->user()->role === 'admin')

                                @if(!$resena->visible)
                                    <span class="badge bg-custom mb-2">Oculta</span>
                                @endif

                                <div class="resena-actions d-flex gap-2 mt-2">

    {{-- Editar --}}
    <a href="{{ route('resenas.edit', $resena) }}"
       class="btn-custom-sec flex-fill text-center">
        Editar
    </a>

    {{-- Mostrar (sólo si está oculta) --}}
    @if(!$resena->visible)
        <form method="POST"
              action="{{ route('resenas.visible', $resena) }}"
              class="flex-fill">
            @csrf
            <button type="submit"
                    class="btn-custom w-100">
                Mostrar
            </button>
        </form>
    @endif

    {{-- Eliminar --}}
    <form method="POST"
          action="{{ route('resenas.destroy', $resena) }}"
          class="flex-fill"
          onsubmit="return confirm('¿Eliminar esta reseña definitivamente?');">
        @csrf
        @method('DELETE')
        <button type="submit"
                class="btn-custom-dark w-100">
            Eliminar
        </button>
    </form>

</div>

                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
