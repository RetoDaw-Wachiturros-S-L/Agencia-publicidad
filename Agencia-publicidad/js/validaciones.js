function validarVacio(valor) {
    return valor.trim() !== "";
}


function validarEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

function validarLongitud(valor, min, max) {
    return valor.length >= min && valor.length <= max;
}

//funcion porro
function validarContrasena(pass) {
    //Una mayúscula, una minúscula, un número y un símbolo
    const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
    return regex.test(pass);
}

function validarNif(nif) {
  const regex = /^[A-Z]\d{7}[A-Z0-9]$/;
  //aqui añadiir para mirar si la letra de control es correcta
  return regex.test(nif);
}

function mostrarError(input, mensaje) {
  const errorSpan = input.nextElementSibling;
  if (errorSpan) {
    errorSpan.textContent = mensaje;
    errorSpan.style.display = "block";
  }
  input.classList.add("input-error");
}

function limpiarError(input) {
  const errorSpan = input.nextElementSibling;
  if (errorSpan) {
    errorSpan.textContent = "";
    errorSpan.style.display = "none";
  }
  input.classList.remove("input-error");
}