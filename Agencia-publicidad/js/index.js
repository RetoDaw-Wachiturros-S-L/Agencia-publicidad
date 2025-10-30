// Menús desplegables (usuario, anuncios y administrador)
document.addEventListener('DOMContentLoaded', () => {
    // Función genérica para manejar menús desplegables con hover
    function setupDropdownMenu(toggleId, menuId, containerClass) {
        const toggle = document.getElementById(toggleId);
        const menu = document.getElementById(menuId);
        const container = document.querySelector(`.${containerClass}`);

        if (!toggle || !menu || !container) return;

        let hideTimeout = null;

        // Mostrar menú al hacer hover sobre el toggle
        toggle.addEventListener('mouseenter', () => {
            clearTimeout(hideTimeout);
            menu.classList.add('show');
        });

        // Mantener el menú visible cuando el mouse está sobre él
        menu.addEventListener('mouseenter', () => {
            clearTimeout(hideTimeout);
            menu.classList.add('show');
        });

        // Ocultar menú cuando el mouse sale del contenedor (con pequeño delay)
        container.addEventListener('mouseleave', () => {
            hideTimeout = setTimeout(() => {
                menu.classList.remove('show');
            }, 100); // 100ms de delay para evitar cierres accidentales
        });

        // Toggle al hacer clic
        toggle.addEventListener('click', (e) => {
            e.stopPropagation();
            menu.classList.toggle('show');
        });

        // Evitar que los clics dentro del menú lo cierren
        menu.addEventListener('click', (e) => {
            e.stopPropagation();
        });

        // Cerrar el menú si se hace clic fuera
        document.addEventListener('click', (e) => {
            if (!container.contains(e.target)) {
                menu.classList.remove('show');
            }
        });
    }

    // Configurar los tres menús
    setupDropdownMenu('userMenuToggle', 'userDropdownMenu', 'user-menu-container');
    setupDropdownMenu('adsMenuToggle', 'adsDropdownMenu', 'ads-menu-container');
    setupDropdownMenu('adminMenuToggle', 'adminDropdownMenu', 'admin-menu-container');
});

document.addEventListener('DOMContentLoaded', () => {
  // Interceptar clics en el botón de editar para evitar propagación
  document.querySelectorAll('.btn-editar-anuncio').forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.stopPropagation(); 
      // evita que el clic llegue al btn de editar anuncio
      
    });
  });

  // Obtener TODOS los cards
  const cards = document.querySelectorAll('.card-anuncio');

  cards.forEach(card => {
    card.style.cursor = 'pointer';
    const idAnuncio = card.getAttribute('data-id-anuncio');
    // console.log(idAnuncio);

    card.addEventListener('click', function(e) {
      if (
        e.target.closest('.btn-favorito') ||
        e.target.closest('.btn-editar-anuncio')
      ) {
        return;
      }

      if (idAnuncio) {
        const protocol = window.location.protocol;
        const host = window.location.host;
        const pathname = window.location.pathname;
        const basePath = pathname.substring(0, pathname.lastIndexOf('/'));
        const baseUrl = `${protocol}//${host}${basePath}`;
        const url = `${baseUrl}/index.php?controller=AdsController&accion=show&id=${idAnuncio}`;

        console.log('Redirigiendo a:', url);
        window.location.href = url;
      } else {
        console.error('No se encontró ID del anuncio');
      }
    });
  });
});



// Función para manejar favoritos
document.addEventListener('DOMContentLoaded', () => {
    const botonesFavorito = document.querySelectorAll('.btn-favorito');
    
    botonesFavorito.forEach(boton => {
        boton.addEventListener('click', async function(e) {
            e.stopPropagation(); 
            // PAra que la card y el boton sean eventos distintos y no se 'contagien'
            
            const anuncioId = this.getAttribute('data-anuncio-id');
            const esFavorito = this.getAttribute('data-es-favorito') === '1';
            const isLoggedIn = this.getAttribute('data-is-logged-in') === '1';
            const icono = this.querySelector('.heart-icon');
            
            if (isLoggedIn) {
                try {
                    // Obtener la URL base
                    const protocol = window.location.protocol;
                    const host = window.location.host;
                    const pathname = window.location.pathname;
                    const basePath = pathname.substring(0, pathname.lastIndexOf('/'));
                    const baseUrl = `${protocol}//${host}${basePath}`;
                    
                    const url = `${baseUrl}/api/favoritos.php`;
                    
                    const response = await fetch(url, {
                        method: esFavorito ? 'DELETE' : 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            anuncioId: parseInt(anuncioId)
                        })
                    });
                    
                    const data = await response.json();
                    
                    if (response.ok) {
                        // Actualizar el estado visual
                        const nuevoEstado = !esFavorito;
                        this.setAttribute('data-es-favorito', nuevoEstado ? '1' : '0');
                        
                        // Cambiar la clase para actualizar el icono
                        if (nuevoEstado) {
                            this.classList.add('favorito-activo');
                        } else {
                            this.classList.remove('favorito-activo');
                        }
                        
                        // Actualizar el título
                        this.title = nuevoEstado ? 'Quitar de favoritos' : 'Agregar a favoritos';
                        
                        console.log('Favorito actualizado:', data);
                    } else {
                        console.error('Error al actualizar favorito:', data);
                        alert('Error al actualizar favorito: ' + (data.error || 'Error desconocido'));
                    }
                } catch (error) {
                    console.error('Error de red:', error);
                    alert('Error de conexión. Inténtalo de nuevo.');
                }
            }else{
                const protocol = window.location.protocol;
                const host = window.location.host;
                const pathname = window.location.pathname;
                const basePath = pathname.substring(0, pathname.lastIndexOf('/'));
                const baseUrl = `${protocol}//${host}${basePath}`;
                
                const loginUrl = `${baseUrl}/index.php?controller=AuthController&accion=iniciarSesion`;
                window.location.href = loginUrl;
            } 
        });
    });
});