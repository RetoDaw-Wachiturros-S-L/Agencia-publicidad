<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../utils/auth_helper.php';

use function Agenciapublicidad\Utils\isAdmin;
use AgenciaPublicidad\Models\TipoPersonaEnum;

// Verificar autenticación
if (!isAdmin()) {
    header('Location: ' . BASE_URL . '/views/errors/403.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario - Panel Admin</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/themes.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/layout.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/auth.css">
</head>
<body>

    <main class="auth-main">
            <h1>Editar Usuario</h1>

        <div class="auth-container" id="form-container">
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="error-message">
                    <?= htmlspecialchars($_SESSION['error']) ?>
                    <?php unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <form action="<?= BASE_URL ?>/index.php?controller=AdminController&accion=updateUser" method="POST" class="auth-form">
                <input type="hidden" name="id" value="<?= $usuario->getIdUsuario() ?>">

                <div class="form-group">
                    <label for="nombre" hidden>Nombre *</label>
                    <input type="text" id="nombre" name="nombre" value="<?= $usuario->getNombre() ?>" required placeholder="Nombre">
                </div>

                <div class="form-group">
                    <label for="apellido" hidden>Apellido</label>
                    <input type="text" id="apellido" name="apellido" value="<?= $usuario->getApellido() ?? '' ?>" placeholder="Apellido">
                </div>

                <div class="form-group">
                    <label for="email" hidden>Email *</label>
                    <input type="email" id="email" name="email" value="<?= $usuario->getEmail() ?>" required placeholder="Correo electrónico">
                </div>

                <div class="form-group">
                    <label for="password" hidden>Nueva Contraseña (dejar en blanco para mantener la actual)</label>
                    <input type="password" id="password" name="password" placeholder="Nueva Contraseña (opcional)">
                </div>

                <div class="form-group">
                    <label for="tipo">Tipo de Usuario *</label>
                    <select id="tipo" name="tipo" required>
                        <option value="VISITANTE" <?= $usuario->getTipo()->value === 'VISITANTE' ? 'selected' : '' ?> > <?= TipoPersonaEnum::VISITANTE->value ?> </option>
                        <option value="COMERCIANTE" <?= $usuario->getTipo()->value === 'COMERCIANTE' ? 'selected' : '' ?>><?= TipoPersonaEnum::COMERCIANTE->value ?></option>
                        <option value="ADMINISTRADOR" <?= $usuario->getTipo()->value === 'ADMIN' ? 'selected' : '' ?>><?= TipoPersonaEnum::ADMINISTRADOR->value ?></option>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary">Actualizar Usuario</button>
                    <a href="<?= BASE_URL ?>/index.php?controller=AdminController&accion=modifyUser" class="btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </main>
</body>
    <script scr="<?= BASE_URL ?>/js/theme-switcher.js" defer></script>

</html>
