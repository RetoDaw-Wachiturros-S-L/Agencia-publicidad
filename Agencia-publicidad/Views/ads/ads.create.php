<?php
require_once __DIR__ . '/../../utils/auth_helper.php';

if (!isset($currentUser) || empty($currentUser)){    
    echo "Error: Usuario no autenticado";
    require_once __DIR__ . '/../errors/403.php';
    exit;
}

if ($currentUser['tipo'] !== 'COMERCIANTE' && $currentUser['tipo'] !== 'ADMINISTRADOR') {
    http_response_code(403);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title> 

    <!-- Editor de texto enriquecido
    include libraries(jQuery, bootstrap)
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    include summernote css/js
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
    -->
</head>
<body>
    <form 
        action="../../index.php?controller=AdsController&accion=create" 
        method="post"
        id="register"
    >

        <p>
            <label for="titulo">Título del anuncio:</label>
            <input type="text" name="titulo" id="titulo">
            <span class="error"></span>
        </p>
        <p>
            <label for="descripcion">Desarrolla tu anuncio:</label>
            <textarea id="descripcion" name="descripcion"></textarea>
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
            <input type="submit" name="enviar">
        </p>
    </form>

    
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