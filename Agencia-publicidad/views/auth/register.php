<?php
if (!defined('ACCESSED_VIA_ROUTER')) {
    http_response_code(403);
    require_once __DIR__ . '/../errors/403.php';
    exit;
}

require_once __DIR__ . '/../../utils/auth_helper.php';

// Extraer variables globales al scope local
$currentUser = $GLOBALS['currentUser'] ?? null;
$isLoggedIn = $GLOBALS['isLoggedIn'] ?? false;
$isAdmin = $GLOBALS['isAdmin'] ?? false;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comerciantes Vitoria</title>
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/img/logo_SSombra.png">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/themes.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/layout.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/auth.css">
</head>
<body>
    <?php include __DIR__ . '/../components/header.php'; ?>
    
    <main class="auth-main">
        <h1>Formulario de registro de nuevo usuario</h1>

        <?php
        // Si hay algún mensaje de error lo mostramos:
        if(isset($mensaje_error)) :?>
            <p class="mensaje-error"><?= $mensaje_error ?></p>
        <?php endif; ?>

        <div id="form-container">
            <form action='index.php?controller=AuthController&accion=store' method='post' id="registro">
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
        <script src="<?= BASE_URL ?>/js/index.js"></script>
        <script src="<?= BASE_URL ?>/js/theme-switcher.js" defer></script>
    </main>
</body>
</html>