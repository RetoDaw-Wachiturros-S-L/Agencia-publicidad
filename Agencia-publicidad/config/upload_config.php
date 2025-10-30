<?php
// Configuración de subida de imágenes

define('UPLOAD_DIR', __DIR__ . '/../uploads/anuncios/');
define('UPLOAD_DIR_THUMBNAILS', UPLOAD_DIR . 'thumbnails/');
define('UPLOAD_DIR_MEDIUM', UPLOAD_DIR . 'medium/');
define('UPLOAD_DIR_ORIGINAL', UPLOAD_DIR . 'original/');

// Tamaños de imagen
define('THUMBNAIL_WIDTH', 200);
define('THUMBNAIL_HEIGHT', 200);
define('MEDIUM_WIDTH', 800);
define('MEDIUM_HEIGHT', 600);
define('ORIGINAL_MAX_WIDTH', 1920);
define('ORIGINAL_MAX_HEIGHT', 1080);

// Configuración de archivo
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'webp']);
define('ALLOWED_MIME_TYPES', ['image/jpeg', 'image/png', 'image/webp']);
define('MAX_IMAGES_PER_AD', 5);
?>