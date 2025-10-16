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

<form action='../../index.php?controller=OutController&accion=store' method='post' id="registro">
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
        <div id="formulario_extra" >
            <p>
                <label for="nombrEmpresa">Nombre de la empresa:</label>
                <input type="text" id="nombrEmpresa" name="nombrEmpresa">
            </p>
            <p>
                <label for="nifEmpresa">NIF de la empresa:</label>
                <input type="text" id="nifEmpresa" name="nombrEmpresa">
            </p>
            <p>
                <label for="comentarioEmpresa">Comentario sobre la empresa:</label>
                <input type="text" id="comentarioEmpresa" name="comentarioEmpresa" required>
            </p>
            <p>
                <label for="telefonoEmpresa">Teléfono de la empresa:</label>
                <input type="tel" id="telefonoEmpresa" name="telefonoEmpresa" required>
            </p>
            
        </div>
        <script>
            
            const checkbox = document.getElementById('es_comercio');
            const extraForm = document.getElementById('formulario_extra');
            const form = document.getElementById('registro');
            extraForm.style.display = 'none';
            checkbox.addEventListener('change', mostrarFormunuevo);

            function mostrarFormunuevo(){
                if(this.checked){
                    extraForm.style.display = 'block';
                
                }else{
                    extraForm.style.display = "none";
                }
            }

        </script>
    </fieldset>
</form>

</body>
</html>