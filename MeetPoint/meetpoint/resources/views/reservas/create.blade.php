@extends('layouts.app')

@section('title', 'Reservar')

@section('content')
    <div class="reserva-container">
        <div class="reserva-card">
            <h1>
                Reserva – {{ $espacio->nombre }}
            </h1>

            <form method="POST" action="{{ route('reservas.store', $espacio) }}" id="formReserva"
                data-espacio-id="{{ $espacio->id }}" data-precio-hora="{{ $espacio->precio_hora }}"
                data-hora-apertura="{{ substr($espacio->hora_apertura, 0, 5) }}"
                data-hora-cierre="{{ substr($espacio->hora_cierre, 0, 5) }}" class="reserva-form">
                @csrf

                {{-- Fecha --}}
                <div class="form-group">
                    <label for="fecha" class="form-label">Fecha:</label>
                    <input type="date" name="fecha" id="fecha" class="form-input" min="{{ now()->toDateString() }}"
                        required>
                </div>

                {{-- Hora de entrada --}}
                <div class="form-group">
                    <label for="horaEntrada" class="form-label">Hora de entrada:</label>
                    <input type="time" name="hora_entrada" id="horaEntrada" class="form-input" disabled required>
                    <p id="errorMessage" class="error-message hidden"></p>
                </div>

                {{-- Hora de salida --}}
                <div class="form-group">
                    <label for="horaSalida" class="form-label">Hora de salida:</label>
                    <input type="time" name="hora_salida" id="horaSalida" class="form-input" disabled required>
                </div>

                {{-- Resumen --}}
                <div class="selection-summary hidden" id="selectionSummary">
                    <p class="summary-text">
                        Has seleccionado: <span id="selFecha" class="highlight"></span>
                        de <span id="selStart" class="highlight"></span> a <span id="selEnd" class="highlight"></span>
                    </p>
                </div>

                {{-- Total --}}
                <div class="total-summary hidden" id="summary">
                    <p class="total-text">
                        Total: <span id="total" class="total-amount">0,00</span> €
                    </p>
                </div>

                {{-- Campos ocultos --}}
                <input type="hidden" name="fecha_hora" id="fechaHora" value="">
                <input type="hidden" name="importe" id="importe" value="0">

                <div class="form-actions">
                    <button type="submit" id="btnSubmit" class="btn-custom" disabled>
                        Continuar a pago
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('formReserva');
            const espacioId = form.dataset.espacioId;
            const precioHora = parseFloat(form.dataset.precioHora);
            const horaApertura = form.dataset.horaApertura;
            const horaCierre = form.dataset.horaCierre;

            const fechaInput = document.getElementById('fecha');
            const startInput = document.getElementById('horaEntrada');
            const endInput = document.getElementById('horaSalida');
            const errorMessage = document.getElementById('errorMessage');
            const selSummary = document.getElementById('selectionSummary');
            const selFecha = document.getElementById('selFecha');
            const selStart = document.getElementById('selStart');
            const selEnd = document.getElementById('selEnd');
            const summary = document.getElementById('summary');
            const totalSpan = document.getElementById('total');
            const fechaHoraIn = document.getElementById('fechaHora');
            const importeIn = document.getElementById('importe');
            const btnSubmit = document.getElementById('btnSubmit');

            let reserved = [];

            function resetAll() {
                startInput.value = '';
                endInput.value = '';
                startInput.disabled = true;
                endInput.disabled = true;
                errorMessage.textContent = '';
                errorMessage.classList.add('hidden');
                selSummary.classList.add('hidden');
                summary.classList.add('hidden');
                btnSubmit.disabled = true;
                totalSpan.textContent = '0,00';
                fechaHoraIn.value = '';
                importeIn.value = '0';
                reserved = [];
            }

            function addMinutes(time, mins) {
                const [h, m] = time.split(':').map(Number);
                const d = new Date();
                d.setHours(h, m + mins, 0);
                return d.toTimeString().slice(0, 5);
            }

            // 1) Al cambiar fecha, cargar reservas
            fechaInput.addEventListener('change', async () => {
                resetAll();
                if (!fechaInput.value) return;

                try {
                    const res = await fetch(
                        `/espacios/${espacioId}/reserved-intervals?fecha=${fechaInput.value}`);
                    const data = res.ok ? await res.json() : [];
                    reserved = data.map(i => ({
                        start: i.hora_entrada.slice(0, 5),
                        end: i.hora_salida.slice(0, 5),
                    }));
                } catch {
                    reserved = [];
                }

                startInput.disabled = false;
                startInput.min = horaApertura;
                startInput.max = horaCierre;
            });

            // 2) Validar hora de entrada
            startInput.addEventListener('input', () => {
                endInput.value = '';
                endInput.disabled = true;
                errorMessage.textContent = '';
                errorMessage.classList.add('hidden');
                selSummary.classList.add('hidden');
                summary.classList.add('hidden');
                btnSubmit.disabled = true;

                const dateVal = fechaInput.value;
                const sVal = startInput.value;
                if (!dateVal || !sVal) return;

                const dtStart = new Date(`${dateVal}T${sVal}:00`);
                const now = new Date();
                if (dtStart < now) {
                    errorMessage.textContent = 'La entrada debe ser en el futuro.';
                    errorMessage.classList.remove('hidden');
                    return;
                }
                if (reserved.some(r => sVal >= r.start && sVal < r.end)) {
                    errorMessage.textContent = 'La sala ya está reservada en esa hora.';
                    errorMessage.classList.remove('hidden');
                    return;
                }

                const next = reserved
                    .filter(r => r.start > sVal)
                    .sort((a, b) => a.start.localeCompare(b.start))[0];

                endInput.min = addMinutes(sVal, 1);
                endInput.max = next ? next.start : horaCierre;
                endInput.disabled = false;
            });

            // 3) Validar salida y calcular total + campos ocultos
            endInput.addEventListener('input', () => {
                errorMessage.textContent = '';
                errorMessage.classList.add('hidden');
                summary.classList.add('hidden');
                btnSubmit.disabled = true;
                selSummary.classList.add('hidden');

                const dateVal = fechaInput.value;
                const sVal = startInput.value;
                const eVal = endInput.value;
                if (!dateVal || !sVal || !eVal) return;

                const dtStart = new Date(`${dateVal}T${sVal}:00`);
                const dtEnd = new Date(`${dateVal}T${eVal}:00`);
                const now = new Date();

                if (dtEnd <= dtStart) {
                    errorMessage.textContent = 'La salida debe ser posterior a la entrada.';
                    errorMessage.classList.remove('hidden');
                    return;
                }
                if (dtEnd < now) {
                    errorMessage.textContent = 'La salida debe ser en el futuro.';
                    errorMessage.classList.remove('hidden');
                    return;
                }

                // Mostrar resumen
                selFecha.textContent = new Date(dateVal).toLocaleDateString();
                selStart.textContent = sVal;
                selEnd.textContent = eVal;
                selSummary.classList.remove('hidden');

                // Calcular total
                const horas = (dtEnd - dtStart) / 1000 / 60 / 60;
                const total = (horas * precioHora).toFixed(2).replace('.', ',');
                totalSpan.textContent = total;
                importeIn.value = total.replace(',', '.');

                // Rellenar fecha_hora
                fechaHoraIn.value = `${dateVal} ${sVal}:00`;
                startInput.value = startInput.value + ':00';
                endInput.value = endInput.value + ':00';

                summary.classList.remove('hidden');
                btnSubmit.disabled = false;
            });

            resetAll();
        });
    </script>
@endpush
