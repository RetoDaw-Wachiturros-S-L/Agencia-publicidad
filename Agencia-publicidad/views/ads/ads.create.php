<?php
if (!defined('ACCESSED_VIA_ROUTER')) {
    http_response_code(403);
    die('Acceso directo no permitido');
}

require_once __DIR__ . '/../../utils/auth_helper.php';

// Extraer variables globales al scope local
$currentUser = $GLOBALS['currentUser'] ?? null;
$isLoggedIn = $GLOBALS['isLoggedIn'] ?? false;
$isAdmin = $GLOBALS['isAdmin'] ?? false;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Anuncio</title> 

    <!-- Editor de texto enriquecido - Summernote -->
    <!-- include libraries(jQuery, bootstrap) -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- CSS propios - DESPUÉS de Bootstrap para sobrescribir estilos -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/themes.css"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/layout.css"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/ads.css">
    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
    
    <!-- Summernote en español -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/lang/summernote-es-ES.min.js"></script>
</head>
<body>
    <?php include __DIR__ . '/../components/header.php'; ?>
    
    <main>
        <h1>Crear Nuevo Anuncio</h1>
        
        <div id="form-container">
            <form 
                action="index.php?controller=AdsController&accion=create" 
                method="post"
                enctype="multipart/form-data"
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
                <p>
                    <label for="fotos">Fotos para el anuncio (máximo 5):</label>
                    <input 
                        type="file" 
                        name="fotos[]" 
                        id="fotos" 
                        accept="image/jpeg,image/png,image/webp"
                        multiple
                    >
                    <span class="help-text">Formatos: JPG, PNG, WEBP. Tamaño máximo: 5MB por imagen.</span>
                    <span class="error"></span>
                </p>
                <!-- Vista previa de imágenes -->
                <div id="preview-container" class="preview-container"></div>
    
                <!-- Campo oculto para marcar cuál es la portada -->
                <input type="hidden" name="foto_portada" id="foto_portada" value="0">
                
                <!--
                <p>
                     Pensaba separar x comas o si no que si hay espacio ponerle una para luego añadir a un array y desde ahi hacer la insert 
                    <label for="tags">Palabras clave del anuncio:</label>
                    <input type="text" id="tags" name="tags"></input>
                    <span class="error"></span>
                </p>
                -->
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
    
    <!-- Scripts externos (incluyen preview de imágenes) -->
    <script src="<?= BASE_URL ?>/js/create.js"></script>
    <script src="<?= BASE_URL ?>/js/validaciones.js"></script>
    <script src="<?= BASE_URL ?>/js/theme-switcher.js" defer></script>
</body>
</html>