// JS para la vista modifyUser.php del panel admin
// Puedes agregar aquí scripts para funcionalidades específicas de la gestión de usuarios

// Ejemplo: Confirmación personalizada para eliminar usuario

document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.btn-delete');
    deleteButtons.forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            if (!confirm('¿Estás seguro de que quieres eliminar este usuario?')) {
                e.preventDefault();
            }
        });
    });
});
