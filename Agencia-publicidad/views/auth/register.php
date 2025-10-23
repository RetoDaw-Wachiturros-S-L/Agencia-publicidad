<?php
if (!defined('ACCESSED_VIA_ROUTER')) {
    http_response_code(403);
    die('Acceso directo no permitido');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de registro</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/auth.css">
    <script>
    (function (m, a, z, e) {
      var s, t;
      try {
        t = m.sessionStorage.getItem('maze-us');
      } catch (err) {}

      if (!t) {
        t = new Date().getTime();
        try {
          m.sessionStorage.setItem('maze-us', t);
        } catch (err) {}
      }

      s = a.createElement('script');
      s.src = z + '?apiKey=' + e;
      s.async = true;
      a.getElementsByTagName('head')[0].appendChild(s);
      m.mazeUniversalSnippetApiKey = e;
    })(window, document, 'https://snippet.maze.co/maze-universal-loader.js', 'e76390a3-92da-44e0-9412-672022d0d84d');
    </script>
</head>
<body>
    <main>
        <h1>Formulario de registro de nuevo usuario</h1>

        <?php
        // Si hay algún mensaje de error lo mostramos:
        if(isset($mensaje_error)) :?>
            <p class="mensaje-error"><?= $mensaje_error ?></p>
        <?php endif; ?>

        <div id="form-container">
            <form action='index.php?controller=OutController&accion=store' method='post' id="registro">
                <fieldset>
                    <legend>Registro</legend>
                    
                    <p>
                        <label for='nombre'>Nombre</label>
                        <input type='text' id='nombre' name='nombre' placeholder="Nombre*" required maxlength="50">
                        <span class="error"></span>
                    </p>
                    
                    <p>
                        <label for='apellido'>Apellido</label>
                        <input type='text' id='apellido' name='apellido' placeholder="Apellido" maxlength="50">
                        <span class="error"></span>
                    </p>
                    
                    <p>
                        <label for='email'>Email</label>
                        <input type='email' id='email' name='email' placeholder="Email*" required>
                        <span class="error"></span>
                    </p>
                    
                    <p>
                        <label for='contrasena'>Contraseña</label>
                        <input type='password' id='contrasena' name='contrasena' placeholder="Contraseña*" required>
                        <span class="error"></span>
                    </p>
                    
                    <p>
                        <label for='contrasena2'>Repetir Contraseña</label>
                        <input type='password' id='contrasena2' name='contrasena2' placeholder="Repetir Contraseña*" required>
                        <span class="error"></span>
                    </p>
                    
                    <p>
                        <label for="url_foto">Subir foto</label>
                        <!-- <input type="file" name="url_fotos"> -->
                    </p>
                    
                    
                    <p>
                        <label for="es_comercio">¿Eres un comercio?</label>
                        <input type="checkbox" name="es_comercio" id="es_comercio" value="1">
                    </p>
                    
                    <div id="formulario_extra">
                        <p>
                            <label for="nombreEmpresa">Nombre de la empresa:*</label>
                            <input type="text" id="nombreEmpresa" name="nombreEmpresa" placeholder="Nombre de la empresa" maxlength="50" required>
                            <span class="error"></span>
                        </p>
                        
                        <p>
                            <label for="nifEmpresa">NIF de la empresa:*</label>
                            <input type="text" id="nifEmpresa" name="nifEmpresa" placeholder="NIF de la empresa" minlength="9" maxlength="9" required>
                            <span class="error"></span>
                        </p>
                        
                        <p>
                            <label for="comentarioEmpresa">Comentario sobre la empresa:</label>
                            <input type="text" id="comentarioEmpresa" name="comentarioEmpresa" placeholder="Comentario">
                            <span class="error"></span>
                        </p>
                        
                        <p>
                            <label for="telefonoEmpresa">Teléfono de la empresa:</label>
                            <input type="tel" id="telefonoEmpresa" name="telefonoEmpresa" placeholder="Teléfono (9 dígitos)" minlength="9" maxlength="9">
                            <span class="error"></span>
                        </p>
                    </div>
                    
                    <p>
                        <input type='submit' value='Registrar'>
                    </p>
                </fieldset>
            </form>
        </div>

        <script src="<?= BASE_URL ?>/js/validaciones.js"></script>
        <script src="<?= BASE_URL ?>/js/register.js"></script>
    </main>
</body>
</html>