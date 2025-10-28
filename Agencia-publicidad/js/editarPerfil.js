
document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("editar");
    form.addEventListener("submit", (e) => {

        e.preventDefault();
        let valido = true;

        const nombre = document.getElementById("nombre");
        const apellido = document.getElementById("apellido");
        const contrasena = document.getElementById("contrasena");
        const foto = document.getElementById("foto_perfil");

        const nombreEmpresa = document.getElementById("nombre_empresa");
        const comentarioEmpresa = document.getElementById("comentario_empresa");
        const telefonoEmpresa = document.getElementById("telefono_empresa");
        const nifEmpresa = document.getElementById("nif_empresa");

        limpiarTodosLosErrores();

        if (nombre.value.trim() !== "" && !validarLongitud(nombre.value.trim(), 2, 100)) {
            mostrarError(nombre, "El nombre debe tener entre 2 y 100 caracteres.");
            valido = false;
        }

        if (apellido.value.trim() !== "" && !validarLongitud(apellido.value.trim(), 2, 100)) {
            mostrarError(apellido, "El apellido debe tener entre 2 y 100 caracteres.");
            valido = false;
        }

        if (contrasena.value.trim() !== "" && !validarContrasena(contrasena.value)) {
            mostrarError(contrasena, "La contraseña debe incluir mayúscula, minúscula, número y símbolo.");
            valido = false;
        }   

        if (foto.files.length > 0) {
            const file = foto.files[0];
            const validTypes = ["image/jpeg", "image/png", "image/jpg"];

            if (!validTypes.includes(file.type)) {
                mostrarError(foto, "La imagen debe ser JPG o PNG.");
                valido = false;
            }

            if (file.size > 2 * 1024 * 1024) {
                mostrarError(foto, "La imagen no puede superar los 2MB.");
                valido = false;
            }
        }

        if (nombreEmpresa) {

            if (nombreEmpresa.value.trim() !== "" &&
                !validarLongitud(nombreEmpresa.value.trim(), 2, 150)) {
                mostrarError(nombreEmpresa, "El nombre de la empresa debe tener entre 2 y 150 caracteres.");
                valido = false;
            }

            if (telefonoEmpresa.value.trim() !== "" &&
                !/^[0-9]{9}$/.test(telefonoEmpresa.value.trim())) {
                mostrarError(telefonoEmpresa, "El teléfono debe contener 9 números.");
                valido = false;
            }

            if (nifEmpresa.value.trim() !== "" &&
                !/^[A-Za-z0-9]{8,12}$/.test(nifEmpresa.value.trim())) {
                mostrarError(nifEmpresa, "NIF con formato incorrecto.");
                valido = false;
            }
        }

        if (valido) form.submit();
    });


    function mostrarError(input, mensaje) {
        const error = document.createElement("span");
        error.classList.add("error-text");
        error.textContent = mensaje;
        input.classList.add("input-error");
        input.insertAdjacentElement("afterend", error);
    }

    function limpiarTodosLosErrores() {
        document.querySelectorAll(".error-text").forEach(e => e.remove());
        document.querySelectorAll(".input-error").forEach(e => e.classList.remove("input-error"));
    }

    function validarLongitud(text, min, max) {
        return text.length >= min && text.length <= max;
    }

    function validarContrasena(pass) {
        return /[A-Z]/.test(pass) &&
               /[a-z]/.test(pass) &&
               /[0-9]/.test(pass) &&
               /[^A-Za-z0-9]/.test(pass);
    }

});
