@extends('layouts.app')

@section('title', 'Pagar reserva')

@section('content')
<h1>Paga tu reserva</h1>
<p>Total: <strong>{{ number_format($reserva->importe,2) }} €</strong></p>

<button id="btnPagar" class="btn-custom">
    Pagar con PayPal
</button>

<script>
document.getElementById('btnPagar').addEventListener('click', async () => {
    /* 1. Marca la reserva como pagada */
    await fetch('{{ route('reservas.markPaid', $reserva) }}', {
        method : 'PUT',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept'      : 'application/json',
        },
    });

    /* 2. Abre PayPal en una pestaña nueva */
    window.open(
        'https://www.paypal.me/{{ $paypalUser }}/{{ $reserva->importe }}?currencyCode=EUR',
        '_blank'
    );

    /* 3. Vuelve a la lista de espacios */
    window.location.href = "{{ route('espacios.index') }}";
});
</script>
@endsection
