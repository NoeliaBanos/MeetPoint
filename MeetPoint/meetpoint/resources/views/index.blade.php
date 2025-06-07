@extends('layouts.app')

@section('title', 'Inicio – MeetPoint')

@section('content')
    {{-- Hero Section --}}
  <div class="hero-section" style="height: 90vh; min-height: 600px; background: url('{{ asset('images/fondo.jpg') }}') center/cover no-repeat; position: relative;">
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5);"></div>
    <div class="container d-flex flex-column justify-content-center text-white" style="height: 100%; position: relative; z-index: 2; padding: 3rem 0;">
        <h1 style="font-size: 4rem; font-weight: bold; margin-bottom: 1.5rem;">MeetPoint</h1>
        <p style="font-size: 1.5rem; max-width: 800px; margin-bottom: 2rem;">
            Consulta en tiempo real la disponibilidad, capacidad, equipamiento y valoraciones de otros usuarios para
            reservar el espacio perfecto de forma rápida y eficiente.
        </p>
       <div class="hero-cta d-flex flex-wrap gap-3">
    <a href="#" class="btn-custom btn-primary-lg">
        <span class="btn-custom-text">Regístrate</span>
        <i class="bi bi-arrow-right-short btn-custom-icon"></i>
    </a>
    <a href="#" class="btn-custom btn-secondary-lg">
        <span class="btn-custom-text">Explora espacios</span>
        <i class="bi bi-search btn-custom-icon"></i>
    </a>
</div>
    </div>
</div>

    {{-- Paso a Paso --}}
    <section class="container my-5 py-5">
        <h2 class="text-center mb-5 font-title">¿Cómo funciona MeetPoint?</h2>
        <div class="row g-4 justify-content-center">
            <div class="col-12 col-md-6 col-lg-3">
                <div class="step-card p-4 h-100 text-center shadow-sm rounded-4 transition-all">
                    <div class="step-number btn-custom text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3">1</div>
                    <h3 class="h5 mb-3">Regístrate</h3>
                    <p class="mb-0 text-muted">Completa tu perfil con tus preferencias en minutos.</p>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="step-card p-4 h-100 text-center shadow-sm rounded-4 transition-all">
                    <div class="step-number btn-custom text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3">2</div>
                    <h3 class="h5 mb-3">Explora</h3>
                    <p class="mb-0 text-muted">Encuentra espacios con filtros y valoraciones.</p>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="step-card p-4 h-100 text-center shadow-sm rounded-4 transition-all">
                    <div class="step-number btn-custom text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3">3</div>
                    <h3 class="h5 mb-3">Reserva</h3>
                    <p class="mb-0 text-muted">Al instante con confirmación inmediata.</p>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="step-card p-4 h-100 text-center shadow-sm rounded-4 transition-all">
                    <div class="step-number btn-custom text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3">4</div>
                    <h3 class="h5 mb-3">Disfruta</h3>
                    <p class="mb-0 text-muted">Accede al espacio y deja tu valoración.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ Section --}}
    <section class="container my-5 py-5 bg-light rounded-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <h2 class="text-center mb-5 font-title">Preguntas frecuentes</h2>
                
                <div class="accordion custom-accordion" id="faqAccordion">
                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h3 class="accordion-header" id="heading1">
                            <button class="accordion-button bg-white fw-bold py-3" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                ¿Quién puede dar de alta una sala?
                            </button>
                        </h3>
                        <div id="faq1" class="accordion-collapse collapse show" aria-labelledby="heading1" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Solo los <strong>usuarios autenticados</strong> pueden crear nuevas salas.
                                Al publicarlas se les asigna automáticamente el rol <em>propietario</em>.
                                La sala queda <strong>pendiente de revisión</strong> por nuestro equipo
                                antes de mostrarse al público.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h3 class="accordion-header" id="heading2">
                            <button class="accordion-button bg-white fw-bold py-3 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                ¿Cuándo puedo reservar una sala?
                            </button>
                        </h3>
                        <div id="faq2" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                En cualquier momento, siempre que la sala figure como
                                <strong>disponible en el calendario</strong>. El sistema impide
                                solapamientos con otras reservas confirmadas.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h3 class="accordion-header" id="heading3">
                            <button class="accordion-button bg-white fw-bold py-3 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                ¿Puedo dejar una reseña sin haber reservado?
                            </button>
                        </h3>
                        <div id="faq3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                No. Las reseñas solo las pueden publicar los usuarios que hayan
                                completado <strong>una reserva exitosa</strong>, para garantizar
                                valoraciones basadas en experiencias reales.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h3 class="accordion-header" id="heading4">
                            <button class="accordion-button bg-white fw-bold py-3 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                ¿Tienes otra consulta?
                            </button>
                        </h3>
                        <div id="faq4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Dirígete al <a href="#contacto" class="text-custom">formulario de contacto</a> y cuéntanos tu duda.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('partials.footer')
@endsection