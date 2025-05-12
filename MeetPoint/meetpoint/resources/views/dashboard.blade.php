<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
<x-slot name="content">
    {{-- Avatar y nombre completo --}}
    <div class="px-4 py-2 border-b">
        <div class="flex items-center gap-3">
            <img
              src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name . ' ' . Auth::user()->apellido) }}&size=48"
              alt="Avatar de {{ Auth::user()->name }}"
              class="rounded-full"
            >
            <div>
                <div class="font-medium text-base">
                    {{ Auth::user()->name }} {{ Auth::user()->apellido }}
                </div>
                <div class="text-sm text-gray-500">
                    {{ Auth::user()->email }}
                </div>
            </div>
        </div>
    </div>

    {{-- Salas reservadas (futuras) --}}
    <div class="px-4 py-2 border-b">
        <div class="font-semibold text-sm mb-1">Salas reservadas</div>
        @forelse(Auth::user()->reservas->where('fecha', '>=', now()) as $reserva)
            <div class="text-sm mb-1">
                {{ $reserva->espacio->nombre }} &mdash;
                {{ $reserva->fecha->format('d/m') }} a las {{ $reserva->hora_inicio->format('H:i') }}
            </div>
        @empty
            <div class="text-sm text-gray-500">No tienes reservas futuras.</div>
        @endforelse
    </div>

    {{-- Salas usadas (pasadas) --}}
    <div class="px-4 py-2 border-b">
        <div class="font-semibold text-sm mb-1">Salas usadas</div>
        @forelse(Auth::user()->reservas->where('fecha', '<', now()) as $reserva)
            <div class="flex items-center justify-between text-sm mb-1">
                <span>
                    {{ $reserva->espacio->nombre }} &mdash;
                    {{ $reserva->fecha->format('d/m') }}
                </span>
                @if($reserva->resena)
                    <span class="text-yellow-500 font-medium">
                        {{ $reserva->resena->calificacion }}/5
                    </span>
                @else
                    <a
                      href="{{ route('resenas.create', ['espacio' => $reserva->espacio_id]) }}"
                      class="text-blue-600 hover:underline"
                    >
                        Puntuar
                    </a>
                @endif
            </div>
        @empty
            <div class="text-sm text-gray-500">No has usado ninguna sala aún.</div>
        @endforelse
    </div>

    {{-- Modificar datos de usuario --}}
    <div class="px-4 py-2">
        <x-dropdown-link :href="route('profile.edit')">
            {{ __('Modificar datos') }}
        </x-dropdown-link>
    </div>

    {{-- Cerrar sesión --}}
    <div class="px-4 py-2 border-t">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-dropdown-link
                :href="route('logout')"
                onclick="event.preventDefault(); this.closest('form').submit();"
            >
                {{ __('Cerrar sesión') }}
            </x-dropdown-link>
        </form>
    </div>
</x-slot>

</x-app-layout>
