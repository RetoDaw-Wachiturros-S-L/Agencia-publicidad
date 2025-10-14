<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de registro</title>
</head>
<body>
<h1>Formulario de registro</h1>

<?php
// Si hay algún mensaje de error lo mostramos:
if(isset($mensaje_error)) :?>
    <p style='color:red;'><?= $mensaje_error ?></p>
<?php endif; ?>

<form action='index.php?controller=RegisterController&accion=store' method='post'>
    <fieldset>
        <legend>Registro</legend>
        <p>
            <label for='nombre'>Nombre</label>
            <input type='text' id='nombre' name='nombre' required>
        </p>
        <p>
            <label for='apellido'>Apellido</label>
            <input type='text' id='apellido' name='apellido' required>
        </p>
            <label for='email'>Email</label>
            <input type='email' id='email' name='email' required>
        </p>
        <p>
            <label for='contrasena'>Contraseña</label>
            <input type='password' id='contrasena' name='contrasena' required>
        </p>
        <p>
            <label for='contrasena2'>Repetir Contraseña</label>
            <input type='password' id='contrasena2' name='contrasena2' required>
        </p>
        <p>
            <h4>Subir foto</h4>
        </p>
        <p>
            <input type="checkbox" name="es_comercio" id="es_comercio" value="1">
            <label for="es_comercio">¿Eres un comercio?</label>
        </p>
        <p>
            <input type='submit' value='Enviar'>
        </p>
    </fieldset>
</form>

</body>
</html>