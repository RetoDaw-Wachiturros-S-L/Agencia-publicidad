<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de inicio de sesion</title>
</head>
<body>
<h1>Formulario de inicio de sesion</h1>

<?php
// Si hay algún mensaje de error lo mostramos:
if(isset($mensaje_error)) :?>
    <p style='color:red;'><?= $mensaje_error ?></p>
<?php endif; ?>

<form action='../../index.php?controller=OutController&accion=iniciarSesion' method='post'>
    <fieldset>
        <legend>Inicio de sesion</legend>
    
        <p>
            <label for='email'>Email</label>
            <input type='email' id='email' name='email' required>
        </p>
        <p>
            <label for='contrasena'>Contraseña</label>
            <input type='password' id='contrasena' name='contrasena' required>
        </p>
        <p>
            <input type='submit' value='Enviar'>
        </p>
    </fieldset>
</form>

</body>
</html>