document.addEventListener("DOMContentLoaded", () => {

    const form = document.getElementById("login");

    form.addEventListener("submit", (e) => {

        e.preventDefault();
        let valido = true;

        const email = document.getElementById("email");
        const contrasena = document.getElementById("contrasena");

        [email, contrasena].forEach(limpiarError);

        // Validaciones

        if (!validarVacio(email.value)) {
            mostrarError(nombre, "El email es obligatorio.");
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

        // Si todo es válido, enviar el formulario
        if (valido) {
        form.submit();
        }
        
    })

})