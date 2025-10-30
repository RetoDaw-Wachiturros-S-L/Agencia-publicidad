<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/themes.css"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/layout.css"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/editarPerfil.css"/>
</head>
<body>


    <main>


      
        <h1>Cambiar contraseña</h1>
         
        <form class="botones" method="post" action="<?= BASE_URL ?>/index.php?controller=PerfilController&accion=cambiarContrasena" enctype="multipart/form-data">
            <input type="password" placeholder="Contraseña actual" name="contrasena" id="contrasena"/>
            <span class="error"></span>
            <input type="password" placeholder="Nueva contraseña" name="contrasena2" id="contrasena2"/>
            <span class="error"></span>
            <input type="password" placeholder="Repetir nueva contraseña" name="contrasena3" id="contrasena3"/>


            

            
            <button type="submit" class="boton-enviar">Cambiar contraseña</button>
        </form>
        
        <script src="<?= BASE_URL ?>/js/validaciones.js"></script>
        <script src="<?= BASE_URL ?>/js/login.js"></script>
    </main>


    
</body>
</html>