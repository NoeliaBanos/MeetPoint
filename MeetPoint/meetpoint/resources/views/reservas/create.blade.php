@extends('layouts.app')

@section('title', 'Reservar')

@section('content')
    <h1 class="mb-4">Reserva – {{ $espacio->nombre }}</h1>

    <form method="POST" action="{{ route('reservas.store', $espacio) }}" id="formReserva">
        @csrf

        {{-- FECHA ----------------------------------------------------------- --}}
        <label class="block mb-2 font-semibold">Fecha:</label>
        <input type="date" name="fecha" id="fecha" class="border p-2 rounded w-52" min="{{ now()->toDateString() }}"
            required>

        {{-- HORAS ----------------------------------------------------------- --}}
        <h2 class="mt-6 mb-2 font-semibold">
            Horas ({{ number_format($espacio->precio_hora, 2) }} €/h):
        </h2>
        <ul id="hoursWrapper" class="space-y-2"></ul>

        {{-- TOTAL ----------------------------------------------------------- --}}
        <p id="summary" class="mt-4 text-lg font-semibold hidden">
            Total: <span id="total">0,00</span> €
        </p>

        <button class="btn-custom mt-6" id="btnSubmit" type="submit" disabled>
            Continuar a pago
        </button>
    </form>

    {{-- --------------  SCRIPT IN-LINE, GARANTIZADO -------------- --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const precioHora = {{ $espacio->precio_hora }};
            const fechaInput = document.getElementById('fecha');
            const hoursWrap = document.getElementById('hoursWrapper');
            const totalSpan = document.getElementById('total');
            const btnSubmit = document.getElementById('btnSubmit');
            const summaryBox = document.getElementById('summary');

            /* genera checkboxes 09-21 */
            function drawHours() {
                hoursWrap.innerHTML = ''; // limpia
                for (let h = 9; h <= 21; h++) {
                    const li = document.createElement('li');
                    const label = document.createElement('label');
                    label.className = 'inline-flex items-center gap-2 cursor-pointer';

                    const cb = document.createElement('input');
                    cb.type = 'checkbox';
                    cb.name = 'hours[]';
                    cb.value = h;
                    cb.addEventListener('change', updateTotal);

                    label.appendChild(cb);
                    label.append(`${h}:00`);
                    li.appendChild(label);
                    hoursWrap.appendChild(li);
                }
            }

            /* actualiza total */
            function updateTotal() {
                const horasSel = hoursWrap.querySelectorAll('input:checked').length;
                if (horasSel === 0) {
                    btnSubmit.disabled = true;
                    summaryBox.classList.add('hidden');
                } else {
                    const total = (horasSel * precioHora).toFixed(2).replace('.', ',');
                    totalSpan.textContent = total;
                    btnSubmit.disabled = false;
                    summaryBox.classList.remove('hidden');
                }
            }

            /* cambia fecha → pinta horas y reinicia total */
            fechaInput.addEventListener('change', () => {
                if (!fechaInput.value) return;
                drawHours();
                updateTotal();
            });
        });
    </script>
@endsection
