{{-- resources/views/reservas/pay.blade.php --}}
@extends('layouts.app')

@section('title', 'Confirmar y pagar')

@section('content')
    <div class="container py-5">
        <div class="reserva-card">
            <div class="reserva-content">
                {{-- CABECERA --}}
                <h1>
                    Confirmación de reserva
                </h1>

                {{-- DETALLES DE LA RESERVA --}}
                <div class="reserva-details">
                    {{-- Espacio --}}
                    <div class="detail-row">
                        <span class="detail-label">Espacio:</span>
                        <span class="detail-value">{{ $reserva->espacio->nombre }}</span>
                    </div>

                    {{-- Fecha --}}
                    <div class="detail-row">
                        <span class="detail-label">Fecha:</span>
                        <span class="detail-value">{{ \Carbon\Carbon::parse($reserva->fecha)->format('d/m/Y') }}</span>
                    </div>

                    {{-- Hora de entrada / salida --}}
                    <div class="detail-row">
                        <span class="detail-label">Hora de entrada:</span>
                        <span class="detail-value">{{ \Carbon\Carbon::parse($reserva->hora_entrada)->format('H:i') }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Hora de salida:</span>
                        <span class="detail-value">{{ \Carbon\Carbon::parse($reserva->hora_salida)->format('H:i') }}</span>
                    </div>

                    {{-- Duración --}}
                    @php
                        $hours =
                            \Carbon\Carbon::parse($reserva->hora_entrada)->diffInMinutes(
                                \Carbon\Carbon::parse($reserva->hora_salida),
                            ) / 60;
                    @endphp
                    <div class="detail-row">
                        <span class="detail-label">Duración:</span>
                        <span class="detail-value">{{ number_format($hours, 1) }} h</span>
                    </div>

                    {{-- Capacidad (extra) --}}
                    <div class="detail-row">
                        <span class="detail-label">Capacidad sala:</span>
                        <span class="detail-value">{{ $reserva->espacio->capacidad }} personas</span>
                    </div>
                </div>

                {{-- PRECIO --}}
                <div class="reserva-total">
                    <p class="total-label">Total a pagar</p>
                    <p class="total-amount">
                        {{ number_format($reserva->importe, 2, ',', '.') }} €
                    </p>
                </div>

                {{-- BOTÓN DE PAGO --}}
                <div class="reserva-actions">
                    <button id="btnPagar" class="btn-pagar">
                        Pagar con PayPal
                    </button>
                    <p class="payment-note">
                        Serás redirigido a PayPal en una nueva pestaña.
                    </p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('btnPagar').addEventListener('click', async () => {
                /* 1 – Marcar la reserva como pagada en BD */
                await fetch('{{ route('reservas.markPaid', $reserva) }}', {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                });

                /* 2 – Abrir PayPal en una pestaña nueva */
                const amount = '{{ number_format($reserva->importe, 2, '.', '') }}';
                window.open(
                    `https://www.paypal.me/nissolia/${amount}?currencyCode=EUR`,
                    '_blank'
                );

                /* 3 – Volver al listado */
                window.location.href = "{{ route('espacios.index') }}";
            });
        </script>
    @endpush
@endsection
