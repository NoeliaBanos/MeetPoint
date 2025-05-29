@extends('layouts.app')

@section('title', 'MeetPoint')

@section('content')
    

    <h2>Espacios en Utrera</h2>

    <section class="container espacios-grid">
        @foreach ($espacios as $espacio)
            @if(
                (auth()->check() && auth()->user()->role === 'admin')
                || $espacio->estado_espacio === 'disponible'
            )
                <div class="espacios">
                    {{-- Imagen --}}
                    <div class="img-espacios">
                        <img src="{{ asset($espacio->imagen_url) }}"
                             alt="Foto de {{ $espacio->nombre }}">
                    </div>

                    {{-- Título y acciones según rol --}}
                    <div class="flex items-baseline justify-between mt-4 mb-2">
                        <h3 class="text-xl font-semibold">
                            <a href="{{ route('espacios.show', $espacio) }}">
                                {{ $espacio->nombre }}
                            </a>
                        </h3>

                        @auth
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('espacios.edit', $espacio) }}"
                                   class="btn-custom">
                                    MODIFICAR
                                </a>
                            @endif
                        @endauth
                    </div>

                    <hr class="mb-2">

                    <p>Precio: <b>{{ number_format($espacio->precio_hora, 2) }} €/h</b></p>
                    <p>Equipamiento: <b>{{ $espacio->equipamiento }}</b></p>

                    {{-- Reseñas con estrellas --}}
                    @if(method_exists($espacio, 'resenas'))
                        @php
                            $media = $espacio->resenas->avg('calificacion') ?: 0;
                        @endphp
                        <div class="flex items-center mt-2 mb-4">
                            @for($i = 1; $i <= 5; $i++)
                                @php
                                    $diff = $media - $i + 1;
                                    if($diff >= 1) {
                                        $img = 'star-2.png'; // llena
                                    } elseif($diff >= 0.5) {
                                        $img = 'star-1.png'; // mitad
                                    } else {
                                        $img = 'star-0.png'; // vacía
                                    }
                                @endphp
                                <img src="{{ asset('images/' . $img) }}"
                                     alt=""
                                     style="width:50px; height:50px;"
                                     class="inline-block me-1">
                            @endfor
                            <span class="ml-2 text-sm text-gray-600">
                                {{ $media ? number_format($media, 1) : 'Sin reseñas' }}
                            </span>
                        </div>
                    @endif

               
                  

                    {{-- + INFO al final --}}
                    @if($espacio->estado_espacio === 'disponible')
                        <a href="{{ route('espacios.show', $espacio) }}"
                           class="btn-custom w-full text-center rounded-full py-2 mb-4">
                            + INFO
                        </a>
                    @endif

                    @auth
                        @if(auth()->user()->role === 'admin')
                            {{-- Admin: eliminar / verificar --}}
                            <div class="mt-3 space-x-2">
                                <form action="{{ route('espacios.destroy', $espacio) }}"
                                      method="POST"
                                      onsubmit="return confirm('¿Eliminar este espacio?');"
                                      class="inline-block">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-custom-dark">
                                        ELIMINAR
                                    </button>
                                </form>

                                @if($espacio->estado_espacio === 'no_disponible')
                                    <form action="{{ route('espacios.apta', $espacio) }}"
                                          method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="btn-custom">
                                            APTA
                                        </button>
                                    </form>
                                    <form action="{{ route('espacios.no_apta', $espacio) }}"
                                          method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="btn-custom-dark">
                                            NO APTA
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endif
                    @endauth
                </div>
            @endif
        @endforeach
    </section>

    @include('partials.footer')
@endsection
