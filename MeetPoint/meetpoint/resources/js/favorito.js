
document.addEventListener('DOMContentLoaded', () => {
  const btn = document.getElementById('btn-fav');
  if (!btn) return;

  btn.addEventListener('click', async (e) => {
    e.preventDefault();

    const icon = document.getElementById('icono-fav');
    const isFav = icon.getAttribute('src').includes('filled');
    const url   = isFav ? btn.dataset.unfavUrl : btn.dataset.favUrl;
    const method= isFav ? 'DELETE' : 'POST';

    try {
      const res = await fetch(url, {
        method: method,
        headers: {
          'X-CSRF-TOKEN': window.Laravel.csrfToken,
          'Accept': 'application/json',
        },
      });
      const json = await res.json();
      if (json.status === 'favorited') {
        icon.src = '{{ asset("images/heart-filled.png") }}';
      } else {
        icon.src = '{{ asset("images/heart-outline.png") }}';
      }
      // opcional: mostrar contador json.count
    } catch (err) {
      console.error(err);
      alert('Error al actualizar favorito');
    }
  });
});