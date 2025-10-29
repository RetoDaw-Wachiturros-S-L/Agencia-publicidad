<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../utils/auth_helper.php';

use function Agenciapublicidad\Utils\isAdmin;

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
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/header.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/auth.css">
</head>
<body>
    <?php include __DIR__ . '/../components/header.php'; ?>

    <main>
        <div class="auth-container">
            <h1>Editar Usuario</h1>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="error-message">
                    <?= htmlspecialchars($_SESSION['error']) ?>
                    <?php unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <form action="<?= BASE_URL ?>/index.php?controller=AdminController&accion=updateUser" method="POST" class="auth-form">
                <input type="hidden" name="id" value="<?= htmlspecialchars($usuario->getIdUsuario()) ?>">

                <div class="form-group">
                    <label for="nombre">Nombre *</label>
                    <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($usuario->getNombre()) ?>" required>
                </div>

                <div class="form-group">
                    <label for="apellido">Apellido</label>
                    <input type="text" id="apellido" name="apellido" value="<?= htmlspecialchars($usuario->getApellido() ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($usuario->getEmail()) ?>" required>
                </div>

                <div class="form-group">
                    <label for="password">Nueva Contraseña (dejar en blanco para mantener la actual)</label>
                    <input type="password" id="password" name="password">
                </div>

                <div class="form-group">
                    <label for="tipo">Tipo de Usuario *</label>
                    <select id="tipo" name="tipo" required>
                        <option value="VISITANTE" <?= $usuario->getTipo()->value === 'VISITANTE' ? 'selected' : '' ?>>Visitante</option>
                        <option value="COMERCIANTE" <?= $usuario->getTipo()->value === 'COMERCIANTE' ? 'selected' : '' ?>>Comerciante</option>
                        <option value="ADMIN" <?= $usuario->getTipo()->value === 'ADMIN' ? 'selected' : '' ?>>Administrador</option>
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
</html>
