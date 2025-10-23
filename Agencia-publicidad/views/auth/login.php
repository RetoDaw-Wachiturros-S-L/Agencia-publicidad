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
    <title>Iniciar sesion</title>
    <link rel="stylesheet" href="css/auth.css">
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
        <h1>Iniciar sesión</h1>

        <?php
        // Si hay algún mensaje de error lo mostramos:
        if(isset($mensaje_error)) :?>
            <p class="mensaje-error"><?= $mensaje_error ?></p>
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