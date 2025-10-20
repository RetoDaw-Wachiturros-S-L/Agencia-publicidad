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
