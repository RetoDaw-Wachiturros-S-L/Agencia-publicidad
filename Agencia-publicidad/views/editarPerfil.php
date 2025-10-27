<?php 
use AgenciaPublicidad\Models\TipoPersonaEnum;
    require_once __DIR__ . '/../utils/auth_helper.php';
    require_once __DIR__ . '/../models/TipoPersonaEnum.php';
 // Extraer variables globales al scope local
    $currentUser = $GLOBALS['currentUser'] ?? null;
    $isLoggedIn = $GLOBALS['isLoggedIn'] ?? false;
    $isAdmin = $GLOBALS['isAdmin'] ?? false;     


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/editarPerfil.css"/>

</head>
<body>

    <main>
        <?php if(empty($_SESSION["usuario"]["foto_perfil"])):?>
            <h2><img src="../img/fotoperfil.png" alt="fotoperfil"> Editar usuario</h2>
        <?php  else:?>
            <h2><img src="" alt="fotoperfil"> Editar usuario</h2>
        <?php endif?>

        <h1>Campos a cambiar</h1>
        <div class="botones">
            <a href="">Nombre</a>
            <a href="">Apellido</a>
            <a href="">Contraseña</a>
            <a href="">Foto de perfil</a>
            <?php if($_SESSION["usuario"]["tipo"]=="COMERCIANTE"):?>
                <a href="">Nombre de la empresa</a>
                <a href="">Comentario de la empresa</a>
                <a href="">Numero de telefono</a>
                <a href="">Nif de la empresa</a>
            <?php endif?>
        </div>
    </main>

    




    







</body>
</html>