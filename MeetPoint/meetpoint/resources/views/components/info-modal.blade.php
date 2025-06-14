@props([
    'id'         => 'infoModal',
    'title'      => 'Información',
    'message'    => '',
    'closeLabel' => 'Cerrar',
])

<div {{ $attributes->merge(['class' => 'modal fade']) }}
     id="{{ $id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            {{-- Cabecera --}}
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
                <button type="button" class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Cerrar"></button>
            </div>

            {{-- Cuerpo --}}
            <div class="modal-body">
                {{-- Si quieres permitir HTML en message usa {!! $message !!} --}}
                {{ $message }}
            </div>

            {{-- Pie --}}
            <div class="modal-footer">
                <button type="button" class="btn-custom-sec"
                        data-bs-dismiss="modal">
                    {{ $closeLabel }}
                </button>
            </div>
        </div>
    </div>
</div>

<x-info-modal title="¡Hecho!" message="Los cambios se guardaron correctamente"/>
