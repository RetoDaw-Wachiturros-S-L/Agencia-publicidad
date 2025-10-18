<?php
require_once __DIR__ . '/../../utils/auth_helper.php';
if (!isset($currentUser)){    
    require_once __DIR__ . '/../errors/403.php';
    exit;
}
if ($currentUser['tipo'] !== 'COMERCIANTE' && $currentUser['tipo'] !== 'ADMINISTRADOR') {
    http_response_code(403);
    //redirigir a main
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
        </p>
        <p>
            <label for="editordata">Desarrolla tu anuncio:</label>
            <textarea id="summernote" name="editordata"></textarea>
        </p>
        <p>
            <input type="submit" name="enviar">
        </p>
    </form>

    
<script src="<?= BASE_URL ?>/js/create.js"></script>
<script src="<?= BASE_URL ?>/js/validaciones.js"></script>
</body>
</html>