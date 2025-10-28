<?php
require_once __DIR__ . '/../../config/config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Página No Encontrada | Comerciantes Vitoria</title>
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/img/logo_SSombra.png">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/themes.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/errors.css">
</head>
<body>
    <div class="error-container">
        <div class="error-code">404</div>
        <h1 class="error-title">Página No Encontrada</h1>
        <p class="error-message">
            Vaya, parece que la página que buscas no existe o ha sido movida. 
            ¿Quizás te perdiste en el camino?
        </p>
        <div class="error-actions">
            <a href="<?= BASE_URL ?>/index.php?accion=index" class="error-btn error-btn-primary">
                🏠 Ir al inicio
            </a>
            <button onclick="history.back()" class="error-btn error-btn-secondary">
                ← Volver atrás
            </button>
        </div>
        <details class="error-details">
            <summary>¿Qué puedo hacer?</summary>
            <p>
                • Verifica que la URL esté escrita correctamente<br>
                • Vuelve a la página anterior y prueba de nuevo<br>
                • Regresa al inicio y navega desde allí<br>
                • Usa el buscador para encontrar lo que necesitas
            </p>
        </details>
    </div>
    <script src="<?= BASE_URL ?>/js/theme-switcher.js"></script>
</body>
</html>
