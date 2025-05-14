@extends('layouts.app')

@section('title', 'MeetPoint')

@section('content')
    {{-- Hero --}}
    <div class="hero-size">
        <img src="{{ asset('images/fondo.jpg') }}" alt="…">
        <div class="hero-text">
            <h1 class="display">MeetPoint</h1>
            <p>Consulta en tiempo real la disponibilidad, capacidad, equipamiento y valoraciones de otros usuarios para
                reservar el espacio perfecto de forma rápida y eficiente.</p>
        </div>
    </div>

    <h2>Espacios en Utrera</h2>

    <section class="container espacios-grid">
        @foreach ($espacios as $espacio)
            <div class="espacios">
                {{-- Imagen --}}
                <div class="img-espacios">
                    <img src="{{ asset($espacio->imagen_url) }}" alt="Foto de {{ $espacio->nombre }}">
                </div>

                {{-- Título y estado solo para admin --}}
                <div class="flex items-baseline justify-between mt-4 mb-2">
                    <h3 class="text-xl font-semibold">
                        <a href="{{ route('espacios.show', $espacio->id) }}">
                            {{ $espacio->nombre }}
                        </a>
                    </h3>

                    @auth
                        @if (auth()->user()->role === 'admin')
                            @if ($espacio->estado_espacio === 'disponible')
                                <span class="text-teal-400 font-medium">Disponible</span>
                            @else
                                <span class="text-gray-500 font-medium">Espera</span>
                            @endif
                        @endif
                    @endauth
                </div>

                <hr class="mb-2">

                <p>Precio: <b>{{ number_format($espacio->precio_hora, 2) }} €</b></p>
                <p>Equipamiento: <b>{{ $espacio->equipamiento }}</b></p>

                @if (method_exists($espacio, 'resenas'))
                    @php $media = $espacio->resenas->avg('calificacion'); @endphp
                    <p>Reseñas: <b>{{ $media ? number_format($media, 1) : 'Sin reseñas' }}</b></p>
                @endif

                <div class="mt-4 space-y-2">
                    @auth
                        @if (auth()->user()->role === 'admin')
                            {{-- Admin: modificar y eliminar --}}
                            <a href="{{ route('espacios.edit', $espacio->id) }}" class="btn-custom">
                                MODIFICAR
                            </a>

                            <form action="{{ route('espacios.destroy', $espacio->id) }}" method="POST"
                                onsubmit="return confirm('¿Eliminar este espacio?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-custom-dark">
                                    ELIMINAR
                                </button>
                            </form>

                            @if ($espacio->estado_espacio === 'no_disponible')
                                {{-- Botones de verificación --}}
                                <form action="{{ route('espacios.apta', $espacio->id) }}" method="POST"
                                    class="inline-block w-1/2 pr-1">
                                    @csrf
                                    <button type="submit" class="btn-custom"> APTA
                                    </button>
                                </form>
                                <form action="{{ route('espacios.no_apta', $espacio->id) }}" method="POST"
                                    class="inline-block w-1/2 pl-1">
                                    @csrf
                                    <button type="submit" class="btn-custom-dark"> NO APTA
                                    </button>
                                </form>
                            @endif
                        @else
                            {{-- Usuario normal: si está disponible, + INFO --}}
                            @if ($espacio->estado_espacio === 'disponible')
                                <a href="{{ route('espacios.show', $espacio->id) }}"
                                    class="w-full bg-teal-400 hover:bg-teal-500 text-white font-bold py-2 rounded-full text-center">
                                    + INFO
                                </a>
                            @endif
                        @endif
                    @else
                        {{-- Invitados: ver solo si está disponible --}}
                        @if ($espacio->estado_espacio === 'disponible')
                            <a href="{{ route('espacios.show', $espacio->id) }}"
                                class="w-full bg-teal-400 hover:bg-teal-500 text-white font-bold py-2 rounded-full text-center">
                                + INFO
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        @endforeach
    </section>

    @include('partials.footer')
@endsection
