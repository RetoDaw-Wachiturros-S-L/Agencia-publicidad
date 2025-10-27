<?php
// Cargar configuración si no está definida
if (!defined('BASE_URL')) {
    require_once __DIR__ . '/../../config/config.php';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error | Comerciantes Vitoria</title>
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/img/logo_SSombra.png">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/themes.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/errors.css">
</head>
<body>
    <div class="error-container">
        <div class="error-code">⚠️</div>
        <h1 class="error-title">Ha Ocurrido un Error</h1>
        <p class="error-message">
            Lo sentimos, algo no salió como esperábamos. 
            Por favor, intenta de nuevo o contacta con nosotros si el problema persiste.
        </p>
        <div class="error-actions">
            <a href="<?= BASE_URL ?>/" class="error-btn error-btn-primary">
                🏠 Ir al inicio
            </a>
            <button onclick="history.back()" class="error-btn error-btn-secondary">
                ← Volver atrás
            </button>
            <button onclick="location.reload()" class="error-btn error-btn-secondary">
                🔄 Reintentar
            </button>
        </div>
        <details class="error-details">
            <summary>Información del error</summary>
            <p>
                Si el problema persiste, por favor:<br><br>
                • Intenta limpiar la caché de tu navegador<br>
                • Verifica tu conexión a internet<br>
                • Contacta con nuestro equipo de soporte<br>
                • Proporciona la hora exacta en que ocurrió el error
            </p>
        </details>
    </div>
    <script src="<?= BASE_URL ?>/js/theme-switcher.js"></script>
</body>
</html>
