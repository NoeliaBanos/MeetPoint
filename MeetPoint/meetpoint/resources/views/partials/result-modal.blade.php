{{-- resources/views/partials/result-modal.blade.php --}}
@if(session('success') || $errors->any())
<div class="modal fade" id="resultModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          @if(session('success'))
            ¡Éxito!
          @else
            Ha ocurrido un error
          @endif
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        @if(session('success'))
          <p>{{ session('success') }}</p>
        @else
          <p>No se han guardado los datos por los siguientes motivos:</p>
          <ul class="mb-0">
            @foreach($errors->all() as $err)
              <li>{{ $err }}</li>
            @endforeach
          </ul>
        @endif
      </div>
      <div class="modal-footer">
        @if(session('success'))
          <button type="button" class="btn btn-custom" data-bs-dismiss="modal">
            Cerrar
          </button>
        @else
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            Volver y corregir
          </button>
        @endif
      </div>
    </div>
  </div>
</div>
@endif

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  @if(session('success') || $errors->any())
    const modalEl = document.getElementById('resultModal');
    const bsModal = new bootstrap.Modal(modalEl);
    bsModal.show();

    @if(session('success'))
      modalEl.addEventListener('hide.bs.modal', () => {
        window.location.href = "{{ route('profile.show') }}";
      });
    @endif
  @endif
});
</script>
@endpush
