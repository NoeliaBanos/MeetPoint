@extends('layouts.app')

@section('title', 'Crear Espacio')

@section('content')
<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">  {{-- ancho algo mayor para la doble columna --}}

            <h2 class="mb-4 text-center">Nuevo espacio</h2>

            <form action="{{ route('espacios.store') }}" method="POST"
                  enctype="multipart/form-data"
                  class="needs-validation" novalidate>
                @csrf
                <input type="hidden" name="estado_espacio" value="no_disponible">

                {{-- Fila que se parte en 2 columnas en ≥ lg --}}
                <div class="row g-4">

                    {{-- Columna IZQUIERDA (lg: 6 de 12) --}}
                    <div class="col-12 col-lg-6">

                        {{-- Nombre --}}
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="nombre"
                                   name="nombre" placeholder="Nombre del espacio"
                                   value="{{ old('nombre') }}" required>
                            <label for="nombre">Nombre del espacio</label>
                            <div class="invalid-feedback">Indica un nombre.</div>
                        </div>

                        {{-- Precio por hora --}}
                        <div class="form-floating mb-3">
                            <input type="number" step="0.01" class="form-control"
                                   id="precio_hora" name="precio_hora"
                                   placeholder="0.00"
                                   value="{{ old('precio_hora') }}" required>
                            <label for="precio_hora">Precio por hora (€)</label>
                            <div class="invalid-feedback">Indica el precio por hora.</div>
                        </div>

                        {{-- Equipamiento --}}
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="equipamiento"
                                   name="equipamiento"
                                   placeholder="Proyector, WiFi, Pizarra"
                                   value="{{ old('equipamiento') }}">
                            <label for="equipamiento">Equipamiento (separado por comas)</label>
                        </div>
                    </div>

                    {{-- Columna DERECHA (lg: 6 de 12) --}}
                    <div class="col-12 col-lg-6">

                        {{-- Descripción --}}
                        <div class="form-floating mb-4">
                            <textarea class="form-control" id="descripcion"
                                      name="descripcion" style="height: 140px"
                                      placeholder="Descripción" required>{{ old('descripcion') }}</textarea>
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

                </div> {{-- /.row --}}

                {{-- Botón confirmar ocupa toda la fila --}}
                <button type="submit" class="btn-custom w-100 mt-2">CONFIRMAR</button>
            </form>

        </div>
    </div>
</main>

@include('partials.footer')
@endsection
