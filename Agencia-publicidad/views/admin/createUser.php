<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../utils/auth_helper.php';

use function Agenciapublicidad\Utils\isAdmin;

// Verificar que sea admin
if (!isAdmin()) {
    http_response_code(403);
    require_once __DIR__ . '/../errors/403.php';
    exit;
}

// Extraer variables globales al scope local
$currentUser = $GLOBALS['currentUser'] ?? null;
$isLoggedIn = $GLOBALS['isLoggedIn'] ?? false;
$isAdmin = $GLOBALS['isAdmin'] ?? false;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Usuario - Panel Admin</title>
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/img/logo_SSombra.png">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/themes.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/layout.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/auth.css">
</head>
<body>
    
    <main class="auth-main">
        <h1>Crear Nuevo Usuario</h1>

        <?php
        // Si hay algún mensaje de error lo mostramos:
        if(isset($_SESSION['error'])) :?>
            <p class="mensaje-error"><?= htmlspecialchars($_SESSION['error']) ?></p>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php
        // Si hay algún mensaje de éxito lo mostramos:
        if(isset($_SESSION['success'])) :?>
            <p class="mensaje-exito"><?= htmlspecialchars($_SESSION['success']) ?></p>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <div id="form-container">
            <form action='<?= BASE_URL ?>/index.php?controller=AdminController&accion=storeUser' method='post' id="registro">
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
                        <label>Tipo de Usuario*</label>
                    </p>
                    
                    <p>
                        <label for="tipo_visitante">Visitante</label>
                        <input type="checkbox" name="tipo" id="tipo_visitante" value="VISITANTE" class="tipo-checkbox" checked>
                    </p>
                    
                    <p>
                        <label for="es_comercio">Comerciante</label>
                        <input type="checkbox" name="tipo" id="es_comercio" value="COMERCIANTE" class="tipo-checkbox">
                    </p>
                    
                    <p>
                        <label for="tipo_admin">Administrador</label>
                        <input type="checkbox" name="tipo" id="tipo_admin" value="ADMINISTRADOR" class="tipo-checkbox">
                    </p>
                    
                    <div id="formulario_extra">
                        <p>
                            <label for="nombreEmpresa">Nombre de la empresa:*</label>
                            <input type="text" id="nombreEmpresa" name="nombreEmpresa" placeholder="Nombre de la empresa" maxlength="50">
                            <span class="error"></span>
                        </p>
                        
                        <p>
                            <label for="nifEmpresa">NIF de la empresa:*</label>
                            <input type="text" id="nifEmpresa" name="nifEmpresa" placeholder="NIF de la empresa" minlength="9" maxlength="9">
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
                        <input type='submit' value='Crear Usuario'>
                    </p>
                </fieldset>
            </form>
        </div>

        <script src="<?= BASE_URL ?>/js/validaciones.js"></script>
        <script src="<?= BASE_URL ?>/js/register.js"></script>
        <script src="<?= BASE_URL ?>/js/admin-create-user.js"></script>
        <script src="<?= BASE_URL ?>/js/index.js"></script>
        <script src="<?= BASE_URL ?>/js/theme-switcher.js" defer></script>
    </main>
</body>
</html>