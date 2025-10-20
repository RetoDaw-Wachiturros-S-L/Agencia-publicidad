document.addEventListener("DOMContentLoaded", () => {

    const form = document.getElementById("registro");
    const extraForm = document.getElementById('formulario_extra');
    const checkbox = document.getElementById('es_comercio');

    form.addEventListener("submit", (e) => {

        e.preventDefault();
        let valido = true;

        const nombre = document.getElementById("nombre");
        const apellido = document.getElementById("apellido");
        const email = document.getElementById("email");
        const contrasena = document.getElementById("contrasena");
        const contrasena2 = document.getElementById("contrasena2");

        [nombre, apellido, email, contrasena, contrasena2].forEach(limpiarError);

        // Validaciones nombre
        if (!nombre || !validarVacio(nombre.value)) {
            mostrarError(nombre, "El nombre es obligatorio.");
            valido = false;
        } else if (!validarLongitud(nombre.value.trim(), 2, 100)) {
            mostrarError(nombre, "El nombre tiene que tener entre 2 y 100 carácteres");
            valido = false;
        }

        // Validar apellido (solo si se ha escrito algo)
        if (apellido && apellido.value.trim() !== "" && !validarLongitud(apellido.value.trim(), 2, 100)) {
            mostrarError(apellido, "El apellido tiene que tener entre 2 y 100 carácteres");
            valido = false;
        }

        // Validaciones email
        if (!email || !validarEmail(email.value.trim())) {
            mostrarError(email, "El correo no tiene un formato válido.");
            valido = false;
        }

        // Contraseña
        if (!contrasena || !validarContrasena(contrasena.value)) {
            mostrarError(contrasena, "La contraseña debe tener mayúscula, minúscula, número y símbolo.");
            valido = false;
        }

        if (!contrasena2 || contrasena.value !== contrasena2.value) {
            mostrarError(contrasena2, "Las contraseñas no coinciden.");
            valido = false;
        }

        // Si todo es válido, enviar el formulario
        if (valido) {
            form.submit();
        }

    });

    // Script de Koldo (desplegar opciones en caso de ser comercio) Variables declaradas arriba
    extraForm.classList.remove('visible');

    function mostrarFormNuevo() {
        if (!checkbox) return;
        if (checkbox.checked) {
            extraForm.classList.add('visible');

            const nombreEmpresa = document.getElementById("nombreEmpresa");
            const nifEmpresa = document.getElementById("nifEmpresa");
            const telefonoEmpresa = document.getElementById("telefonoEmpresa");

            [nombreEmpresa, nifEmpresa, telefonoEmpresa].forEach(el => {
                if (el) limpiarError(el);
            });

            // No hagas validaciones completas aquí (se realizan en submit).
            // Pero puedes marcar campos como required para accesibilidad:
            if (nombreEmpresa) nombreEmpresa.setAttribute('required', 'required');
            if (nifEmpresa) nifEmpresa.setAttribute('required', 'required');
            if (telefonoEmpresa) telefonoEmpresa.removeAttribute('required'); // opcional
        } else {
            extraForm.classList.remove('visible');

            // quitar required al ocultar
            const nombreEmpresa = document.getElementById("nombreEmpresa");
            const nifEmpresa = document.getElementById("nifEmpresa");
            const telefonoEmpresa = document.getElementById("telefonoEmpresa");
            if (nombreEmpresa) nombreEmpresa.removeAttribute('required');
            if (nifEmpresa) nifEmpresa.removeAttribute('required');
            if (telefonoEmpresa) telefonoEmpresa.removeAttribute('required');
        }
    }

    // Mejor hacer validaciones de empresa en submit: ejemplo rápido de chequeo al cambiar
    checkbox.addEventListener('change', mostrarFormNuevo);

});