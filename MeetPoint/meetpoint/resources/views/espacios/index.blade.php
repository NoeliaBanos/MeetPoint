@extends('layouts.app')

@section('title', 'MeetPoint')

@section('content')
<div class="espacios-page">
    <h1 class="text-center">Espacios en Utrera</h1>

    {{-- FILTROS --}}
    <section class="filters-section px-5">
        <div class="filters-grid">
            {{-- Búsqueda por nombre --}}
            <div class="filter-group">
                <div class="form-floating">
                    <input type="text" class="form-control" id="filter-name" placeholder="Buscar por nombre…">
                    <label for="filter-name">Buscar por nombre…</label>
                </div>
            </div>

            {{-- Equipamiento --}}
            <div class="filter-group">
                <button type="button" id="toggle-equip" class="equip-toggle">
                    Equipamiento
                </button>
                
                <div id="filter-equipamiento" class="equip-grid">
                    @php
                        use Illuminate\Support\Str;
                        $allEquip = $espacios
                            ->pluck('equipamiento')
                            ->filter()
                            ->flatMap(fn($e) => explode(',', $e))
                            ->map(fn($e) => trim($e))
                            ->unique()
                            ->values();
                    @endphp

                    @foreach ($allEquip as $equip)
                        <div class="form-check">
                            <input class="form-check-input equip-checkbox" type="checkbox"
                                value="{{ Str::lower($equip) }}" id="equip-{{ Str::slug($equip) }}">
                            <label class="form-check-label" for="equip-{{ Str::slug($equip) }}">
                                {{ $equip }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Rango de precio --}}
            <div class="filter-group price-filter">
                <label for="filter-price">
                    Precio máximo: 
                    <span id="price-display" class="price-display">∞</span> €/h
                </label>
                <input id="filter-price" type="range" min="0" max="{{ $espacios->max('precio_hora') ?? 0 }}" 
                    value="{{ $espacios->max('precio_hora') ?? 0 }}" class="w-full">
            </div>
        </div>
    </section>

    {{-- GRID DE ESPACIOS --}}
    <div class="espacios-grid">
        @foreach ($espacios as $espacio)
            @if ((auth()->check() && auth()->user()->role === 'admin') || $espacio->estado_espacio === 'disponible')
                <div class="espacio-card" data-nombre="{{ Str::lower($espacio->nombre) }}"
                    data-precio="{{ $espacio->precio_hora }}"
                    data-equipamiento="{{ Str::lower($espacio->equipamiento ?? '') }}">

                    {{-- Imagen --}}
                    <div class="img-espacios">
                        <img src="{{ asset($espacio->imagen_url) }}" alt="Foto de {{ $espacio->nombre }}">
                    </div>

                    <div class="card-body">
                        {{-- Título y acciones admin --}}
                        <div class="card-header">
                            <h3>
                                <a href="{{ route('espacios.show', $espacio) }}">
                                    {{ $espacio->nombre }}
                                </a>
                            </h3>
                            
                            @auth
                                @if (auth()->user()->role === 'admin')
                                    <div class="admin-actions">
                                        <a href="{{ route('espacios.edit', $espacio) }}" class="btn btn-sm btn-custom">
                                            Editar
                                        </a>
                                        <form action="{{ route('espacios.destroy', $espacio) }}" method="POST"
                                            onsubmit="return confirm('¿Eliminar este espacio?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-custom-dark">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>

                        <hr>

                        {{-- Precio y valoración --}}
                        <div class="info-row">
                            <p class="price">{{ number_format($espacio->precio_hora, 2) }} €/h</p>
                            
                            @if (method_exists($espacio, 'resenas'))
                                @php
                                    $media = $espacio->resenas->avg('calificacion') ?: 0;
                                @endphp
                                <div class="stars">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @php
                                            $diff = $media - $i + 1;
                                            $img = $diff >= 1 ? 'star-2.png' : ($diff >= 0.5 ? 'star-1.png' : 'star-0.png');
                                        @endphp
                                        <img src="{{ asset('images/' . $img) }}" alt="" class="star-icon">
                                    @endfor
                                </div>
                            @endif
                        </div>

                        {{-- Info adicional --}}
                        <div class="espacio-info">
                            <div class="espacio-info-grid">
                                <div class="grid-item capacidad">
                                    <strong>Capacidad:</strong>
                                    <span>{{ $espacio->capacidad }}</span>
                                </div>
                                <div class="grid-item equipamiento">
                                    <strong>Equipamiento:</strong>
                                    <span>{{ $espacio->equipamiento }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Botón principal --}}
                        @if ($espacio->estado_espacio === 'disponible')
                            <a href="{{ route('espacios.show', $espacio) }}" class="btn-custom">
                                + INFO
                            </a>
                        @endif

                        {{-- Botones admin para aptitud --}}
                        @auth
                            @if (auth()->user()->role === 'admin' && $espacio->estado_espacio === 'no_disponible')
                                <div class="admin-apta-actions">
                                    <form action="{{ route('espacios.apta', $espacio) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-custom">
                                            APTA
                                        </button>
                                    </form>
                                    <form action="{{ route('espacios.no_apta', $espacio) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-custom-dark">
                                            NO APTA
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>

{{-- SCRIPT DE FILTRADO --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const nameInput = document.getElementById('filter-name');
        const priceInput = document.getElementById('filter-price');
        const priceDisplay = document.getElementById('price-display');
        const equipChecks = Array.from(document.querySelectorAll('.equip-checkbox'));
        const espacios = Array.from(document.querySelectorAll('.espacio-card'));
        const toggleEquipBtn = document.getElementById('toggle-equip');
        const equipContainer = document.getElementById('filter-equipamiento');

        // Actualiza etiqueta de precio
        function updatePriceLabel() {
            priceDisplay.textContent = (priceInput.value == priceInput.max) ?
                '∞' :
                priceInput.value;
        }

        // Filtra espacios según nombre, precio y equipamiento
        function filterEspacios() {
            const term = nameInput.value.trim().toLowerCase();
            const maxP = parseFloat(priceInput.value);
            const selectedEquip = equipChecks
                .filter(cb => cb.checked)
                .map(cb => cb.value);

            espacios.forEach(card => {
                const nombre = card.dataset.nombre;
                const precio = parseFloat(card.dataset.precio);
                const equipArr = card.dataset.equipamiento
                    .split(',')
                    .map(e => e.trim());

                const matchName = !term || nombre.includes(term);
                const matchPrice = precio <= maxP;
                const matchEquip = selectedEquip.length === 0 ?
                    true :
                    selectedEquip.some(e => equipArr.includes(e));

                card.style.display = (matchName && matchPrice && matchEquip) ?
                    '' :
                    'none';
            });
        }

        // Eventos
        priceInput.addEventListener('input', () => {
            updatePriceLabel();
            filterEspacios();
        });
        nameInput.addEventListener('input', filterEspacios);
        equipChecks.forEach(cb => cb.addEventListener('change', filterEspacios));
        toggleEquipBtn.addEventListener('click', () => {
            equipContainer.classList.toggle('visible');
        });

        // Inicialización
        updatePriceLabel();
    });
</script>
@endsection