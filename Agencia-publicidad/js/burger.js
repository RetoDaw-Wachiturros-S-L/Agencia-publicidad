// Menú hamburguesa móvil - Versión simplificada y robusta
document.addEventListener('DOMContentLoaded', () => {
    console.log('🍔 Iniciando menú hamburguesa móvil...');
    
    const burgerInput = document.getElementById('burger-input');
    const mobileDropdownMenu = document.querySelector('.mobile-dropdown-menu');
    const burgerToggle = document.querySelector('.burger-menu-toggle');

    // Verificar que todos los elementos existen
    if (!burgerInput) {
        console.error('❌ No se encontró burger-input');
        return;
    }
    
    if (!mobileDropdownMenu) {
        console.error('❌ No se encontró mobile-dropdown-menu');
        return;
    }
    
    if (!burgerToggle) {
        console.error('❌ No se encontró burger-menu-toggle');
        return;
    }
    
    console.log('✅ Todos los elementos del menú hamburguesa encontrados');

    // Función para cerrar el menú
    const closeMenu = () => {
        burgerInput.checked = false;
        document.body.style.overflow = '';
        console.log('🔒 Menú cerrado');
    };

    // Función para abrir el menú
    const openMenu = () => {
        burgerInput.checked = true;
        document.body.style.overflow = 'hidden';
        console.log('🔓 Menú abierto');
    };

    // Función para alternar el menú
    const toggleMenu = () => {
        if (burgerInput.checked) {
            closeMenu();
        } else {
            openMenu();
        }
    };

    // Event listener para el botón hamburguesa
    burgerToggle.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        console.log('🖱️ Click en botón hamburguesa');
        toggleMenu();
    });

    // Event listener para el checkbox (por si acaso)
    burgerInput.addEventListener('change', () => {
        console.log('☑️ Checkbox cambiado:', burgerInput.checked);
        if (burgerInput.checked) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = '';
        }
    });

    // Cerrar menú al hacer clic fuera
    document.addEventListener('click', (e) => {
        // Solo cerrar si el menú está abierto
        if (burgerInput.checked) {
            // Verificar si el clic fue fuera del menú y del botón
            if (!mobileDropdownMenu.contains(e.target) && !burgerToggle.contains(e.target)) {
                console.log('🖱️ Click fuera del menú - cerrando');
                closeMenu();
            }
        }
    });

    // Cerrar menú al hacer clic en un item del menú
    const menuItems = mobileDropdownMenu.querySelectorAll('.mobile-menu-item');
    menuItems.forEach((item, index) => {
        item.addEventListener('click', () => {
            console.log(`🖱️ Click en item del menú ${index + 1}`);
            // Pequeño delay para que se vea la animación antes de navegar
            setTimeout(() => {
                closeMenu();
            }, 200);
        });
    });

    // Cerrar menú al presionar Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && burgerInput.checked) {
            console.log('⌨️ Tecla Escape presionada - cerrando menú');
            closeMenu();
        }
    });

    // Asegurar que el scroll se restaure al cerrar el menú
    window.addEventListener('beforeunload', () => {
        document.body.style.overflow = '';
    });

    // Debug: mostrar estado del menú
    console.log('🍔 Menú hamburguesa inicializado correctamente');
    console.log('📱 Estado inicial del menú:', burgerInput.checked ? 'Abierto' : 'Cerrado');
});

// Menú desplegable de usuario (escritorio) - Solo para pantallas grandes
document.addEventListener('DOMContentLoaded', () => {
    // Solo aplicar en pantallas grandes
    if (window.innerWidth < 750) {
        return; // No aplicar funcionalidad de escritorio en móvil
    }
    
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

// Menú desplegable de anuncios (escritorio) - Solo para pantallas grandes
document.addEventListener('DOMContentLoaded', () => {
    // Solo aplicar en pantallas grandes
    if (window.innerWidth < 750) {
        return; // No aplicar funcionalidad de escritorio en móvil
    }
    
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
        card.addEventListener('click', function(e) {
            // Evitar que el clic en el botón de favorito redirija
            if (e.target.closest('.btn-favorito')) {
                return;
            }
            
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

// Función para manejar favoritos
document.addEventListener('DOMContentLoaded', () => {
    const botonesFavorito = document.querySelectorAll('.btn-favorito');
    
    botonesFavorito.forEach(boton => {
        boton.addEventListener('click', async function(e) {
            e.stopPropagation(); // Evitar que se active el clic del card
            
            const anuncioId = this.getAttribute('data-anuncio-id');
            const esFavorito = this.getAttribute('data-es-favorito') === '1';
            const isLoggedIn = this.getAttribute('data-is-logged-in') === '1';
            const icono = this.querySelector('.heart-icon');
            
            // Si el usuario no está logueado, redirigir a login
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
                    
                    // Cambiar la imagen
                    const nuevaImagen = nuevoEstado ? 'favorito-activo.png' : 'Heart.png';
                    icono.src = `${baseUrl}/img/${nuevaImagen}`;
                    
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
        });
    });
});