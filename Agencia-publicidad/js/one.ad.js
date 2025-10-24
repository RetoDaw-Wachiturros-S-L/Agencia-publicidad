function guardarEnCache(anuncio){
    const anunciosDeCache = JSON.parse(localStorage.getItem("anuncios")) || {};
    anunciosDeCache[anuncio.id] = anuncio;
    localStorage.setItem("anuncios", JSON.stringify(anunciosDeCache));
}
function borrarDeCache(id){
    const anunciosDeCache = JSON.parse(localStorage.getItem("anuncios")) || {};
    
    if(anunciosDeCache.hasOwnProperty(id)){
        delete anunciosDeCache[id];
        localStorage.setItem("anuncios", JSON.stringify(anunciosDeCache));
    }
    
}


document.addEventListener("DOMContentLoaded", () => {
  const baseUrl = `${window.location.protocol}//${window.location.host}${window.location.pathname.substring(0, window.location.pathname.lastIndexOf('/'))}`;

  document.querySelectorAll(".favorito-icono").forEach(icono => {
    icono.addEventListener("click", async () => {
    //Al hacer click sobre el icono fav coge el id del anuncio(que esta en el icono por php) y mira si tiene en el css la class (favorito-activo=>bool)  
    const anuncioId = icono.dataset.id;
    const esFavorito = icono.classList.contains("favorito-activo");

    //busca la card por css y obtiene el nodo para luego construir el Obj anuncio
    const card = icono.closest(".card-anuncio");
    const titulo = card.querySelector("#titulo-anuncio")?.textContent?.trim();
    const descripcion = card.querySelector("#desc-anuncio")?.textContent?.trim();
    const fecha = card.querySelector(".fecha-formateada")?.textContent?.replace("Publicado en: ", "").trim();
    const fotos = icono.getAttribute("src");

    const anuncio = {
    id: anuncioId,
    titulo: titulo,
    fotos: fotos,
    descripcion: descripcion,
    fechaPublicacion: fecha
    };

    try {
        //Mira si tiene la clase de favorito y si es true hace la await POST para meterla en favoritos y la guarda en caché
    if (!esFavorito) {
        const res = await axios.post(baseUrl + "/api/favoritos.php", { anuncioId });
        if (res.status === 200) {
        icono.classList.add("favorito-activo");
        icono.src = baseUrl + "/img/favorito-activo.png";
        guardarEnCache(anuncio);
        }
        //En otro caso hace await DELETE y la quita de caché(en caso de que esté)
    } else {
        const res = await axios.delete(baseUrl + "/api/favoritos.php", { data: { anuncioId } });
        if (res.status === 200) {
        icono.classList.remove("favorito-activo");
        icono.src = baseUrl + "/img/Heart.png";
        eliminarDeCache(anuncioId);
        }
    }
    } catch (err) {
    console.log("Error: " + err);
    }
    });
  });
});