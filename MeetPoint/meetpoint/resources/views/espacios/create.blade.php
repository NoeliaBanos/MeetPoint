@extends('layouts.app')

@section('title', 'Crear Espacio')

@section('content')
<main class="container py-5">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-10">

      <h2 class="mb-4 text-center">Nuevo espacio</h2>

      <form action="{{ route('espacios.store') }}" method="POST" enctype="multipart/form-data"
            class="needs-validation" novalidate>
        @csrf

        {{-- Estado inicial y fecha de publicación oculta --}}
        <input type="hidden" name="estado_espacio" value="no_disponible">
        <input type="hidden" name="fecha_hora" value="{{ now() }}">

        <div class="row g-4">
          {{-- Columna IZQUIERDA --}}
          <div class="col-12 col-lg-6">

            {{-- Nombre --}}
            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="nombre" name="nombre"
                     placeholder="Nombre del espacio" value="{{ old('nombre') }}" required>
              <label for="nombre">Nombre del espacio</label>
              <div class="invalid-feedback">Indica un nombre.</div>
            </div>

            {{-- Precio por hora --}}
            <div class="form-floating mb-3">
              <input type="number" step="0.01" class="form-control" id="precio_hora"
                     name="precio_hora" placeholder="0.00"
                     value="{{ old('precio_hora') }}" required>
              <label for="precio_hora">Precio por hora (€)</label>
              <div class="invalid-feedback">Indica el precio por hora.</div>
            </div>

            {{-- Capacidad --}}
            <div class="form-floating mb-3">
              <input type="number" class="form-control" id="capacidad" name="capacidad"
                     placeholder="Capacidad" value="{{ old('capacidad') }}" required>
              <label for="capacidad">Capacidad (nº personas)</label>
              <div class="invalid-feedback">Indica la capacidad.</div>
            </div>

            {{-- Equipamiento como dropdown --}}
            @php
              $equip_old = old('equipamiento', []);
              $items = [
                'Proyector','Pizarra','WiFi','Micrófono','Pantalla',
                'Climatización','Enchufes','Cafetera','Escritorios',
                'Sillas','Aire Acondicionado','Mesas','Sombrillas',
                'Impresora','Escáner','Videoconferencia','Pizarra Blanca',
                'Conexión Ethernet','Lámpara de escritorio'
              ];
            @endphp

            <div class="mb-4">
              <label class="form-label fw-semibold d-block">Equipamiento</label>
              <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle w-100 text-start"
                        type="button"
                        id="equipDropdown"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                  Seleccionar equipamiento
                </button>
                <ul class="dropdown-menu p-2"
                    aria-labelledby="equipDropdown"
                    style="max-height: 300px; overflow-y: auto;">
                  @foreach($items as $item)
                    <li>
                      <div class="form-check">
                        <input class="form-check-input"
                               type="checkbox"
                               name="equipamiento[]"
                               id="equip_{{ Str::slug($item, '_') }}"
                               value="{{ $item }}"
                               {{ in_array($item, $equip_old) ? 'checked' : '' }}>
                        <label class="form-check-label"
                               for="equip_{{ Str::slug($item, '_') }}">
                          {{ $item }}
                        </label>
                      </div>
                    </li>
                  @endforeach

                  <li><hr class="dropdown-divider"></li>

                  <li>
                    <div class="form-check">
                      <input class="form-check-input"
                             type="checkbox"
                             id="equip_otros"
                             name="equipamiento[]"
                             value="Otros"
                             {{ in_array('Otros', $equip_old) ? 'checked' : '' }}>
                      <label class="form-check-label" for="equip_otros">
                        Otros
                      </label>
                    </div>
                  </li>
                  <li id="otros-item" style="display: none;">
                    <input type="text"
                           class="form-control mt-2"
                           name="equipamiento_otros"
                           id="equipamiento_otros"
                           placeholder="Especifica otros equipamientos"
                           value="{{ old('equipamiento_otros') }}">
                  </li>
                </ul>
              </div>
            </div>
          </div>

          {{-- Columna DERECHA --}}
          <div class="col-12 col-lg-6">
            {{-- Descripción --}}
            <div class="form-floating mb-4">
              <textarea class="form-control" id="descripcion" name="descripcion"
                        style="height: 140px" placeholder="Descripción"
                        required>{{ old('descripcion') }}</textarea>
              <label for="descripcion">Descripción</label>
              <div class="invalid-feedback">Añade una descripción.</div>
            </div>

            {{-- Imagen --}}
            <div class="mb-4">
              <label for="imagen" class="form-label">Imagen principal</label>
              <input class="form-control" type="file" id="imagen"
                     name="imagen" accept="image/*">
            </div>
          </div>
        </div>

        <button type="submit" class="btn-custom w-100 mt-2">CONFIRMAR</button>
      </form>

    </div>
  </div>
</main>
@include('partials.result-modal')

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  const chkOtros = document.getElementById('equip_otros');
  const otrosItem = document.getElementById('otros-item');

  function toggleOtros() {
    otrosItem.style.display = chkOtros.checked ? 'block' : 'none';
  }

  chkOtros.addEventListener('change', toggleOtros);
  toggleOtros();
});
</script>
@endpush
@include('partials.footer')

@endsection
