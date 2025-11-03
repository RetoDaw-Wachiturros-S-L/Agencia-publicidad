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
    <title>Gestión de Usuarios - Panel Admin</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/themes.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/layout.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/adminModify.css">
    <style>
        .lampara {
            margin-left: 3em;
            margin-top: 0.1px;
        }
    </style>
</head>
<body>
    <div class="lampara" role="button" aria-label="Cambiar tema" tabindex="0"></div>
    <main>
        <div class="admin-container">
            <div class="admin-header">
                <h1>Gestión de Usuarios</h1>
                <div style="display: flex; gap: 1em;">
                    <a href="<?= BASE_URL ?>/index.php?controller=MainController&accion=index" class="btn-back">
                        ← Volver atrás
                    </a>
                    <a href="<?= BASE_URL ?>/index.php?controller=AdminController&accion=createUser" class="btn-create">
                        + Crear Usuario
                    </a>
                </div>
            </div>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="message success-message">
                    <?= ($_SESSION['success']) ?>
                    <?php unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="message error-message">
                    <?= ($_SESSION['error']) ?>
                    <?php unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <?php if (empty($usuarios)): ?>
                <p>No hay usuarios registrados en el sistema.</p>
            <?php else: ?>
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Email</th>
                            <th>Tipo</th>
                            <th>Fecha Inscripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td><?= $usuario['nombre'] ? $usuario['nombre'] : 'Sin detalles' ?></td>
                                <td><?= $usuario['apellido'] ? $usuario['apellido'] : 'Sin detelles' ?></td>
                                <td><?= $usuario['email'] ? $usuario['email'] : 'Sin detalles' ?></td>
                                <td>
                                    <?php
                                    $tipo = strtolower($usuario['tipo_usuario'] ?? '');
                                    $badgeClass = 'badge-visitante';
                                    if ($tipo === 'administrador') $badgeClass = 'badge-admin';
                                    if ($tipo === 'comerciante') $badgeClass = 'badge-comerciante';
                                    ?>
                                    <span class="badge <?= $badgeClass ?>">
                                        <?= $tipo ? (ucfirst($tipo)) : 'null' ?>
                                    </span>
                                </td>
                                <td><?= $usuario['fecha_inscripcion'] ? ($usuario['fecha_inscripcion']) : 'null' ?></td>
                                <td>
                                    <div class="actions">
                                        <a href="<?= BASE_URL ?>/index.php?controller=AdminController&accion=editUser&id=<?= $usuario['id'] ?? '' ?>" 
                                           class="btn-action btn-edit">
                                            Editar
                                        </a>
                                        <a href="<?= BASE_URL ?>/index.php?controller=AdminController&accion=deleteUser&id=<?= $usuario['id'] ?? '' ?>" 
                                           class="btn-action btn-delete">Eliminar</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </main>
    
</body>
    <script src="<?= BASE_URL ?>/js/theme-switcher.js" defer></script>
    <script src="<?= BASE_URL ?>/js/admin.modifyUser.js"></script>
</html>
