{{-- CONTACTO --------------------------------------------------------------- --}}

<section class="container-fluid py-5">
    <div class="row g-0">

        {{-- Columna 1: Formulario --}}
        <div class="col-12 col-lg-6 p-4 d-flex align-items-center justify-content-center">
            <form action="{{ route('contacto.store') }}" method="POST" class="needs-validation w-100" novalidate>
                @csrf

                <h1 class="mb-4 text-center">Contacto</h1>

                {{-- Asunto --}}
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="asunto" name="asunto" placeholder="Asunto"
                        required>
                    <label for="asunto">Asunto</label>
                    <div class="invalid-feedback">Indica un asunto.</div>
                </div>

                {{-- Email --}}
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="email" name="email"
                        placeholder="nombre@ejemplo.com" required>
                    <label for="email">Email</label>
                    <div class="invalid-feedback">Introduce un correo válido.</div>
                </div>

                {{-- Teléfono --}}
                <div class="form-floating mb-3">
                    <input type="tel" class="form-control" id="telefono" name="telefono"
                        placeholder="Pon tu teléfono" pattern="[0-9]{9}">
                    <label for="telefono">Teléfono</label>
                    <div class="invalid-feedback">Debe tener 9 dígitos.</div>
                </div>

                {{-- Mensaje --}}
                <div class="form-floating mb-4">
                    <textarea class="form-control" id="mensaje" name="mensaje" placeholder="Escribe tu mensaje" required></textarea>
                    <label for="mensaje">Mensaje</label>
                    <div class="invalid-feedback">El mensaje no puede quedar vacío.</div>
                </div>

                <button type="submit" class="btn-custom w-100">Enviar</button>
            </form>
        </div>

        {{-- Columna 2: Imagen (solo en desktop) --}}
        <div class="col-12 col-lg-6  p-0 img-half ">
            <img src="{{ asset('images/fondo.jpg') }}" alt="Imagen decorativa de contacto"
                class="img-fluid object-fit-cover">
        </div>

    </div>
</section>



@include('partials.footer')
