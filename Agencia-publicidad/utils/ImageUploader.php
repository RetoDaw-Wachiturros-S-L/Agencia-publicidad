<?php
namespace AgenciaPublicidad\Utils;

require_once __DIR__ . '/../config/upload_config.php';

class ImageUploader {
    
    /**
     * Procesa y guarda una imagen subida
     * @param array $file Array $_FILES['nombre_campo']
     * @param int $idAnuncio ID del anuncio
     * @return array ['success' => bool, 'data' => array, 'error' => string]
     */
    public static function uploadImage($file, $idAnuncio) {
        // Validar archivo
        $validation = self::validateFile($file);
        if (!$validation['success']) {
            return $validation;
        }
        
        // Generar nombre único
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $filename = 'anuncio_' . $idAnuncio . '_' . uniqid() . '.' . $extension;
        
        // Rutas completas
        $pathOriginal = UPLOAD_DIR_ORIGINAL . $filename;
        $pathMedium = UPLOAD_DIR_MEDIUM . $filename;
        $pathThumbnail = UPLOAD_DIR_THUMBNAILS . $filename;
        
        try {
            // Procesar imagen original
            $originalImage = self::processImage(
                $file['tmp_name'], 
                $pathOriginal, 
                ORIGINAL_MAX_WIDTH, 
                ORIGINAL_MAX_HEIGHT
            );
            
            if (!$originalImage) {
                return ['success' => false, 'error' => 'Error al procesar imagen original'];
            }
            
            // Crear versión media
            self::processImage(
                $pathOriginal, 
                $pathMedium, 
                MEDIUM_WIDTH, 
                MEDIUM_HEIGHT
            );
            
            // Crear miniatura
            self::createThumbnail(
                $pathOriginal, 
                $pathThumbnail, 
                THUMBNAIL_WIDTH, 
                THUMBNAIL_HEIGHT
            );
            
            return [
                'success' => true,
                'data' => [
                    'filename' => $filename,
                    'original' => 'uploads/anuncios/original/' . $filename,
                    'medium' => 'uploads/anuncios/medium/' . $filename,
                    'thumbnail' => 'uploads/anuncios/thumbnails/' . $filename
                ]
            ];
            
        } catch (\Exception $e) {
            error_log("ImageUploader::uploadImage - Error: " . $e->getMessage());
            return ['success' => false, 'error' => 'Error al subir la imagen'];
        }
    }
    
    /**
     * Valida el archivo subido
     */
    private static function validateFile($file) {
        // Verificar errores de subida
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'error' => 'Error al subir el archivo'];
        }
        
        // Verificar tamaño
        if ($file['size'] > MAX_FILE_SIZE) {
            return ['success' => false, 'error' => 'El archivo excede el tamaño máximo (5MB)'];
        }
        
        // Verificar extensión
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, ALLOWED_EXTENSIONS)) {
            return ['success' => false, 'error' => 'Tipo de archivo no permitido'];
        }
        
        // Verificar MIME type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        
        if (!in_array($mimeType, ALLOWED_MIME_TYPES)) {
            return ['success' => false, 'error' => 'Tipo de archivo no válido'];
        }
        
        return ['success' => true];
    }
    
    /**
     * Procesa y redimensiona una imagen
     */
    private static function processImage($source, $destination, $maxWidth, $maxHeight) {
        list($width, $height, $type) = getimagesize($source);
        
        // Crear imagen desde el archivo fuente
        switch ($type) {
            case IMAGETYPE_JPEG:
                $image = imagecreatefromjpeg($source);
                break;
            case IMAGETYPE_PNG:
                $image = imagecreatefrompng($source);
                break;
            case IMAGETYPE_WEBP:
                $image = imagecreatefromwebp($source);
                break;
            default:
                return false;
        }
        
        // Calcular nuevas dimensiones manteniendo proporción
        $ratio = min($maxWidth / $width, $maxHeight / $height);
        
        // Solo redimensionar si es necesario
        if ($ratio < 1) {
            $newWidth = (int)($width * $ratio);
            $newHeight = (int)($height * $ratio);
        } else {
            $newWidth = $width;
            $newHeight = $height;
        }
        
        // Crear nueva imagen
        $newImage = imagecreatetruecolor($newWidth, $newHeight);
        
        // Preservar transparencia para PNG
        if ($type === IMAGETYPE_PNG) {
            imagealphablending($newImage, false);
            imagesavealpha($newImage, true);
        }
        
        // Redimensionar
        imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        
        // Guardar imagen
        $result = false;
        switch ($type) {
            case IMAGETYPE_JPEG:
                $result = imagejpeg($newImage, $destination, 90);
                break;
            case IMAGETYPE_PNG:
                $result = imagepng($newImage, $destination, 8);
                break;
            case IMAGETYPE_WEBP:
                $result = imagewebp($newImage, $destination, 90);
                break;
        }
        
        imagedestroy($image);
        imagedestroy($newImage);
        
        return $result;
    }
    
    /**
     * Crea miniatura cuadrada con recorte centrado
     */
    private static function createThumbnail($source, $destination, $width, $height) {
        list($origWidth, $origHeight, $type) = getimagesize($source);
        
        // Crear imagen desde el archivo fuente
        switch ($type) {
            case IMAGETYPE_JPEG:
                $image = imagecreatefromjpeg($source);
                break;
            case IMAGETYPE_PNG:
                $image = imagecreatefrompng($source);
                break;
            case IMAGETYPE_WEBP:
                $image = imagecreatefromwebp($source);
                break;
            default:
                return false;
        }
        
        // Calcular dimensiones para recorte centrado
        $ratio = max($width / $origWidth, $height / $origHeight);
        $cropWidth = (int)($width / $ratio);
        $cropHeight = (int)($height / $ratio);
        $cropX = (int)(($origWidth - $cropWidth) / 2);
        $cropY = (int)(($origHeight - $cropHeight) / 2);
        
        // Crear miniatura
        $thumbnail = imagecreatetruecolor($width, $height);
        
        // Preservar transparencia para PNG
        if ($type === IMAGETYPE_PNG) {
            imagealphablending($thumbnail, false);
            imagesavealpha($thumbnail, true);
        }
        
        // Copiar y redimensionar con recorte
        imagecopyresampled(
            $thumbnail, $image,
            0, 0, $cropX, $cropY,
            $width, $height, $cropWidth, $cropHeight
        );
        
        // Guardar miniatura
        $result = false;
        switch ($type) {
            case IMAGETYPE_JPEG:
                $result = imagejpeg($thumbnail, $destination, 90);
                break;
            case IMAGETYPE_PNG:
                $result = imagepng($thumbnail, $destination, 8);
                break;
            case IMAGETYPE_WEBP:
                $result = imagewebp($thumbnail, $destination, 90);
                break;
        }
        
        imagedestroy($image);
        imagedestroy($thumbnail);
        
        return $result;
    }
    
    /**
     * Elimina todas las versiones de una imagen
     */
    public static function deleteImage($filename) {
        $paths = [
            UPLOAD_DIR_ORIGINAL . $filename,
            UPLOAD_DIR_MEDIUM . $filename,
            UPLOAD_DIR_THUMBNAILS . $filename
        ];
        
        foreach ($paths as $path) {
            if (file_exists($path)) {
                unlink($path);
            }
        }
    }
}