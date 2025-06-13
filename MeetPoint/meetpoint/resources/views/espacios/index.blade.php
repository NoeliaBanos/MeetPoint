{{-- resources/views/espacios/index.blade.php --}}
@extends('layouts.app')

@section('title', 'MeetPoint')

@section('content')

    <h2 class="text-center p-4">Espacios en Utrera</h2>


    {{-- FILTROS --}}
    <section class="container mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Búsqueda por nombre (form-floating con input) -->
            <div class="form-floating mb-4">
                <input type="text" class="form-control" id="filter-name" name="filter-name" placeholder="Buscar por nombre…"
                    required>
                <label for="filter-name">Buscar por nombre…</label>
                <div class="invalid-feedback">El término de búsqueda no puede quedar vacío.</div>
            </div>

            <!-- Botón para mostrar/ocultar equipamiento -->
            <div>
                <!-- Botón toggle -->
                <button type="button" id="toggle-equip" class="btn btn-outline-secondary w-full mb-2">
                    Equipamiento
                </button>

                <!-- Grid de checkboxes oculto por defecto -->
                <div id="filter-equipamiento" class="row gx-2 gy-2" style="display: none;">
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
                        <div class="col-6 col-md-4 col-lg-2">
                            <div class="form-check">
                                <input class="form-check-input equip-checkbox" type="checkbox"
                                    value="{{ Str::lower($equip) }}" id="equip-{{ Str::slug($equip) }}">
                                <label class="form-check-label" for="equip-{{ Str::slug($equip) }}">
                                    {{ $equip }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>



            <!-- Rango de precio -->
            <div class="py-2 text-center">
                @php
                    $maxPrecio = $espacios->max('precio_hora') ?? 0;
                @endphp
                <label for="filter-price">
                    <strong>Precio máximo (€ / h):</strong>
                    <span id="price-display">∞</span>
                </label>
                <input id="filter-price" type="range" min="0" max="{{ $maxPrecio }}" step="1"
                    value="{{ $maxPrecio }}" class="w-full">
            </div>
        </div>
    </section>



    {{-- GRID DE ESPACIOS --}}
    <section class="container espacios-grid">
        @foreach ($espacios as $espacio)
            @if ((auth()->check() && auth()->user()->role === 'admin') || $espacio->estado_espacio === 'disponible')
                <div class="espacios p-4 border rounded-lg mb-6" data-nombre="{{ Str::lower($espacio->nombre) }}"
                    data-precio="{{ $espacio->precio_hora }}"
                    data-equipamiento="{{ Str::lower($espacio->equipamiento ?? '') }}">

                    {{-- Imagen --}}
                    <div class="img-espacios w-full object-cover mb-4">
                        <img src="{{ asset($espacio->imagen_url) }}" alt="Foto de {{ $espacio->nombre }}"
                            class="w-full h-48 object-cover rounded">
                    </div>

                    {{-- Título y acciones según rol --}}
                    <div class="flex items-baseline justify-between mb-2">
                        <h3 class="text-xl font-semibold">
                            <a href="{{ route('espacios.show', $espacio) }}">
                                {{ $espacio->nombre }}
                            </a>
                        </h3>
                        @auth
                            @if (auth()->user()->role === 'admin')
                                <div class="flex space-x-2">
                                    <a href="{{ route('espacios.edit', $espacio) }}" class="btn-custom">
                                        MODIFICAR
                                    </a>
                                    <form action="{{ route('espacios.destroy', $espacio) }}" method="POST"
                                        onsubmit="return confirm('¿Eliminar este espacio?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-custom-dark">
                                            ELIMINAR
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </div>

                    <hr class="my-2">

                    {{-- Precio --}}
                    <p>Precio: <b>{{ number_format($espacio->precio_hora, 2) }} €/h</b></p>

                    {{-- Reseñas con estrellas --}}
                    @if (method_exists($espacio, 'resenas'))
                        @php
                            $media = $espacio->resenas->avg('calificacion') ?: 0;
                        @endphp
                        <div class="flex mb-4">
                            @for ($i = 1; $i <= 5; $i++)
                                @php
                                    $diff = $media - $i + 1;
                                    $img = $diff >= 1 ? 'star-2.png' : ($diff >= 0.5 ? 'star-1.png' : 'star-0.png');
                                @endphp
                                <img src="{{ asset('images/' . $img) }}" alt="" style="width:24px; height:24px;"
                                    class="inline-block mr-1">
                            @endfor
                        </div>
                    @endif

                    {{-- + INFO --}}
                    @if ($espacio->estado_espacio === 'disponible')
                        <a href="{{ route('espacios.show', $espacio) }}"
                            class="btn-custom w-full text-center rounded-full py-2 mb-4">
                            + INFO
                        </a>
                    @endif

                    {{-- Botones admin para aptitud --}}
                    @auth
                        @if (auth()->user()->role === 'admin' && $espacio->estado_espacio === 'no_disponible')
                            <div class="flex space-x-2">
                                <form action="{{ route('espacios.apta', $espacio) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-custom">
                                        APTA
                                    </button>
                                </form>
                                <form action="{{ route('espacios.no_apta', $espacio) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-custom-dark">
                                        NO APTA
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth

                </div>
            @endif
        @endforeach
    </section>
   

    {{-- SCRIPT DE FILTRADO --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const nameInput = document.getElementById('filter-name');
            const priceInput = document.getElementById('filter-price');
            const priceDisplay = document.getElementById('price-display');
            const equipChecks = Array.from(document.querySelectorAll('.equip-checkbox'));
            const espacios = Array.from(document.querySelectorAll('.espacios'));
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

                espacios.forEach(div => {
                    const nombre = div.dataset.nombre;
                    const precio = parseFloat(div.dataset.precio);
                    const equipArr = div.dataset.equipamiento
                        .split(',')
                        .map(e => e.trim());

                    const matchName = !term || nombre.includes(term);
                    const matchPrice = precio <= maxP;
                    const matchEquip = selectedEquip.length === 0 ?
                        true :
                        selectedEquip.some(e => equipArr.includes(e));

                    div.style.display = (matchName && matchPrice && matchEquip) ?
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
                equipContainer.style.display =
                    equipContainer.style.display === 'none' ? 'block' : 'none';
            });

            // Inicialización
            updatePriceLabel();
        });
    </script>


@endsection
