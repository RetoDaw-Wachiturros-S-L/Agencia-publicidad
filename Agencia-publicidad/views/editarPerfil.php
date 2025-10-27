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
        <?php else:?>
            <h2><img src="" alt="fotoperfil"> Editar usuario</h2>
        <?php endif?>

        <h1>Campos a cambiar</h1>
            <form class="botones" method="post" action="procesarEdicion.php" enctype="multipart/form-data">
                <input type="text" placeholder="Nombre" name="nombre"/>
                <input type="text" placeholder="Apellido" name="apellido"/>
                <input type="password" placeholder="Contrasña" name="contrasena"/>
                
                <!-- Input file personalizado -->
                <div class="custom-file">
                    <input type="file" id="foto_perfil" name="foto_perfil"/>
                    <label for="foto_perfil"> Foto de perfil</label>
                </div>
                
                <?php if($_SESSION["usuario"]["tipo"]=="COMERCIANTE"):?>
                    <input type="text" placeholder="Nombre de la empresa" name="nombre_empresa"/>
                    <input type="text" placeholder="Comentario de la empresa" name="comentario_empresa"/>
                    <input type="text" placeholder="Número de teléfono" name="telefono_empresa"/>
                    <input type="text" placeholder="NIF de la empresa" name="nif_empresa"/>
                <?php endif?>
                
                <button type="submit" class="boton-enviar">Guardar cambios</button>
            </form>

    </main>



    




    







</body>
</html>