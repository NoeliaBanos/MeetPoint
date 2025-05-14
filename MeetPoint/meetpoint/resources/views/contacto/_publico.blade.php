<main class="max-w-3xl mx-auto py-8 px-4">
    <h1 class="text-3xl font-semibold mb-4">Preguntas frecuentes (FAQ)</h1>

    {{-- Índice --}}
    <ul class="indice mb-8">
        <li><a href="#alta">Registro y alta de centro</a></li>
        <li><a href="#planes">Planes Premium & tarifas</a></li>
        <li><a href="#cuenta">Gestión de cuenta</a></li>
        <li><a href="#ventas">Ventas y facturación</a></li>
        <li><a href="#reservas">Reservas & oportunidades</a></li>
        <li><a href="#otros">Otras dudas</a></li>
        <li><a href="#contacto">Contacto</a></li>
    </ul>

    {{-- Aquí van tus secciones de FAQ (1 a 6) tal como ya las tenías... --}}
    {{-- ... --}}

    <hr class="my-8">

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
