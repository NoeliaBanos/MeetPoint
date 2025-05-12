@extends('layouts.app')

@section('title', 'Mi perfil')

@section('content')
    <div class="max-w-3xl mx-auto py-8 px-4 container">
        <div class="bg-white shadow rounded p-4 m-4 space-y-6">
            {{-- Datos personales --}}
            <section><div style="width: 70px">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=64"
                        alt="Avatar de {{ $user->name }}" width="64" height="64"
                        style="border-radius:50%; object-fit:cover;">
                </div>
                <h1>{{ $user->name }} {{ $user->apellido }}</h1>
                
                <p>{{ $user->email }}</p>
                <a href="{{ route('profile.edit') }}" class="btn-custom d-flex justify-content-center">Modificar datos</a>
            </section>

            {{-- Salas reservadas --}}
            <section class="pt-4">
                @forelse($user->reservas->where('fecha','>=', now()) as $r)
                    <h2 class="text-xl font-semibold mb-2">Salas reservadas</h2>
                    <p class="mb-1">
                        {{ $r->espacio->nombre }}
                        — {{ $r->fecha->format('d/m/Y') }} a las {{ $r->hora_inicio->format('H:i') }}
                    </p>
                @empty
                    <h2 class="text-gray-500">No tienes reservas.</h2>
                @endforelse
            </section>

            {{-- Salas usadas --}}
            <section  class="pt-4">
                @forelse($user->reservas->where('fecha','<', now()) as $r)
                    <h2 class="text-xl font-semibold mb-2">Salas usadas</h2>
                    <div class="flex justify-between items-center mb-1">
                        <span>
                            {{ $r->espacio->nombre }} — {{ $r->fecha->format('d/m/Y') }}
                        </span>
                        @if ($r->resena)
                            <span class="text-yellow-500 font-medium">
                                {{ $r->resena->calificacion }}/5
                            </span>
                        @else
                            <a href="{{ route('resenas.create', ['espacio' => $r->espacio_id]) }}"
                                class="btn-custom ms-2">Puntuar</a>
                        @endif
                    </div>
                @empty
                    <h2 class="text-gray-500">No has usado ninguna sala aún.</h2>
                @endforelse
            </section>
        </div>
    </div>
    @include('partials.footer')
@endsection
