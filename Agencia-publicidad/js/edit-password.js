document.addEventListener("DOMContentLoaded", () => {

    const form = document.getElementById("login");

    form.addEventListener("submit", (e) => {

        e.preventDefault();
        let valido = true;

        const contrasena = document.getElementById("contrasena");
        const contrasena2 = document.getElementById("contrasena2");
        const contrasena3 = document.getElementById("contrasena3");




        [email, contrasena].forEach(limpiarError);

        // Validaciones


        if (!validarContrasena(contrasena.value)) {
        mostrarError(contrasena, "La contraseña debe tener mayúscula, minúscula, número y símbolo.");
        valido = false;
        }
        if (!validarContrasena(contrasena2.value)) {
        mostrarError(contrasena2, "La contraseña debe tener mayúscula, minúscula, número y símbolo.");
        valido = false;
        }
        if (!validarContrasena(contrasena3.value)) {
        mostrarError(contrasena3, "La contraseña debe tener mayúscula, minúscula, número y símbolo.");
        valido = false;
        }
        if(!validarRepetir(contrasena2,contrasena3)){

            mostrarError(contrasena3, "Las contraseñas no son iguales");
            valido = false;
        }

        // Si todo es válido, enviar el formulario
        if (valido) {
        form.submit();
        }
        
    })

})