document.addEventListener('DOMContentLoaded', () => {
  const form = document.querySelector('#form-reserva');
  if (!form) return;

  form.addEventListener('submit', async e => {
    e.preventDefault();
    const data = new FormData(form);

    try {
      const res = await fetch(form.action, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': window.Laravel.csrfToken },
        body: data,
      });
      const json = await res.json();
      if (json.status === 'ok') {
        // muestra mensaje de éxito
        alert('Reserva realizada con éxito');
        form.reset();
      } else if (json.errors) {
        // recorre errores y los muestras junto a cada campo
        console.error(json.errors);
      }
    } catch (err) {
      console.error(err);
      alert('Ocurrió un error al procesar la reserva.');
    }
  });
});
