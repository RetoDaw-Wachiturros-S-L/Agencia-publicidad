function guardarEnCache(anuncio) {
  let arrayAnuncios = JSON.parse(localStorage.getItem("anuncios")) || [];

  // Evita duplicados por ID
  if (!arrayAnuncios.some(a => a.Id === anuncio.Id)) {
    arrayAnuncios.push(anuncio);
    localStorage.setItem("anuncios", JSON.stringify(arrayAnuncios));
  }
}

function mostrarDesdeCache() {
  const anuncios = JSON.parse(localStorage.getItem("anuncios")) || [];
  const contenedor = document.querySelector(".cards-row");
  contenedor.innerHTML = "";

  anuncios.forEach(anuncio => {
    const card = document.createElement("div");
    card.classList.add("card-anuncio");
    card.setAttribute("data-id-anuncio", anuncio.Id);

    card.innerHTML = `
      <div class="div-tj-img">
        <img src="${anuncio.UrlFoto || 'img/logo.png'}" alt="${anuncio.Title}">
        <button class="btn-favorito ${anuncio.isFav === true ? 'favorito-activo' : ''}"
                data-anuncio-id="${anuncio.Id}"
                data-es-favorito="${anuncio.isFav ? '1' : '0'}"
                title="${anuncio.isFav ? 'Quitar de favoritos' : 'Agregar a favoritos'}">
          <div class="heart-icon"></div>
        </button>
      </div>
      <h2 class="titulo-anuncio">${anuncio.Title}</h2>
      <p class="desc-anuncio">${anuncio.Descripcion}</p>
    `;

    contenedor.appendChild(card);
  });
}

document.addEventListener("DOMContentLoaded", () => {
  const cards = document.querySelectorAll(".card-anuncio");

  if (cards.length > 0) {
    cards.forEach(card => {
      const idAnuncio = card.dataset.idAnuncio || '';
      const img = card.querySelector("img");
      const urlFoto = img?.getAttribute("src") || '';
      const btnFavorito = card.querySelector(".btn-favorito");
      const isFav = btnFavorito?.dataset.esFavorito === "1"; // asegúrate que sea "1" como string
      const tituloElemnt = card.querySelector(".titulo-anuncio");
      const titulo = tituloElemnt?.textContent.trim() || '';
      const descElement = card.querySelector(".desc-anuncio");
      const descripcion = descElement?.textContent.trim() || '';

      const anuncio = {
        Id: idAnuncio,
        UrlFoto: urlFoto,
        isFav: isFav,
        Title: titulo,
        Descripcion: descripcion,
      };

      guardarEnCache(anuncio);
    });
  } else {
    mostrarDesdeCache();
  }
}); 