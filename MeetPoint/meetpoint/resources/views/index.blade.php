@extends('layouts.app')

@section('title', 'Inicio – MeetPoint')

@section('content')
    {{-- Hero --}}
    <div class="hero-size">
        <img src="{{ asset('images/fondo.jpg') }}" alt="Fondo hero">
        <div class="hero-text">
            <h1 class="display">MeetPoint</h1>
            <p>
                Consulta en tiempo real la disponibilidad, capacidad, equipamiento y valoraciones de otros usuarios para
                reservar el espacio perfecto de forma rápida y eficiente.
            </p>
        </div>
    </div>

    {{-- Paso a paso --}}
    <section class="container my-5">
        <h2 class="text-center mb-4">¿Cómo funciona MeetPoint?</h2>
        <div class="row g-4 justify-content-center text-center">
            <div class="col-12 col-md-3">
                <div class="border rounded-3 p-4 h-100">
                    <span class="display-4 fw-bold d-block mb-2">1</span>
                    <p class="mb-0">Regístrate gratis y completa tu perfil con tus preferencias.</p>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="border rounded-3 p-4 h-100">
                    <span class="display-4 fw-bold d-block mb-2">2</span>
                    <p class="mb-0">Explora los espacios disponibles usando filtros y valoraciones.</p>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="border rounded-3 p-4 h-100">
                    <span class="display-4 fw-bold d-block mb-2">3</span>
                    <p class="mb-0">Reserva al instante y recibe confirmación al momento.</p>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="border rounded-3 p-4 h-100">
                    <span class="display-4 fw-bold d-block mb-2">4</span>
                    <p class="mb-0">Accede al espacio, disfruta y deja tu valoración.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ + Contacto --}}
<section class="container my-5">
    <h2 class="text-center mb-4">Preguntas frecuentes</h2>

    <div class="accordion" id="faqAccordion">

        {{-- 1 --}}
        <div class="accordion-item">
            <p class="accordion-header" id="heading1">
                <button class="accordion-button" type="button"
                        data-bs-toggle="collapse" data-bs-target="#faq1"
                        aria-expanded="true" aria-controls="faq1">
                    ¿Quién puede dar de alta una sala?
                </button>
            </p>
            <div id="faq1" class="accordion-collapse collapse show"
                 aria-labelledby="heading1" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Solo los <strong>usuarios autenticados</strong> pueden crear nuevas salas.
                    Al publicarlas se les asigna automáticamente el rol <em>propietario</em>.
                    La sala queda <strong>pendiente de revisión</strong> por nuestro equipo
                    antes de mostrarse al público.
                </div>
            </div>
        </div>

        {{-- 2 --}}
        <div class="accordion-item">
            <p class="accordion-header" id="heading2">
                <button class="accordion-button collapsed" type="button"
                        data-bs-toggle="collapse" data-bs-target="#faq2"
                        aria-expanded="false" aria-controls="faq2">
                    ¿Cuándo puedo reservar una sala?
                </button>
            </p>
            <div id="faq2" class="accordion-collapse collapse"
                 aria-labelledby="heading2" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    En cualquier momento, siempre que la sala figure como
                    <strong>disponible en el calendario</strong>. El sistema impide
                    solapamientos con otras reservas confirmadas.
                </div>
            </div>
        </div>

        {{-- 3 --}}
        <div class="accordion-item">
            <p class="accordion-header" id="heading3">
                <button class="accordion-button collapsed" type="button"
                        data-bs-toggle="collapse" data-bs-target="#faq3"
                        aria-expanded="false" aria-controls="faq3">
                    ¿Puedo dejar una reseña sin haber reservado?
                </button>
            </p>
            <div id="faq3" class="accordion-collapse collapse"
                 aria-labelledby="heading3" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    No. Las reseñas solo las pueden publicar los usuarios que hayan
                    completado <strong>una reserva exitosa</strong>, para garantizar
                    valoraciones basadas en experiencias reales.
                </div>
            </div>
        </div>

        {{-- 4 --}}
        <div class="accordion-item">
            <p class="accordion-header" id="heading4">
                <button class="accordion-button collapsed" type="button"
                        data-bs-toggle="collapse" data-bs-target="#faq4"
                        aria-expanded="false" aria-controls="faq4">
                    ¿Tienes otra consulta?
                </button>
            </p>
            <div id="faq4" class="accordion-collapse collapse"
                 aria-labelledby="heading4" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Dirígete al <a href="#contacto">formulario de contacto</a> y cuéntanos tu duda.
                </div>
            </div>
        </div>

    </div>
</section>
    @include('partials.footer')
@endsection
