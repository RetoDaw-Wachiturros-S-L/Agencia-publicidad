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
        }
      } catch (err) {
        console.log("Error: " + err);
      }
    });
  });
});