<?php
require_once __DIR__ . '/../../config/config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Error del Servidor | Comerciantes Vitoria</title>
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/img/logo_SSombra.png">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/themes.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/errors.css">
</head>
<body>
    <div class="error-container">
        <div class="error-code">500</div>
        <h1 class="error-title">Error Interno del Servidor</h1>
        <p class="error-message">
            Ups, algo salió mal en nuestro servidor. Nuestro equipo técnico ha sido notificado 
            y está trabajando para solucionar el problema lo antes posible.
        </p>
        <div class="error-actions">
            <a href="<?= BASE_URL ?>/index.php?accion=index" class="error-btn error-btn-primary">
                🏠 Volver al inicio
            </a>
            <button onclick="location.reload()" class="error-btn error-btn-secondary">
                🔄 Reintentar
            </button>
        </div>
        <details class="error-details">
            <summary>Información técnica</summary>
            <p>
                <strong>Código de error:</strong> <code>500 Internal Server Error</code><br>
                <strong>Descripción:</strong> El servidor encontró una condición inesperada que le impidió completar la solicitud.<br>
                <strong>Qué hacer:</strong> Intenta recargar la página en unos minutos. Si el problema persiste, contáctanos.
            </p>
        </details>
    </div>
    <script src="<?= BASE_URL ?>/js/theme-switcher.js"></script>
</body>
</html>
