@extends('layouts.app')

@section('title', 'MeetPoint')

@section('content')
    {{-- NAVBAR --}}
 <div class="hero-size">
     <img src="{{ asset('images/fondo.jpg') }}" alt="Imagen de un ordenador de mesa vista desde arriba">
 </div>
 <h2>Espacios en Utrera</h2>
<section class="container espacios‐grid">
  @foreach($espacios as $espacio)
    <div class="espacios pt-4">
      <img src="{{ asset('images/fondo.jpg') }}" alt="…">
      <h3 class="pt-2 m-2">
        <a href="{{ route('espacios.show', $espacio->id) }}">
          {{ $espacio->nombre }}
        </a>
      </h3>
      <hr>
      <p>Precio: <b>{{ $espacio->precio_hora }} €</b></p>
      <p>Equipamiento: <b>{{ $espacio->equipamiento }}</b></p>
      <p>Reseñas: <b>2,4</b></p>
      <a href="{{ route('espacios.show', $espacio->id) }}"
         class="btn-custom d-flex justify-content-center">
        <b>+ INFO</b>
      </a>
    </div>
  @endforeach
</section>
   

    {{-- FOOTER --}}
    @include('partials.footer')

@endsection
