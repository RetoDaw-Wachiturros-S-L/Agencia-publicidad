// Menú desplegable de usuario
document.addEventListener('DOMContentLoaded', () => {
    const userMenuToggle = document.getElementById('userMenuToggle');
    const userDropdownMenu = document.getElementById('userDropdownMenu');

    if (userMenuToggle && userDropdownMenu) {
        // Toggle del menú al hacer clic
        userMenuToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            userDropdownMenu.classList.toggle('show');
        });

        // Mostrar menú al pasar el ratón (hover)
        userMenuToggle.addEventListener('mouseenter', () => {
            userDropdownMenu.classList.add('show');
        });

        // Mantener el menú abierto cuando el ratón está sobre él
        userDropdownMenu.addEventListener('mouseenter', () => {
            userDropdownMenu.classList.add('show');
        });

        // Cerrar el menú cuando el ratón sale del contenedor
        const userMenuContainer = document.querySelector('.user-menu-container');
        if (userMenuContainer) {
            userMenuContainer.addEventListener('mouseleave', () => {
                userDropdownMenu.classList.remove('show');
            });
        }

        // Cerrar el menú si se hace clic fuera
        document.addEventListener('click', (e) => {
            if (!userMenuContainer.contains(e.target)) {
                userDropdownMenu.classList.remove('show');
            }
        });

        // Evitar que los clics dentro del menú lo cierren
        userDropdownMenu.addEventListener('click', (e) => {
            e.stopPropagation();
        });
    }
});

// Menú desplegable de anuncios (idéntico al de usuario)
document.addEventListener('DOMContentLoaded', () => {
    const adsMenuToggle = document.getElementById('adsMenuToggle');
    const adsDropdownMenu = document.getElementById('adsDropdownMenu');

    if (adsMenuToggle && adsDropdownMenu) {
        // Toggle del menú al hacer clic
        adsMenuToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            adsDropdownMenu.classList.toggle('show');
        });

        // Mostrar menú al pasar el ratón (hover)
        adsMenuToggle.addEventListener('mouseenter', () => {
            adsDropdownMenu.classList.add('show');
        });

        // Mantener el menú abierto cuando el ratón está sobre él
        adsDropdownMenu.addEventListener('mouseenter', () => {
            adsDropdownMenu.classList.add('show');
        });

        // Cerrar el menú cuando el ratón sale del contenedor
        const adsMenuContainer = document.querySelector('.ads-menu-container');
        if (adsMenuContainer) {
            adsMenuContainer.addEventListener('mouseleave', () => {
                adsDropdownMenu.classList.remove('show');
            });
        }

        // Cerrar el menú si se hace clic fuera
        document.addEventListener('click', (e) => {
            if (!adsMenuContainer.contains(e.target)) {
                adsDropdownMenu.classList.remove('show');
            }
        });

        // Evitar que los clics dentro del menú lo cierren
        adsDropdownMenu.addEventListener('click', (e) => {
            e.stopPropagation();
        });
    }
});

// Función para acceder a la vista única del anuncio
document.addEventListener('DOMContentLoaded', () => {
    // Obtener TODOS los cards
    const cards = document.querySelectorAll('.card-anuncio');
    
    console.log('Cards encontrados:', cards.length); // DEBUG
    
    // Añadir listener a CADA card individualmente
    cards.forEach(card => {
        // Añadir cursor pointer
        card.style.cursor = 'pointer';
        
        // Obtener el ID desde el atributo data
        const idAnuncio = card.getAttribute('data-id-anuncio');
        
        // Añadir event listener
        card.addEventListener('click', function() {
            
            if (idAnuncio) {
                // Obtener la URL base de forma más confiable
                // Extraer el base URL desde la ubicación actual
                const protocol = window.location.protocol; // http: o https:
                const host = window.location.host; // localhost o dominio
                const pathname = window.location.pathname; // /Wachiturros/Agencia-publicidad/Agencia-publicidad/index.php
                
                // Extraer el directorio base (todo antes de index.php)
                const basePath = pathname.substring(0, pathname.lastIndexOf('/'));
                const baseUrl = `${protocol}//${host}${basePath}`;
                
                // Construir la URL
                const url = `${baseUrl}/index.php?controller=AdsController&accion=show&id=${idAnuncio}`;
                
                console.log('Redirigiendo a:', url); // DEBUG
                
                // Redirigir
                window.location.href = url;
            } else {
                console.error('No se encontró ID del anuncio');
            }
        });
    });
});