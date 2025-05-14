@extends('layouts.app')

@section('title', 'Contacto')

@section('content')
    @auth
        @if(auth()->user()->role === 'admin')
            {{-- Panel de Mensajes para Admin --}}
            <div class="max-w-3xl mx-auto py-8 px-4">
                <h1 class="mt-4 text-center">
                    Mensajes de Contacto
                </h1>

                @forelse($mensajes as $mensaje)
                    <div class="bg-white rounded-xl shadow p-6 mb-4">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-xl font-medium">{{ $mensaje->nombre }}</h3>
                            <small class="text-gray-500">{{ $mensaje->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                        <p class="text-gray-700 mb-1"><strong>Email:</strong> {{ $mensaje->email }}</p>
                        <p class="text-gray-700 mb-1"><strong>Teléfono:</strong> {{ $mensaje->telefono }}</p>
                        <p class="text-gray-800 mt-3">{{ $mensaje->mensaje }}</p>

                        <div class="mt-4 flex space-x-2">
                            {{-- Opcional: botón para eliminar --}}
                            <form action="{{ route('contacto.destroy', $mensaje->id) }}" method="POST"
                                  onsubmit="return confirm('¿Eliminar este mensaje?');">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-4 rounded-full">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500">No hay mensajes pendientes.</p>
                @endforelse
            </div>

        @else
            {{-- Usuario autenticado NO admin: mostramos FAQ + Form --}}
            @include('contacto._publico')
        @endif
    @else
        {{-- Invitado: mostramos FAQ + Form --}}
        @include('contacto._publico')
    @endauth
@endsection
