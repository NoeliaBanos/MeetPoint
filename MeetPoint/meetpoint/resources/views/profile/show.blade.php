@extends('layouts.app')

@section('title', 'Mi perfil')

@section('content')
    <div class="max-w-3xl mx-auto py-8 px-4 container">
        @if ($user->role === 'admin')
            {{-- Panel Administrador --}}
            <h2 class="mt-4 text-center">Panel administrador</h2>

            <div class="space-y-6">
                {{-- Espacios --}}
                <div class="text-center">
                    <div class="pt-4">
                        <h3 class="display">{{ \App\Models\Espacio::count() }}</h3>
                        <p>Espacios en total</p>
                    </div>
                    <a href="{{ route('resenas.index') }}" class="btn-custom">
                        VER LISTA
                    </a>
                    <a href="{{ route('espacios.create') }}" class="mt-4 btn-custom-sec">
                        AÑADIR
                    </a>
                </div>

                {{-- Reseñas --}}
                <div class="text-center">
                    <div class="pt-4">
                        <h3 class="display">{{ \App\Models\Resena::count() }}</h3>
                        <p>Reseñas en total</p>
                    </div>
                    <a href="{{ route('resenas.index') }}" class="btn-custom"> VER LISTA
                    </a>
                </div>

                {{-- Cerrar sesión --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-custom-sec mt-4 w-100"> CERRAR SESIÓN
                    </button>
                </form>
            </div>
        @else
            {{-- Perfil de usuario normal --}}
            <div class="bg-white shadow rounded p-4 m-4 space-y-6">
                {{-- Datos personales --}}
                <section>
                    <div style="width: 70px;">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=64"
                            alt="Avatar de {{ $user->name }}" width="64" height="64"
                            style="border-radius:50%; object-fit:cover;">
                    </div>
                    <h1 class="text-2xl font-semibold">
                        {{ $user->name }} {{ $user->apellido }}
                    </h1>
                    <p class="text-gray-600">{{ $user->email }}</p>
                    <a href="{{ route('profile.edit') }}"
                        class="w-full bg-teal-400 hover:bg-teal-500 text-white font-bold py-2 px-4 rounded-full inline-block text-center mt-4">
                        Modificar datos
                    </a>
                </section>

                {{-- Salas reservadas --}}
                <section class="pt-4">
                    @php($upcoming = $user->reservas->where('fecha', '>=', now()))
                    <h2 class="text-xl font-semibold mb-2">Salas reservadas</h2>
                    @forelse($upcoming as $r)
                        <p class="mb-1">
                            {{ $r->espacio->nombre }}
                            — {{ $r->fecha->format('d/m/Y') }} a las {{ $r->hora_inicio->format('H:i') }}
                        </p>
                    @empty
                        <p class="text-gray-500">No tienes reservas.</p>
                    @endforelse
                </section>

                {{-- Salas usadas --}}
                <section class="pt-4">
                    @php($past = $user->reservas->where('fecha', '<', now()))
                    <h2 class="text-xl font-semibold mb-2">Salas usadas</h2>
                    @forelse($past as $r)
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
                                    class="bg-teal-400 hover:bg-teal-500 text-white font-bold py-1 px-3 rounded-full">
                                    Puntuar
                                </a>
                            @endif
                        </div>
                    @empty
                        <p class="text-gray-500">No has usado ninguna sala aún.</p>
                    @endforelse
                </section>
            </div>
        @endif
        @if (!auth()->user()->hasVerifiedEmail())
            <form method="POST" action="{{ route('verification.send') }}" class="mt-4 text-center">
                @csrf
                <button type="submit" class="btn-custom-sec w-full md:w-1/2 lg:w-1/3 mx-auto">
                    Reenviar correo de verificación
                </button>
            </form>
            <p class="mt-2 text-sm text-gray-600">
                ¿Ya recibiste tu correo?
                <a href="{{ route('verification.notice') }}" class="text-teal-400 underline">Verifica tu cuenta aquí</a>
            </p>
        @endif

    </div>

    @include('partials.footer')
@endsection
