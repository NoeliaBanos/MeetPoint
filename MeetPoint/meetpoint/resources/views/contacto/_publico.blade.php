<section class="contact-public">
    <div class="row g-0">
        {{-- Columna 1: Formulario --}}
        <div class="col-12 col-lg-6 form-column">
            <form action="{{ route('contacto.store') }}" method="POST" class="needs-validation" novalidate>
                @csrf

                <h1>Contacto</h1>

                {{-- Asunto --}}
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="asunto" name="asunto" placeholder="Asunto" required>
                    <label for="asunto">Asunto</label>
                    <div class="invalid-feedback">Indica un asunto.</div>
                </div>

                {{-- Nombre --}}
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Tu nombre" required>
                    <label for="nombre">Nombre</label>
                    <div class="invalid-feedback">Por favor ingresa tu nombre.</div>
                </div>

                {{-- Email --}}
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="email" name="email" placeholder="nombre@ejemplo.com" required>
                    <label for="email">Email</label>
                    <div class="invalid-feedback">Introduce un correo válido.</div>
                </div>

                {{-- Teléfono --}}
                <div class="form-floating mb-3">
                    <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Pon tu teléfono" pattern="[0-9]{9}">
                    <label for="telefono">Teléfono</label>
                    <div class="invalid-feedback">Debe tener 9 dígitos.</div>
                </div>

                {{-- Mensaje --}}
                <div class="form-floating mb-4">
                    <textarea class="form-control" id="mensaje" name="mensaje" placeholder="Escribe tu mensaje" required style="height: 150px;"></textarea>
                    <label for="mensaje">Mensaje</label>
                    <div class="invalid-feedback">El mensaje no puede quedar vacío.</div>
                </div>

                <button type="submit" class="btn-custom">Enviar</button>
            </form>
        </div>

        {{-- Columna 2: Imagen --}}
        <div class="col-12 col-lg-6 image-column">
            <img src="{{ asset('images/fondo.jpg') }}" alt="Imagen decorativa de contacto" class="img-fluid h-100">
        </div>
    </div>
</section>