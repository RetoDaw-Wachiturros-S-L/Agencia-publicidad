document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("register");
    //Aqui va la inicializacion para las imagenes

    form.addEventListener("submit", (e) => {

    // document.addEventListener("change", mostrarImg(Event));

        e.preventDefault();
        
        let valido = true;

        const titulo = document.getElementById("titulo");
        
        const descripcion = document.getElementById("descripcion");
        // const tags = document.getElementById("tags"); //esto deberia de ser un array tb de string
        
        // function mostrarImg(Event){
        //     const imgPreview = document.getElementById("imgPreview"); //Obtiene la etiqueta de la File
        //     const files = Event.target.files;
        //     console.log(typeof imgPreview , typeof files);        
        // }
        //         console.log(tags);

        
        [titulo, descripcion].forEach(limpiarError);

        if(!validarVacio(titulo.value)){
            mostrarError(titulo, "El título del anuncio es obligatorio.");
            valido = false;
        }

        //se utiliza 150 que es el max para la Bd del titulo del anuncio 
        if(!validarLongitud(titulo.value, 3, 150)){
            mostrarError(titulo, "El titulo tiene que estar entre los 3 y 150 caracteres");
            valido = false;
        }

        if(valido) {
            form.submit();
        }
    });
});