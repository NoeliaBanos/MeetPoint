<main class="max-w-3xl mx-auto py-8 px-4">
<main class="max-w-3xl mx-auto py-8 px-4">

  {{-- CONTACTO --------------------------------------------------------------- --}}
  {{-- Sección contacto 50/50 ---------------------------------------------------- --}}
  <section class="container-fluid py-5">
    <div class="row g-0">

      {{-- Columna 1: Formulario --}}
      <div class="col-12 col-lg-6 p-4 d-flex align-items-center justify-content-center">
        <form action="{{ route('contacto.store') }}" method="POST" class="needs-validation w-100" novalidate>
          @csrf

          <h2 class="mb-4">Contacto</h2>

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

                    {{-- Teléfono (opcional) --}}
                    <div class="form-floating mb-3">
                        <input type="tel" class="form-control" id="telefono" name="telefono"
                            placeholder="612345678" pattern="[0-9]{9}">
                        <label for="telefono">Teléfono (Opcional)</label>
                        <div class="invalid-feedback">Debe tener 9 dígitos.</div>
                    </div>

                    {{-- Mensaje --}}
                    <div class="form-floating mb-4">
                        <textarea class="form-control" id="mensaje" name="mensaje" placeholder="Escribe tu mensaje" style="height: 120px"
                            required></textarea>
                        <label for="mensaje">Mensaje</label>
                        <div class="invalid-feedback">El mensaje no puede quedar vacío.</div>
                    </div>

                    <button type="submit" class="btn-custom w-100">Enviar</button>
                </form>
            </div>

             {{-- Columna 2: Imagen (solo en desktop) --}}
      <div class="col-12 col-lg-6 d-none d-lg-block p-0">
        <img
          src="{{ asset('images/fondo.jpg') }}"
          alt="Imagen decorativa de contacto"
          class="img-fluid object-fit-cover w-100 h-100"
          style="height: 100%;"
        >
      </div>

    </div>
    </section>


</main>

@include('partials.footer')
