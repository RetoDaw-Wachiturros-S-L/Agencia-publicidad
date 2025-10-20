<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesion</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <main>

        <?php
        // Si hay algún mensaje de error lo mostramos:
        if(isset($mensaje_error)) :?>
            <p style='color:red;'><?= $mensaje_error ?></p>
        <?php endif; ?>

        <div id="form-container">
            <form action="index.php?controller=OutController&accion=iniciarSesion" method="post" id="login">
            <input type="email" id="email" name="email" required placeholder="Email*">
            <span class="error"></span>

            <input type="password" id="contrasena" name="contrasena" required placeholder="Contraseña*">
            <span class="error"></span>

            <input type="submit" value="Enviar" id="btn-login">
            </form>
        </div>

        
        <script src="js/validaciones.js"></script>
        <script src="js/login.js"></script>

    </main>
</body>
</html>