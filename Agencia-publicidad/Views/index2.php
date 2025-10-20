<?php
    //Comprobar session
    require_once __DIR__ . '/../utils/auth_helper.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina principal</title>
    <link rel="stylesheet" href="../css/layout.css"/>
</head>
<body>

<header>
    <img src="../img/logo_SSombra.png" alt="Logo de comerciantes vitoria" class="logo">
    <div id="buscar">
        <input type="text" class="search"> 
    </div>
    <a href="../index.php?controller=OutController&accion=iniciarSesion">
        <img src="../img/login.png" alt="Boton de login" id="btnLogin">
    </a>
    <img src="../img/lampara.png" alt="Boton de cambio de tema" class="lampara">
</header>
<main>



</main>

<div class="card-anuncio">
    <div class="div-tj-img">
        <img src="" alt="">
        <!-- Imagen que tendrá src autogenerado y alt igual -->
    </div>
    <h2 id="titulo-anuncio" ><?php $anuncio['titulo'] ?? 'titulo anuncio generico' ?></h2>
</div>

<script src="../js/index.js"></script>
</body>
</html>