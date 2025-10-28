function guardarEnCache(anuncio){
    const anunciosDeCache = JSON.parse(sessionStorage.getItem("anuncios")) || {};
    anunciosDeCache[anuncio.id] = anuncio;
    sessionStorage.setItem("anuncios", JSON.stringify(anunciosDeCache));
}

function eliminarDeCache(id){
    const anunciosDeCache = JSON.parse(sessionStorage.getItem("anuncios")) || {};
    //busca sobre la sessionstorage(Que se borra cuando se cierra el navegador)
    if(anunciosDeCache.hasOwnProperty(id)){
        delete anunciosDeCache[id];
        sessionStorage.setItem("anuncios", JSON.stringify(anunciosDeCache));
    }
}

document.addEventListener("DOMContentLoaded", () => {
  const baseUrl = `${window.location.protocol}//${window.location.host}${window.location.pathname.substring(0, window.location.pathname.lastIndexOf('/'))}`;

  document.querySelectorAll(".favorito-icono").forEach(icono => {
    icono.addEventListener("click", async () => {
      const anuncioId = icono.dataset.id;
      const esFavorito = icono.dataset.esFavorito === '1';
      const isLoggedIn = icono.dataset.isLoggedIn === '1';
      
      // No se como ordenar el doc para hacer la direccion para que no haga return en duro
      if (!isLoggedIn) {
        const protocol = window.location.protocol;
        const host = window.location.host;
        const pathname = window.location.pathname;
        const basePath = pathname.substring(0, pathname.lastIndexOf('/'));
        const baseUrl = `${protocol}//${host}${basePath}`;
        
        const loginUrl = `${baseUrl}/index.php?controller=AuthController&accion=iniciarSesion`;
        window.location.href = loginUrl;
        return;
      }

      // Busca la card por CSS y obtiene el nodo para luego construir el objeto anuncio
      const card = icono.closest(".card-anuncio");
      const titulo = card.querySelector("#titulo-anuncio")?.textContent?.trim();
      const descripcion = card.querySelector("#desc-anuncio")?.textContent?.trim();
      const fecha = card.querySelector(".fecha-formateada")?.textContent?.replace("Publicado en: ", "").trim();

      const anuncio = {
        id: anuncioId,
        titulo: titulo,
        fotos: icono.src,
        descripcion: descripcion,
        fechaPublicacion: fecha
      };

      try {
        const url = `${baseUrl}/api/favoritos.php`;
        
        if (!esFavorito) {
            // console.log("Agregando a favoritos - ID anuncio: " + anuncioId);

            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ anuncioId: parseInt(anuncioId) })
            });

            const data = await response.json();
            console.log("Respuesta POST:", data);

            if (response.ok) {
                // Actualizar el toggle para dar la info al usuario
                icono.classList.add("favorito-activo");
                icono.dataset.esFavorito = '1';
                icono.title = 'Quitar de favoritos';
                guardarEnCache(anuncio);
            } else {
                // console.error('Error al agregar favorito:', data);
                alert('Error al agregar favorito: ' + (data.error || 'Error desconocido'));
            }
        } else {
            // console.log("Eliminando de favoritos - ID anuncio: " + anuncioId);

            const response = await fetch(url, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ anuncioId: parseInt(anuncioId) })
            });

            const data = await response.json();
            // console.log("Respuesta DELETE:", data);

            if (response.ok) {
                icono.classList.remove("favorito-activo");
                icono.dataset.esFavorito = '0';
                icono.title = 'Agregar a favoritos';
                eliminarDeCache(anuncioId);
            } else {
                // console.error('Error al eliminar favorito:', data);
                alert('Error al eliminar favorito: ' + (data.error || 'Error desconocido'));
            }
        }
      } catch (err) {
        console.error("Error de red:", err);
        alert('Error de conexión. Inténtalo de nuevo.');
      }
    });
  });
});