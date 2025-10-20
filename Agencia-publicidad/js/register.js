document.addEventListener("DOMContentLoaded", () => {

    const form = document.getElementById("registro");
    const extraForm = document.getElementById('formulario_extra');
    const checkbox = document.getElementById('es_comercio');

    form.addEventListener("submit", (e) => {

        e.preventDefault();
        let valido = true;

        const nombre = document.getElementById("nombre");
        const apellido = document.getElementById("apellido")
        const email = document.getElementById("email");
        const contrasena = document.getElementById("contrasena");
        const contrasena2 = document.getElementById("contrasena2");

        [nombre, apellido, email, contrasena, contrasena2].forEach(limpiarError);

        // Validaciones

        if (!validarVacio(nombre.value)) {
            mostrarError(nombre, "El nombre es obligatorio.");
            valido = false;
        }

        if (!validarVacio(apellido.value)) {
            mostrarError(nombre, "El apellido es obligatorio.");
            valido = false;
        }

        if (!validarEmail(email.value)) {
            mostrarError(email, "El correo no tiene un formato válido.");
            valido = false;
        }

        if (!validarContrasena(contrasena.value)) {
        mostrarError(contrasena, "La contraseña debe tener mayúscula, minúscula, número y símbolo.");
        valido = false;
        }

        if (contrasena.value !== contrasena2.value) {
        mostrarError(contrasena2, "Las contraseñas no coinciden.");
        valido = false;
        }

        // Si todo es válido, enviar el formulario
        if (valido) {
        form.submit();
        }
        
    })

    // Script de Koldo (desplegar opciones en caso de ser comercio) Variables declaradas arriba

    extraForm.style.display = 'none';

    function mostrarFormNuevo() {
        console.log('checkbox.checked =', checkbox.checked);
        if (checkbox.checked) {
            extraForm.style.display = 'block';

            const nombreEmpresa = document.getElementById("nombreEmpresa");
            const nifEmpresa = document.getElementById("nifEmpresa");
            const telefonoEmpresa = document.getElementById("telefonoEmpresa");

            [nombreEmpresa, nifEmpresa, telefonoEmpresa,].forEach(limpiarError);

            if (!validarVacio(nombreEmpresa.value)) {
            mostrarError(nombreEmpresa, "El nombre de la empresa es obligatorio.");
            valido = false;
            }

            if (!validarVacio(nombreEmpresa.value)) {
            mostrarError(nombreEmpresa, "El nombre de la empresa es obligatorio.");
            valido = false;
            }

            if (!validarNif(nifEmpresa)) {
                mostrarError(nifEmpresa, "El NIF tiene que tener 8 dígitos y una letra");
                valido = false;
            }

            if (!empty(telefonoEmpresa) && !validarLongitud(telefonoEmpresa,9,9)) {
                mostrarError(telefonoEmpresa, "El numero de telefono tiene que tener 9 digitos");
            }

        } else {
            extraForm.style.display = 'none';
        }
    }

    checkbox.addEventListener('change', mostrarFormNuevo);
})