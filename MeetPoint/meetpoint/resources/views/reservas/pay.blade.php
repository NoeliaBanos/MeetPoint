{{-- resources/views/reservas/pay.blade.php --}}
@extends('layouts.app')

@section('title', 'Confirmar y pagar')

@section('content')
    <div class="payment-container">
        <div class="payment-card">
            {{-- CABECERA CON ICONO --}}
            <div class="payment-header">
                <div class="payment-icon">

                </div>
                <h1>
                    Confirmación de reserva
                </h1>
                <p class="payment-subtitle">Revisa los detalles antes de proceder al pago</p>
            </div>

            {{-- TARJETA DE DETALLES --}}
            <div class="details-card">
                <div class="details-header">
                    <h2>Detalles de tu reserva</h2>
                    <div class="details-badge">
                        <span class="badge-text">Reserva #{{ $reserva->id }}</span>
                    </div>
                </div>

                <div class="details-grid">
                    {{-- Espacio --}}
                    <div class="detail-item">
                        <div class="detail-content">
                            <span class="detail-label">Espacio reservado:</span>
                            <span class="detail-value">{{ $reserva->espacio->nombre }}</span>
                        </div>
                    </div>
                    {{-- Fecha --}}
                    <div class="detail-item">
                        <div class="detail-content">
                            <span class="detail-label">Fecha:</span>
                            <span
                                class="detail-value">{{ \Carbon\Carbon::parse($reserva->fecha)->isoFormat('dddd, D [de] MMMM [de] YYYY') }}</span>
                        </div>
                    </div>

                    {{-- Horario --}}
                    <div class="detail-item">

                        <div class="detail-content">
                            <span class="detail-label">Horario:</span>
                            <span class="detail-value">
                                {{ \Carbon\Carbon::parse($reserva->hora_entrada)->format('H:i') }} -
                                {{ \Carbon\Carbon::parse($reserva->hora_salida)->format('H:i') }}
                            </span>
                        </div>
                    </div>

                    {{-- Duración --}}
                    @php
                        $hours =
                            \Carbon\Carbon::parse($reserva->hora_entrada)->diffInMinutes(
                                \Carbon\Carbon::parse($reserva->hora_salida),
                            ) / 60;
                    @endphp
                    <div class="detail-item">

                        <div class="detail-content">
                            <span class="detail-label">Duración:</span>
                            <span class="detail-value">{{ number_format($hours, 1) }} horas</span>
                        </div>
                    </div>

                    {{-- Capacidad --}}
                    <div class="detail-item">

                        <div class="detail-content">
                            <span class="detail-label">Capacidad máxima:</span>
                            <span class="detail-value">{{ $reserva->espacio->capacidad }} personas</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RESUMEN DE PAGO --}}
            <div class="payment-summary">
                <div>
                    <h2>Resumen de pago</h2>
                </div>

                <div class="price-breakdown">
                    <div class="price-row">
                        <span class="price-label">Precio por hora:</span>
                        <span class="price-value">{{ number_format($reserva->espacio->precio_hora, 2, ',', '.') }} €</span>
                    </div>
                    <div class="price-row">
                        <span class="price-label">Horas reservadas:</span>
                        <span class="price-value">{{ number_format($hours, 1) }}</span>
                    </div>
                    <div class="price-row total-row">
                        <span class="price-label">Total:</span>
                        <span class="price-value">{{ number_format($reserva->importe, 2, ',', '.') }} €</span>
                    </div>
                </div>

                {{-- BOTÓN DE PAGO --}}
                <div class="payment-actions">
                    <button id="btnPagar" class="btn-pay">
                        <span class="btn-icon">

                        </span>
                        <span class="btn-text">Pagar con PayPal</span>
                    </button>

                    <div class="payment-security">
                        <div class="security-badge">

                            <span>Pago seguro</span>
                        </div>
                        <p class="payment-note">
                            Serás redirigido a PayPal para completar el pago de forma segura.
                        </p>
                    </div>
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
