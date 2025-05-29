<main class="max-w-3xl mx-auto py-8 px-4">
    <h1 class="text-3xl font-semibold mb-4">Preguntas frecuentes (FAQ)</h1>

    {{-- Índice --}}
    <ul class="indice mb-8">
        <li><a href="#alta">Registro y alta de centro</a></li>
      
   
  
        <li><a href="#reservas">Reservas & oportunidades</a></li>
        <li><a href="#otros">Otras dudas</a></li>
        <li><a href="#contacto">Contacto</a></li>
    </ul>

    {{-- 1. REGISTRO Y ALTA DE CENTRO ------------------------------------------- --}}
    <section id="alta" class="mb-8">
        <h2 class="text-2xl font-semibold mb-4">Registro y alta de centro</h2>

        {{-- …preguntas que ya tuvieras… --}}

        <h3 class="font-medium">¿Quién puede dar de alta una sala?</h3>
        <p>
            Solo los <strong>usuarios autenticados</strong> pueden crear nuevas salas.  
            Al publicar, se les asigna automáticamente el rol <em>propietario</em>.  
            Sin embargo, la sala queda <strong>pendiente de revisión</strong> y debe ser
            aprobada por nuestro equipo de administración (equipo cerrado) antes de
            mostrarse al público.
        </p>
    </section>

    {{-- 5. RESERVAS & OPORTUNIDADES ------------------------------------------- --}}
    <section id="reservas" class="mb-8">
        <h2 class="text-2xl font-semibold mb-4">Reservas & oportunidades</h2>

        {{-- …preguntas que ya tuvieras… --}}

        <h3 class="font-medium">¿Cuándo puedo reservar una sala?</h3>
        <p>
            En cualquier momento, siempre y cuando la sala aparezca como
            <strong>disponible en el calendario</strong>.  
            El sistema impide automáticamente solapamientos con otras reservas
            confirmadas.
        </p>

        <h3 class="font-medium">¿Puedo dejar una reseña sin haber reservado?</h3>
        <p>
            No. Las reseñas solo las pueden publicar los usuarios que hayan
            completado <strong>una reserva exitosa</strong> de la sala.  
            Así garantizamos que las valoraciones proceden de experiencias reales.
        </p>
    </section>

    {{-- 6. OTRAS DUDAS --------------------------------------------------------- --}}
    <section id="otros" class="mb-8">
        <h2 class="text-2xl font-semibold mb-4">Otras dudas</h2>
        {{-- aquí siguen tus demás preguntas --}}
    </section>

    <hr class="my-8">

    {{-- CONTACTO --------------------------------------------------------------- --}}
    <h2 id="contacto" class="text-2xl font-semibold mb-4">Contacto</h2>
    <form action="{{ route('contacto.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label for="asunto" class="block text-gray-700 mb-1">Asunto</label>
            <input type="text" name="asunto" id="asunto" required
                   class="w-full p-3 rounded-xl shadow-inner focus:outline-none">
        </div>
        <div>
            <label for="email" class="block text-gray-700 mb-1">Email</label>
            <input type="email" name="email" id="email" required
                   class="w-full p-3 rounded-xl shadow-inner focus:outline-none">
        </div>
        <div>
            <label for="telefono" class="block text-gray-700 mb-1">Teléfono (Opcional)</label>
            <input type="text" name="telefono" id="telefono"
                   class="w-full p-3 rounded-xl shadow-inner focus:outline-none">
        </div>
        <div>
            <label for="mensaje" class="block text-gray-700 mb-1">Mensaje</label>
            <textarea name="mensaje" id="mensaje" rows="4" required
                      class="w-full p-3 rounded-xl shadow-inner focus:outline-none"></textarea>
        </div>

        <button type="submit"
                class="w-full bg-teal-400 hover:bg-teal-500 text-white font-bold py-3 rounded-full">
            Enviar
        </button>
    </form>
</main>

@include('partials.footer')
