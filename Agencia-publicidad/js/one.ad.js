function guardarEnCache(){
    //Si llega hasta aqui es por que toodo el flujo yha funcionado bien (asi que el obj existe)
    const anuncioCard = document.querySelectorAll("card-anuncio").forEach(card =>{
        const img = card.querySelector(".favorito-icono");
        const titulo = card.querySelector("#titulo-anuncio").textContent.trim();
        const descripcion = card.querySelector("#desc-anuncio")?.textContent?.trim();
        const fecha = card.querySelector(".fecha-formateada").textContent.replace("Publicado en: ", "").trim();

    });
    const anuncio = {
        id: img.dataset.id, //Coge el id de la imagen del anucio
        titulo: titulo,
        fotos: img.getAttribute("src"),
        descripcion: descripcion,
        fechaPublicacion: fecha
    }
    
    console.log(anuncio);

    //si no existe "favoritos" crea la instancia en cache
    let anunciosDeCache = JSON.parse(localStorage.getItem("anuncios")) || {};
    anunciosDeCache[anuncio.id] = anuncio;
    localStorage.setItem("anuncios", JSON.stringify(anunciosDeCache))
}


document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".favorito-icono").forEach(icono => {
    icono.addEventListener("click", async () => {
      const anuncioId = icono.dataset.id;

      try {
        const res = await axios.post("/api/favoritos.php", {
          anuncioId: anuncioId
        });

        if (res.status === 200) {
          icono.classList.add("favorito-activo");
          icono.src = "favorito-activo.png"; // cambia a tu icono activo
          
          guardarEnCache();
        }
      } catch (err) {
        console.log("Error: " + err);
      }
    });
  });
});