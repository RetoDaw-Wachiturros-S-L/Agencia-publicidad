<?php
require_once __DIR__ . '/../../utils/auth_helper.php';

if (!isset($currentUser) || empty($currentUser)){    
    echo "Error: Usuario no autenticado";
    require_once __DIR__ . '/../errors/403.php';
    exit;
}

if ($currentUser['tipo'] !== 'ADMINISTRADOR') {
    http_response_code(403);
    exit;
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de registro</title>

    <style>
        #formulario_extra {
            display: none;
        }
    </style>

</head>
<body>

<h1>Formulario de registro</h1>

<?php
// Si hay algún mensaje de error lo mostramos:
if(isset($mensaje_error)) :?>
    <p style='color:red;'><?= $mensaje_error ?></p>
<?php endif; ?>

<form
    action='index.php?controller=OutController&accion=store'
    method='post' 
    id="registro">
    <fieldset>
        <legend>Registro</legend>
        <p>
            <label for='nombre'>Nombre</label>
            <input type='text' id='nombre' name='nombre' required>
            <span class="error"></span>
        </p>
        <p>
            <label for='apellido'>Apellido</label>
            <input type='text' id='apellido' name='apellido'>
            <span class="error"></span>
        </p>
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
            <label for='contrasena2'>Repetir Contraseña</label>
            <input type='password' id='contrasena2' name='contrasena2' required>
            <span class="error"></span>
        </p>
        <p>
            <h4>Subir foto</h4>
        </p>
        <p>
            <label for="es_comercio">¿Eres un comercio?</label>
            <input type="checkbox" name="es_comercio" id="es_comercio" value="1">
        </p>
        <p>
            <input type='submit' value='Enviar'>
        </p>
        <div id="formulario_extra" >
            <p>
                <label for="nombreEmpresa">Nombre de la empresa:</label>
                <input type="text" id="nombreEmpresa" name="nombreEmpresa">
                <span class="error"></span>
            </p>
            <p>
                <label for="nifEmpresa">NIF de la empresa:</label>
                <input type="text" id="nifEmpresa" name="nifEmpresa">
                <span class="error"></span>
            </p>
            <p>
                <label for="comentarioEmpresa">Comentario sobre la empresa:</label>
                <input type="text" id="comentarioEmpresa" name="comentarioEmpresa">
                <span class="error"></span>
            </p>
            <p>
                <label for="telefonoEmpresa">Teléfono de la empresa:</label>
                <input type="tel" id="telefonoEmpresa" name="telefonoEmpresa" minlength="9" maxlength="9">
                <span class="error"></span>
            </p>
        </div>
       
    </fieldset>
</form>

<script src="<?= BASE_URL ?>/js/validaciones.js"></script>
<script src="<?= BASE_URL ?>/js/register.js"></script>

</body>
</html>