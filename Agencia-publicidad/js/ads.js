// console.log("Cargaaaa");
function guardarEnCache(anuncio) {
  let arrayAnuncios = JSON.parse(localStorage.getItem("anuncios")) || [];

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

    card.innerHTML = `
      <div class="div-tj-img">
        <img src="${anuncio.UrlFoto || 'img/logo.png'}" alt="${anuncio.Title}">
        <button class="btn-favorito ${anuncio.isFav ? 'favorito-activo' : ''}"
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
  const contenedor = document.querySelector(".cards-row");
//   console.log(contenedor);


//   console.log(localStorage.getItem("anuncios") || []);

  if (!localStorage.getItem("anuncios")) {
    const cards = document.querySelectorAll(".card-anuncio");

    cards.forEach(card => {  
        const idAnuncio = card.dataset.idAnuncio;
        // console.log("ID:", idAnuncio);

        const img = card.querySelector("img");
        // console.log("IMG:", img);
        const urlFoto = img?.getAttribute("src");
        // console.log("URL FOTO:", urlFoto);

        const btnFavorito = card.querySelector(".btn-favorito");
        // console.log("BTN FAVORITO:", btnFavorito);
        const isFav = btnFavorito?.dataset.esFavorito === "1";
        // console.log("IS FAV:", isFav);

        const tituloElemnt = card.querySelector(".titulo-anuncio");
        // console.log("TÍTULO ELEMENT:", tituloElemnt);
        const titulo = tituloElemnt?.textContent.trim();
        // console.log("TÍTULO:", titulo);

        document.querySelectorAll(".desc-anuncio").forEach(el => console.log("→", el.textContent.trim()));
        
        const descElement = card.querySelector(".desc-anuncio");
        console.log("DESCRIPCIÓN ELEMENT:", descElement);
        const descripcion = descElement?.textContent.trim();
        console.log("DESCRIPCIÓN:", descripcion);


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