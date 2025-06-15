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
                                <div class="resena-avatar avatar-wrapper">
                                    @php
                                        $user    = $resena->user;
                                        $imgPath = 'img_subidas/users/' . $user->imagen_url;
                                        $avatarSrc = (!empty($user->imagen_url) && file_exists(public_path($imgPath)))
                                                     ? asset($imgPath)
                                                     : asset('images/profile.png');
                                    @endphp
                                    <img src="{{ $avatarSrc }}"
                                         alt="Avatar de {{ $user->name }}"
                                         class="profile-avatar">
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

                                    {{-- Editar: abre modal --}}
                                    <button type="button"
                                            class="btn-custom-sec flex-fill text-center"
                                            data-bs-toggle="modal"
                                            data-bs-target="#crearResenaModal"
                                            data-resena-id="{{ $resena->id }}"
                                            data-calificacion="{{ $resena->calificacion }}"
                                            data-comentario="{{ $resena->comentario }}"
                                            data-espacio-nombre="{{ $resena->espacio->nombre }}">
                                        Editar
                                    </button>

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

    {{-- Modal para editar reseña --}}
    <div class="modal fade" id="crearResenaModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-xl shadow">
                <div class="modal-header">
                    <h3 class="pt-2 ps-2">
                        Editar reseña para <span id="modalNombreSala" class="text-muted small"></span>
                    </h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" id="modalForm" action="">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="number" name="calificacion" id="modalCalificacion"
                                   min="1" max="5" step="1"
                                   class="form-control" placeholder="Puntuación del 1 al 5" required>
                            <label for="modalCalificacion">Puntuación (1-5)</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea name="comentario" id="modalComentario"
                                      class="form-control" placeholder="Tu reseña"
                                      style="height:120px" required></textarea>
                            <label for="modalComentario">Reseña</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn-custom">
                            Guardar cambios
                        </button>
                        <button type="button" class="btn-custom-sec" data-bs-dismiss="modal">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modalEl = document.getElementById('crearResenaModal');
        modalEl.addEventListener('show.bs.modal', event => {
            const btn   = event.relatedTarget;
            const id    = btn.dataset.resenaId;
            const cal   = btn.dataset.calificacion;
            const com   = btn.dataset.comentario;
            const nombre= btn.dataset.espacioNombre;

            // Ajusta la acción del formulario
            document.getElementById('modalForm').action = `/resenas/${id}`;
            document.getElementById('modalCalificacion').value = cal;
            document.getElementById('modalComentario').value   = com;
            document.getElementById('modalNombreSala').textContent = nombre;
        });
    });
</script>
@endpush
