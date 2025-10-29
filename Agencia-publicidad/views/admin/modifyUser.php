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
</head>
<body>
    <main>
        <div class="admin-container">
            <div class="admin-header">
                <h1>Gestión de Usuarios</h1>
                <div style="display: flex; gap: 1em;">
                    <a href="javascript:history.back()" class="btn-back">
                        ← Volver atrás
                    </a>
                    <a href="<?= BASE_URL ?>/index.php?controller=AdminController&accion=createUser" class="btn-create">
                        + Crear Usuario
                    </a>
                </div>
            </div>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="message success-message">
                    <?= htmlspecialchars($_SESSION['success']) ?>
                    <?php unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="message error-message">
                    <?= htmlspecialchars($_SESSION['error']) ?>
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
                                <td><?= $usuario['nombre'] ? htmlspecialchars($usuario['nombre']) : 'null' ?></td>
                                <td><?= $usuario['apellido'] ? htmlspecialchars($usuario['apellido']) : 'null' ?></td>
                                <td><?= $usuario['email'] ? htmlspecialchars($usuario['email']) : 'null' ?></td>
                                <td>
                                    <?php
                                    $tipo = strtolower($usuario['tipo_usuario'] ?? '');
                                    $badgeClass = 'badge-visitante';
                                    if ($tipo === 'administrador') $badgeClass = 'badge-admin';
                                    if ($tipo === 'comerciante') $badgeClass = 'badge-comerciante';
                                    ?>
                                    <span class="badge <?= $badgeClass ?>">
                                        <?= $tipo ? htmlspecialchars(ucfirst($tipo)) : 'null' ?>
                                    </span>
                                </td>
                                <td><?= $usuario['fecha_inscripcion'] ? htmlspecialchars($usuario['fecha_inscripcion']) : 'null' ?></td>
                                <td>
                                    <div class="actions">
                                        <a href="<?= BASE_URL ?>/index.php?controller=AdminController&accion=editUser&id=<?= $usuario['id'] ?? '' ?>" 
                                           class="btn-action btn-edit">
                                            Editar
                                        </a>
                                        <a href="<?= BASE_URL ?>/index.php?controller=AdminController&accion=deleteUser&id=<?= $usuario['id'] ?? '' ?>" 
                                           class="btn-action btn-delete"
                                           onclick="return confirm('¿Estás seguro de que quieres eliminar este usuario?')">
                                            Eliminar
                                        </a>
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
    <script src="<?= BASE_URL ?>/js/admin.modifyUser.js"></script>
</html>
