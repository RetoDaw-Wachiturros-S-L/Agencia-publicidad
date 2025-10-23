<?php
if (!defined('ACCESSED_VIA_ROUTER')) {
    http_response_code(403);
    die('Acceso directo no permitido');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/ads.css">
    <title>Crear Anuncio</title> 

    <!-- Editor de texto enriquecido - Summernote -->
    <!-- include libraries(jQuery, bootstrap) -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
    
    <!-- Summernote en español -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/lang/summernote-es-ES.min.js"></script>
</head>
<body>
    <main>
        <h1>Crear Nuevo Anuncio</h1>
        
        <div id="form-container">
            <form 
                action="index.php?controller=AdsController&accion=create" 
                method="post"
                id="register"
            >

                <p>
                    <label for="titulo">Título del anuncio:</label>
                    <input type="text" name="titulo" id="titulo" placeholder="Escribe el título de tu anuncio">
                    <span class="error"></span>
                </p>
                <p>
                    <label for="descripcion">Desarrolla tu anuncio:</label>
                    <textarea id="descripcion" name="descripcion" placeholder="Describe tu anuncio en detalle..."></textarea>
                    <span class="error"></span>

                </p>
                <!-- <p>
                    <label for="fotos">Fotos para el anuncio:</label>
                    <img src="#" id="imgPreview" alt="Previsualizacion" width="300">
                    <input type="file" accept="image/"></input>
                    <span class="error"></span>
                </p>
                <p>
                     Pensaba separar x comas o si no que si hay espacio ponerle una para luego añadir a un array y desde ahi hacer la insert 
                    <label for="tags">Palabras clave del anuncio:</label>
                    <input type="text" id="tags" name="tags"></input>
                    <span class="error"></span>
                </p> -->
                <p>
                    <input type="submit" name="enviar" value="Crear Anuncio">
                </p>
            </form>
        </div>
    </main>

    <!-- Inicialización de Summernote -->
    <script>
        $(document).ready(function() {
            $('#descripcion').summernote({
                placeholder: 'Describe tu anuncio en detalle...',
                lang: 'es-ES',
                height: 300,
                minHeight: 200,
                maxHeight: 500,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['table', ['table']],
                    ['insert', ['link']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                // Deshabilitamos subida de imágenes y videos
                disableDragAndDrop: true,
                callbacks: {
                    onImageUpload: function(files) {
                        // No hacer nada - bloquear subida de imágenes
                        alert('La subida de imágenes está deshabilitada en este editor.');
                    }
                }
            });
        });
    </script>
    
<script src="../../js/create.js"></script>
<script src="../../js/validaciones.js"></script>

    <?php
    echo "<pre>DEBUG - Función create():\n";
        echo "Sesión completa:\n";
        var_dump($_SESSION);
        echo "\nUsuario actual:\n";
        var_dump($currentUser);
        echo "\nDatos del anuncio:\n";
        echo "Título: " . $anuncio->getTitulo() . "\n";
        echo "Descripción: " . $anuncio->getDescripcion() . "\n";
        echo "ID del comerciante que se usará: " . ($currentUser['id'] ?? 'NO DEFINIDO') . "\n";
        echo "</pre>";
    ?>
</body>
</html>