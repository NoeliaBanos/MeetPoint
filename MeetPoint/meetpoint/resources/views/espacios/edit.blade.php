{{-- resources/views/espacios/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Editar Espacio')

@section('content')
    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">

                <h1 class="mb-4 text-center">Editar espacio</h1>

                <form action="{{ route('espacios.update', $espacio) }}" method="POST" enctype="multipart/form-data"
                    class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')

                    {{-- Ocultos: mantenemos el estado y fecha si quieres --}}
                    <input type="hidden" name="estado_espacio" value="{{ old('estado_espacio', $espacio->estado_espacio) }}">


                    <div class="row g-4">
                        {{-- IZQUIERDA --}}
                        <div class="col-12 col-lg-6">
                            {{-- Nombre --}}
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="nombre" name="nombre"
                                    placeholder="Nombre del espacio" value="{{ old('nombre', $espacio->nombre) }}" required>
                                <label for="nombre">Nombre del espacio</label>
                                <div class="invalid-feedback">Indica un nombre.</div>
                            </div>

                            {{-- Precio y Capacidad (2 en fila) --}}
                            <div class="row gx-2">
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" step="0.01" class="form-control" id="precio_hora"
                                            name="precio_hora" placeholder="0.00"
                                            value="{{ old('precio_hora', $espacio->precio_hora) }}" required>
                                        <label for="precio_hora">Precio por hora (€)</label>
                                        <div class="invalid-feedback">Indica el precio por hora.</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control" id="capacidad" name="capacidad"
                                            placeholder="Capacidad" value="{{ old('capacidad', $espacio->capacidad) }}"
                                            required>
                                        <label for="capacidad">Capacidad (nº personas)</label>
                                        <div class="invalid-feedback">Indica la capacidad.</div>
                                    </div>
                                </div>
                            </div>

                            {{-- Equipamiento --}}
                            @php
                                // Equipamiento previo como array
                                $equip_old = old(
                                    'equipamiento',
                                    $espacio->equipamiento ? explode(',', $espacio->equipamiento) : [],
                                );
                                $items = [
                                    'Proyector',
                                    'Pizarra',
                                    'WiFi',
                                    'Micrófono',
                                    'Pantalla',
                                    'Climatización',
                                    'Enchufes',
                                    'Cafetera',
                                    'Escritorios',
                                    'Sillas',
                                    'Aire Acondicionado',
                                    'Mesas',
                                    'Sombrillas',
                                    'Impresora',
                                    'Escáner',
                                    'Videoconferencia',
                                    'Pizarra Blanca',
                                    'Conexión Ethernet',
                                    'Lámpara de escritorio',
                                ];
                            @endphp

                            <div class="mb-2">
                                <label class="form-label fw-semibold d-block">Equipamiento</label>
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary dropdown-toggle w-100 text-start"
                                        type="button" id="equipDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        Seleccionar equipamiento
                                    </button>
                                    <ul class="dropdown-menu p-2" aria-labelledby="equipDropdown"
                                        style="max-height:250px;overflow-y:auto">
                                        @foreach ($items as $item)
                                            <li class="px-1">
                                                <div class="form-check">
                                                    <input class="form-check-input equip-checkbox" type="checkbox"
                                                        name="equipamiento[]" id="equip_{{ Str::slug($item, '_') }}"
                                                        value="{{ $item }}"
                                                        {{ in_array($item, $equip_old) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="equip_{{ Str::slug($item, '_') }}">
                                                        {{ $item }}
                                                    </label>
                                                </div>
                                            </li>
                                        @endforeach
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li class="px-1">
                                            <div class="form-check">
                                                <input class="form-check-input equip-checkbox" type="checkbox"
                                                    id="equip_otros" name="equipamiento[]" value="Otros"
                                                    {{ in_array('Otros', $equip_old) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="equip_otros">Otros</label>
                                            </div>
                                        </li>
                                        <li id="otros-item" class="px-1" style="display:none;">
                                            <input type="text" class="form-control mt-2" id="equipamiento_otros"
                                                name="equipamiento_otros" placeholder="Especifica otros equipamientos"
                                                value="{{ old('equipamiento_otros', $espacio->equipamiento_otros ?? '') }}">
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div id="selected-equip" class="mb-4"></div>
                        </div>

                        {{-- DERECHA --}}
                        <div class="col-12 col-lg-6">
                            {{-- Descripción --}}
                            <div class="form-floating mb-4">
                                <textarea class="form-control" id="descripcion" name="descripcion" style="height:140px" placeholder="Descripción"
                                    required>{{ old('descripcion', $espacio->descripcion) }}</textarea>
                                <label for="descripcion">Descripción</label>
                                <div class="invalid-feedback">Añade una descripción.</div>
                            </div>

                            {{-- Imagen actual y nueva --}}
                            @if ($espacio->imagen_url)
                                <div class="mb-3">
                                    <p class="mb-1"><strong>Imagen actual:</strong></p>
                                    <img src="{{ asset($espacio->imagen_url) }}" alt="Actual {{ $espacio->nombre }}"
                                        class="img-fluid rounded mb-2" style="max-height:200px;">
                                </div>
                            @endif

                            <div class="mb-4">
                                <label for="imagen" class="form-label">Cambiar imagen</label>
                                <input class="form-control" type="file" id="imagen" name="imagen"
                                    accept="image/*">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-custom w-100 mt-2">ACTUALIZAR</button>
                </form>

                {{-- Modal de resultado --}}
                @if (session('success') || $errors->any())
                    <div class="modal fade" id="resultModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        @if (session('success'))
                                            ¡Éxito!
                                        @else
                                            Ha ocurrido un error
                                        @endif
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    @if (session('success'))
                                        <p>{{ session('success') }}</p>
                                    @else
                                        <p>No se han guardado los datos por los siguientes motivos:</p>
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $err)
                                                <li>{{ $err }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                                <div class="modal-footer">
                                    @if (session('success'))
                                        <button type="button" class="btn btn-custom"
                                            data-bs-dismiss="modal">Cerrar</button>
                                    @else
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Volver y
                                            corregir</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </main>
    
{{-- Modal de confirmación --}}
@if(session('success'))
  <div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">¡Éxito!</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>El espacio se ha actualizado correctamente.</p>
        </div>
        <div class="modal-footer">
          <button id="confirmOk" type="button" class="btn btn-custom" data-bs-dismiss="modal">
            Aceptar
          </button>
        </div>
      </div>
    </div>
  </div>
@endif
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Mostrar modal si hay éxito o errores
            @if (session('success') || $errors->any())
                const modalEl = document.getElementById('resultModal');
                const bsModal = new bootstrap.Modal(modalEl);
                bsModal.show();

                @if (session('success'))
                    modalEl.addEventListener('hide.bs.modal', () => {
                        window.location.href = "{{ route('espacios.show', $espacio) }}";
                    });
                @endif
            @endif

            // Lógica de chips Equipamiento
            const chkOtros = document.getElementById('equip_otros');
            const otrosItem = document.getElementById('otros-item');
            const allCheckboxes = document.querySelectorAll('.equip-checkbox');
            const selectedContainer = document.getElementById('selected-equip');

            function toggleOtros() {
                otrosItem.style.display = chkOtros.checked ? 'block' : 'none';
            }

            function refreshSelectedList() {
                selectedContainer.innerHTML = '';
                allCheckboxes.forEach(chk => {
                    if (!chk.checked) return;
                    let val = chk.value;
                    if (val === 'Otros') {
                        const txt = document.getElementById('equipamiento_otros').value.trim();
                        if (!txt) return;
                        val = txt;
                    }
                    const badge = document.createElement('span');
                    badge.className = 'badge bg-secondary me-1 mb-1';
                    badge.textContent = val;

                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'btn-close btn-close-white btn-sm ms-1';
                    btn.setAttribute('aria-label', 'Quitar');
                    btn.onclick = () => {
                        chk.checked = false;
                        if (chk.id === 'equip_otros') toggleOtros();
                        refreshSelectedList();
                    };

                    badge.appendChild(btn);
                    selectedContainer.appendChild(badge);
                });
            }

            allCheckboxes.forEach(chk =>
                chk.addEventListener('change', () => {
                    toggleOtros();
                    refreshSelectedList();
                })
            );
            document.getElementById('equipamiento_otros')
                .addEventListener('input', refreshSelectedList);

            // init
            toggleOtros();
            refreshSelectedList();
        });
        document.addEventListener('DOMContentLoaded', () => {
  @if(session('success'))
    // Mostrar el modal
    const modalEl = document.getElementById('confirmModal');
    const bsModal = new bootstrap.Modal(modalEl);
    bsModal.show();

    // Al cerrar el modal o al pulsar “Aceptar”, vamos a la lista
    modalEl.addEventListener('hidden.bs.modal', () => {
      window.location.href = "{{ route('espacios.index') }}";
    });
    document.getElementById('confirmOk')
            .addEventListener('click', () => bsModal.hide());
  @endif
});
    </script>
@endpush
