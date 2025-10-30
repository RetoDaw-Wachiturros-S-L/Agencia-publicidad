// Script adicional para el panel admin - manejo de checkboxes de tipo de usuario

document.addEventListener("DOMContentLoaded", () => {
    const checkboxes = document.querySelectorAll('.tipo-checkbox');
    const formularioExtra = document.getElementById('formulario_extra');
    const nombreEmpresa = document.getElementById("nombreEmpresa");
    const nifEmpresa = document.getElementById("nifEmpresa");
    const telefonoEmpresa = document.getElementById("telefonoEmpresa");
    
    // Hacer que solo se pueda seleccionar un checkbox a la vez
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                // Desmarcar todos los demás
                checkboxes.forEach(cb => {
                    if (cb !== this) {
                        cb.checked = false;
                    }
                });
                
                // Si NO es comerciante, ocultar formulario extra
                if (this.value !== 'COMERCIANTE') {
                    if (formularioExtra) {
                        formularioExtra.classList.remove('visible');
                        // Quitar required
                        if (nombreEmpresa) nombreEmpresa.removeAttribute('required');
                        if (nifEmpresa) nifEmpresa.removeAttribute('required');
                        if (telefonoEmpresa) telefonoEmpresa.removeAttribute('required');
                    }
                }
            } else {
                // Si se desmarca, marcar Visitante por defecto
                document.getElementById('tipo_visitante').checked = true;
                
                // Ocultar formulario extra
                if (formularioExtra) {
                    formularioExtra.classList.remove('visible');
                    // Quitar required
                    if (nombreEmpresa) nombreEmpresa.removeAttribute('required');
                    if (nifEmpresa) nifEmpresa.removeAttribute('required');
                    if (telefonoEmpresa) telefonoEmpresa.removeAttribute('required');
                }
            }
        });
    });
});
