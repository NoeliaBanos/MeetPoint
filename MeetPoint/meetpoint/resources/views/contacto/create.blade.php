@extends('layouts.app')

@section('title', 'Contacto')

@section('content')
    @auth
        @if(auth()->user()->role === 'admin')
            <div class="contact-container">
                <div class="messages-container">
                    <div class="messages-header">
                        <h1>Mensajes de Contacto</h1>
                        <p>Gestión de mensajes recibidos</p>
                    </div>

                    @forelse($mensajes as $mensaje)
                        <div class="message-card">
                            <div class="message-header">
                                <div class="sender-info">
                                    <h2>{{ $mensaje->nombre }}</h2>
                                    <span class="message-date">{{ $mensaje->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <form action="{{ route('contacto.destroy', $mensaje->id) }}" method="POST" class="delete-form">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="delete-btn" onclick="return confirm('¿Eliminar este mensaje?');">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            </div>

                            <div class="message-content">
                                <div class="contact-detail">
                                    <span class="detail-label">Asunto:</span>
                                    <span class="detail-value">{{ $mensaje->asunto }}</span>
                                </div>
                                
                                <div class="contact-detail">
                                    <span class="detail-label">Email:</span>
                                    <span class="detail-value">{{ $mensaje->email }}</span>
                                </div>
                                
                                <div class="contact-detail">
                                    <span class="detail-label">Teléfono:</span>
                                    <span class="detail-value">{{ $mensaje->telefono ?? 'No proporcionado' }}</span>
                                </div>
                                
                                <div class="message-text">
                                    <p>{{ $mensaje->mensaje }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="bi bi-inbox"></i>
                            <h3>No hay mensajes</h3>
                            <p>No se han encontrado mensajes de contacto pendientes.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        @else
            @include('contacto._publico')
        @endif
    @else
        @include('contacto._publico')
    @endauth
@endsection