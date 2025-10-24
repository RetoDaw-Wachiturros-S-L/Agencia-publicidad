document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("register");

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

    // ===== PREVIEW DE IMÁGENES =====
    const fotosInput = document.getElementById('fotos');
    
    if (fotosInput) {
        fotosInput.addEventListener('change', function(e) {
            const files = e.target.files;
            const previewContainer = document.getElementById('preview-container');
            previewContainer.innerHTML = '';
            
            if (files.length > 5) {
                alert('Máximo 5 imágenes permitidas');
                this.value = '';
                return;
            }
            
            Array.from(files).forEach((file, index) => {
                if (file.size > 5 * 1024 * 1024) {
                    alert(`La imagen ${file.name} excede 5MB`);
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'preview-item';
                    div.setAttribute('data-index', index);
                    div.innerHTML = `
                        <img src="${e.target.result}" alt="Preview ${index}">
                        <button type="button" onclick="setAsPortada(${index})">
                            Usar como portada
                        </button>
                        <span class="portada-badge" data-index="${index}" style="display: ${index === 0 ? 'block' : 'none'}">
                            Portada
                        </span>
                    `;
                    previewContainer.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        });
    }
});

// ===== FUNCIÓN GLOBAL PARA BOTONES DE PORTADA =====
function setAsPortada(index) {
    document.getElementById('foto_portada').value = index;
    
    // Actualizar indicadores visuales usando data-index
    document.querySelectorAll('.portada-badge').forEach((badge) => {
        const badgeIndex = parseInt(badge.getAttribute('data-index'));
        badge.style.display = badgeIndex === index ? 'block' : 'none';
    });
}