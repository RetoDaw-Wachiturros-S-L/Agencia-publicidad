<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de inicio de sesion</title>
    <link rel="stylesheet" href="layout.css">
</head>
<body>
<h1>Formulario de inicio de sesion</h1>

<?php
// Si hay algún mensaje de error lo mostramos:
if(isset($mensaje_error)) :?>
    <p style='color:red;'><?= $mensaje_error ?></p>
<?php endif; ?>

<form action='../index.php?controller=OutController&accion=iniciarSesion' method='post' id="login">
    <fieldset>
        <legend>Inicio de sesion</legend>
    
        <p>
            <label for='email'>Email</label>
            <input type='email' id='email' name='email' required>
            <span class="error"></span>
        </p>
        <p>
            <label for='contrasena'>Contraseña</label>
            <input type='password' id='contrasena' name='contrasena' required>
            <span class="error"></span>
        </p>
        <p>
            <input type='submit' value='Enviar'>
        </p>
    </fieldset>
</form>

<script src="../../js/validaciones.js"></script>
<script src="../../js/login.js"></script>

</body>
</html>