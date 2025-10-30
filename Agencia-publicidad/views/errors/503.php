<?php
require_once __DIR__ . '/../../config/config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>503 - Servicio No Disponible | Comerciantes Vitoria</title>
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/img/logo_SSombra.png">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/themes.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/errors.css">
</head>
<body>
    <div class="error-container">
        <div class="error-code">503</div>
        <h1 class="error-title">Servicio Temporalmente No Disponible</h1>
        <p class="error-message">
            Estamos realizando tareas de mantenimiento para mejorar tu experiencia. 
            Volveremos a estar en línea pronto. Gracias por tu paciencia.
        </p>
        <div class="error-actions">
            <button onclick="location.reload()" class="error-btn error-btn-primary">
                🔄 Reintentar
            </button>
            <a href="mailto:soporte@comerciantesvitoria.com" class="error-btn error-btn-secondary">
                📧 Contactar soporte
            </a>
        </div>
        <details class="error-details">
            <summary>Información adicional</summary>
            <p>
                <strong>Código de error:</strong> <code>503 Service Unavailable</code><br>
                <strong>Descripción:</strong> El servidor está temporalmente fuera de servicio.<br>
                <strong>Motivo común:</strong> Mantenimiento programado o sobrecarga del servidor.<br>
                <strong>Tiempo estimado:</strong> Por favor, inténtalo de nuevo en unos minutos.
            </p>
        </details>
    </div>
    <script src="<?= BASE_URL ?>/js/theme-switcher.js"></script>
</body>
</html>
