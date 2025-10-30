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
    <title>Editar Perfil - Comerciantes Vitoria</title>
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/img/logo_SSombra.png">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/themes.css"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/layout.css"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/editarPerfil.css"/>
</head>
<body>
    <header>
    <a href="<?= BASE_URL ?>/index.php?controller=PerfilController&accion=miPerfil">
        <img src="<?= BASE_URL ?>/img/vector.png" alt="Ir a mi perfil" style="cursor: pointer;">
    </a>
    </header>


    <main>
        <?php if(empty($_SESSION["usuario"]["foto_perfil"])):?>
            <h2><img src="<?= BASE_URL ?>/img/fotoperfil.png" alt="fotoperfil"> Editar usuario</h2>
        <?php else:?>
            <h2><img src="<?= BASE_URL ?><?= $_SESSION["usuario"]["foto_perfil"] ?>" alt="fotoperfil"> Editar usuario</h2>
        <?php endif?>
        <?php if($_SESSION["usuario"]["tipo"] == "COMERCIANTE"){
            $var="insertarDatosPerfilComerci";
        }else{
            $var="insertarDatosPerfil";
        }    
        ?>
            
     
    
        
        <h1>Campos a cambiar</h1>
         
            <form class="botones" method="post" action="<?= BASE_URL ?>/index.php?controller=PerfilController&accion=<?=$var?>" enctype="multipart/form-data">
                <input type="text" placeholder="Nombre" name="nombre" value="<?=$perfil["nombre"]?>"/>
                <input type="text" placeholder="Apellido" name="apellido" value="<?=$perfil["apellido"]?>"/>
                <a href="<?= BASE_URL ?>/index.php?controller=PerfilController&accion=vistaContrasena" class="contrasena">Cambiar contraseña</a>
                
                
                <?php if($_SESSION["usuario"]["tipo"]=="COMERCIANTE"):?>
                    <input type="text" placeholder="Nombre de la empresa" name="nombre_empresa" value="<?=$perfil["nombre_empresa"]?>"/>
                    <input type="text" placeholder="Comentario de la empresa" name="comentario_empresa" value="<?=$perfil["comentario_empresa"]?>"/>
                    <input type="text" placeholder="Número de telefono" name="telefono_empresa" value="<?=$perfil["num_telefono"]?>"/>
                    <input type="text" placeholder="NIF de la empresa" name="nif_empresa" value="<?=$perfil["nif_empresa"]?>"/>
                <?php endif?>
                
                <button type="submit" class="boton-enviar">Guardar cambios</button>
            </form>
    </main>
    
    <script src="<?= BASE_URL ?>/js/index.js"></script>
    <script src="<?= BASE_URL ?>/js/theme-switcher.js" defer></script>
</body>
</html>