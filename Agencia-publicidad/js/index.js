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
