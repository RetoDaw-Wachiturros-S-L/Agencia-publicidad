# Sistema de Subida de Imágenes para Anuncios

## Objetivo
Implementar un sistema completo de subida, procesamiento y almacenamiento de imágenes para los anuncios, permitiendo:
- Subir una o múltiples imágenes por anuncio
- Almacenar las imágenes en el servidor
- Guardar las referencias en la base de datos
- Mostrar las imágenes en la portada y vista detallada del anuncio

---

## 1. Estructura de Base de Datos

### Tabla actual: `anuncios`
Verificar que la tabla tenga el campo para almacenar las URLs de las fotos:
```sql
ALTER TABLE anuncios 
ADD COLUMN url_fotos TEXT COMMENT 'URLs de las imágenes separadas por comas';
```

### Opción alternativa: Tabla separada (recomendada)
Crear una tabla específica para las fotos permite mejor manejo y escalabilidad:

```sql
CREATE TABLE fotos_anuncios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_anuncio INT NOT NULL,
    url_foto VARCHAR(500) NOT NULL,
    orden INT DEFAULT 0 COMMENT 'Orden de visualización',
    es_portada BOOLEAN DEFAULT FALSE COMMENT 'Imagen principal del anuncio',
    fecha_subida TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_anuncio) REFERENCES anuncios(id) ON DELETE CASCADE,
    INDEX idx_anuncio (id_anuncio)
);
```

---

## 2. Estructura de Carpetas

Crear la siguiente estructura en el proyecto:

```
Agencia-publicidad/
├── uploads/
│   └── anuncios/
│       ├── thumbnails/     # Miniaturas para portada (200x200px)
│       ├── medium/          # Tamaño medio para listados (800x600px)
│       └── original/        # Imágenes originales (máx 1920x1080px)
```

### Comandos para crear las carpetas:
```bash
mkdir -p uploads/anuncios/thumbnails
mkdir -p uploads/anuncios/medium
mkdir -p uploads/anuncios/original
```

### Permisos necesarios:
```bash
chmod 755 uploads
chmod 755 uploads/anuncios
chmod 755 uploads/anuncios/thumbnails
chmod 755 uploads/anuncios/medium
chmod 755 uploads/anuncios/original
```

---

## 3. Configuración PHP

### Archivo: `config/upload_config.php`
```php
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
```

---

## 4. Clase Utilitaria para Manejo de Imágenes

### Archivo: `utils/ImageUploader.php`
```php
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
```

---

## 5. Modelo para Gestión de Fotos

### Archivo: `models/dataBase/FotosDB.php`
```php
<?php
namespace AgenciaPublicidad\Models\dataBase;

require_once __DIR__ . '/DBCon.php';

class FotosDB {
    
    /**
     * Guarda información de foto en la base de datos
     */
    public function guardarFoto($idAnuncio, $urlFoto, $orden = 0, $esPortada = false) {
        $pdo = DBCon::getConnection();
        $sql = $pdo->prepare("
            INSERT INTO fotos_anuncios (id_anuncio, url_foto, orden, es_portada)
            VALUES (:id_anuncio, :url_foto, :orden, :es_portada)
        ");
        
        $sql->bindValue(':id_anuncio', $idAnuncio, \PDO::PARAM_INT);
        $sql->bindValue(':url_foto', $urlFoto);
        $sql->bindValue(':orden', $orden, \PDO::PARAM_INT);
        $sql->bindValue(':es_portada', $esPortada, \PDO::PARAM_BOOL);
        
        return $sql->execute();
    }
    
    /**
     * Obtiene todas las fotos de un anuncio
     */
    public function getFotosByAnuncio($idAnuncio) {
        $pdo = DBCon::getConnection();
        $sql = $pdo->prepare("
            SELECT * FROM fotos_anuncios 
            WHERE id_anuncio = :id_anuncio 
            ORDER BY es_portada DESC, orden ASC
        ");
        $sql->bindValue(':id_anuncio', $idAnuncio, \PDO::PARAM_INT);
        $sql->execute();
        
        return $sql->fetchAll(\PDO::PARAM_ASSOC);
    }
    
    /**
     * Obtiene la foto de portada de un anuncio
     */
    public function getFotoPortada($idAnuncio) {
        $pdo = DBCon::getConnection();
        $sql = $pdo->prepare("
            SELECT * FROM fotos_anuncios 
            WHERE id_anuncio = :id_anuncio AND es_portada = TRUE
            LIMIT 1
        ");
        $sql->bindValue(':id_anuncio', $idAnuncio, \PDO::PARAM_INT);
        $sql->execute();
        
        return $sql->fetch(\PDO::FETCH_ASSOC);
    }
    
    /**
     * Elimina una foto
     */
    public function eliminarFoto($idFoto) {
        $pdo = DBCon::getConnection();
        
        // Primero obtener la URL para eliminar el archivo físico
        $sql = $pdo->prepare("SELECT url_foto FROM fotos_anuncios WHERE id = :id");
        $sql->bindValue(':id', $idFoto, \PDO::PARAM_INT);
        $sql->execute();
        $foto = $sql->fetch(\PDO::FETCH_ASSOC);
        
        if ($foto) {
            // Eliminar archivo físico
            \AgenciaPublicidad\Utils\ImageUploader::deleteImage(basename($foto['url_foto']));
            
            // Eliminar registro de BD
            $sqlDelete = $pdo->prepare("DELETE FROM fotos_anuncios WHERE id = :id");
            $sqlDelete->bindValue(':id', $idFoto, \PDO::PARAM_INT);
            return $sqlDelete->execute();
        }
        
        return false;
    }
}
```

---

## 6. Modificaciones en el Formulario HTML

### Archivo: `views/ads/ads.create.php`

Actualizar el formulario para permitir subida de imágenes:

```html
<form 
    action="index.php?controller=AdsController&accion=create" 
    method="post"
    enctype="multipart/form-data"
    id="formCrearAnuncio"
>
    <!-- ... campos existentes ... -->
    
    <p>
        <label for="fotos">Fotos del anuncio (máximo 5):</label>
        <input 
            type="file" 
            name="fotos[]" 
            id="fotos" 
            accept="image/jpeg,image/png,image/webp"
            multiple
        >
        <span class="help-text">Formatos: JPG, PNG, WEBP. Tamaño máximo: 5MB por imagen.</span>
        <span class="error"></span>
    </p>
    
    <!-- Vista previa de imágenes -->
    <div id="preview-container" class="preview-container"></div>
    
    <!-- Campo oculto para marcar cuál es la portada -->
    <input type="hidden" name="foto_portada" id="foto_portada" value="0">
    
    <!-- ... resto del formulario ... -->
</form>
```

### JavaScript para preview:

```javascript
// En js/create.js o archivo nuevo js/image-upload.js

document.getElementById('fotos').addEventListener('change', function(e) {
    const files = e.target.files;
    const previewContainer = document.getElementById('preview-container');
    previewContainer.innerHTML = '';
    
    if (files.length > 5) {
        alert('Máximo 5 imágenes permitidas');
        this.value = '';
        return;
    }
    
    Array.from(files).forEach((file, index) => {
        if (file.size > 5 * 1024 * 1024) {
            alert(`La imagen ${file.name} excede 5MB`);
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'preview-item';
            div.innerHTML = `
                <img src="${e.target.result}" alt="Preview ${index}">
                <button type="button" onclick="setAsPortada(${index})">
                    Usar como portada
                </button>
                <span class="portada-badge" style="display: ${index === 0 ? 'block' : 'none'}">
                    Portada
                </span>
            `;
            previewContainer.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
});

function setAsPortada(index) {
    document.getElementById('foto_portada').value = index;
    
    // Actualizar indicadores visuales
    document.querySelectorAll('.portada-badge').forEach((badge, i) => {
        badge.style.display = i === index ? 'block' : 'none';
    });
}
```

---

## 7. Modificaciones en el Controlador

### Archivo: `controllers/AdsController.php`

Actualizar el método `create()`:

```php
public function create() {
    // ... validaciones de autenticación existentes ...
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $titulo = $_POST['titulo'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';
        $fotoPortadaIndex = (int)($_POST['foto_portada'] ?? 0);
        
        // Validaciones...
        
        if (empty($errores)) {
            try {
                // Crear anuncio primero
                $anuncio = new Anuncio(
                    null,
                    $titulo,
                    null, // urlFotos se llenará después
                    $descripcion,
                    new \DateTime(),
                    null,
                    null
                );
                
                // Guardar anuncio y obtener ID
                $idAnuncio = $this->dbFunctions->create($anuncio);
                
                // Procesar imágenes si existen
                if (!empty($_FILES['fotos']['name'][0])) {
                    $fotosDB = new \AgenciaPublicidad\Models\dataBase\FotosDB();
                    $imageUploader = new \AgenciaPublicidad\Utils\ImageUploader();
                    
                    $totalFiles = count($_FILES['fotos']['name']);
                    
                    for ($i = 0; $i < $totalFiles; $i++) {
                        $file = [
                            'name' => $_FILES['fotos']['name'][$i],
                            'type' => $_FILES['fotos']['type'][$i],
                            'tmp_name' => $_FILES['fotos']['tmp_name'][$i],
                            'error' => $_FILES['fotos']['error'][$i],
                            'size' => $_FILES['fotos']['size'][$i]
                        ];
                        
                        $result = $imageUploader->uploadImage($file, $idAnuncio);
                        
                        if ($result['success']) {
                            $esPortada = ($i === $fotoPortadaIndex);
                            $fotosDB->guardarFoto(
                                $idAnuncio,
                                $result['data']['medium'],
                                $i,
                                $esPortada
                            );
                        }
                    }
                }
                
                echo "<script>alert('Anuncio creado con éxito'); window.location.href='index.php';</script>";
                
            } catch (\Exception $e) {
                error_log("Error creando anuncio: " . $e->getMessage());
                echo "<script>alert('ERROR: " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
            }
        }
    } else {
        include 'views/ads/ads.create.php';
    }
}
```

---

## 8. Mostrar Imágenes en las Vistas

### En la portada (`views/index.php`):

```php
<?php
$fotosDB = new \AgenciaPublicidad\Models\dataBase\FotosDB();
foreach($anuncios as $anuncio): 
    $fotoPortada = $fotosDB->getFotoPortada($anuncio['id']);
    $imagenUrl = $fotoPortada ? BASE_URL . '/' . $fotoPortada['url_foto'] : BASE_URL . '/img/logo.png';
?>
<div class="card-anuncio">
    <div class="div-tj-img">
        <img src="<?= $imagenUrl ?>" alt="<?= htmlspecialchars($anuncio['titulo']) ?>">
    </div>
    <h2><?= htmlspecialchars($anuncio['titulo']) ?></h2>
    <p><?= htmlspecialchars($anuncio['detalles'] ?? 'Sin detalles') ?></p>
</div>
<?php endforeach; ?>
```

### En la vista detallada del anuncio:

```php
<?php
$fotosDB = new \AgenciaPublicidad\Models\dataBase\FotosDB();
$fotos = $fotosDB->getFotosByAnuncio($anuncio->getId());
?>

<div class="galeria-anuncio">
    <?php if (!empty($fotos)): ?>
        <div class="foto-principal">
            <img src="<?= BASE_URL . '/' . $fotos[0]['url_foto'] ?>" alt="Foto principal">
        </div>
        
        <?php if (count($fotos) > 1): ?>
        <div class="fotos-miniatura">
            <?php foreach ($fotos as $foto): ?>
                <img 
                    src="<?= BASE_URL . '/uploads/anuncios/thumbnails/' . basename($foto['url_foto']) ?>" 
                    alt="Miniatura"
                    onclick="cambiarFotoPrincipal('<?= BASE_URL . '/' . $foto['url_foto'] ?>')"
                >
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    <?php else: ?>
        <img src="<?= BASE_URL ?>/img/logo.png" alt="Sin imagen">
    <?php endif; ?>
</div>

<script>
function cambiarFotoPrincipal(url) {
    document.querySelector('.foto-principal img').src = url;
}
</script>
```

---

## 9. Estilos CSS Recomendados

### Archivo: `css/ads.css` (añadir al final)

```css
/* Preview de imágenes en formulario */
.preview-container {
    display: flex;
    gap: 1em;
    flex-wrap: wrap;
    margin-top: 1em;
}

.preview-item {
    position: relative;
    width: 150px;
    border: 2px solid #154C7E;
    border-radius: 0.5em;
    padding: 0.5em;
}

.preview-item img {
    width: 100%;
    height: 150px;
    object-fit: cover;
    border-radius: 0.3em;
}

.preview-item button {
    width: 100%;
    margin-top: 0.5em;
    padding: 0.5em;
    background-color: #FFCDC1;
    border: 1px solid #154C7E;
    border-radius: 0.3em;
    cursor: pointer;
}

.preview-item button:hover {
    background-color: #F16849;
    color: white;
}

.portada-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: #F16849;
    color: white;
    padding: 0.3em 0.6em;
    border-radius: 0.3em;
    font-size: 0.8em;
    font-weight: bold;
}

.help-text {
    font-size: 0.9em;
    color: #666;
    margin-top: 0.3em;
}

/* Galería en vista de anuncio */
.galeria-anuncio {
    margin: 2em 0;
}

.foto-principal {
    width: 100%;
    max-width: 800px;
    margin: 0 auto 1em;
}

.foto-principal img {
    width: 100%;
    height: auto;
    border-radius: 0.5em;
    box-shadow: 6px 6px 0 #154C7E;
}

.fotos-miniatura {
    display: flex;
    gap: 0.5em;
    justify-content: center;
    flex-wrap: wrap;
}

.fotos-miniatura img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border: 2px solid #154C7E;
    border-radius: 0.3em;
    cursor: pointer;
    transition: transform 0.2s;
}

.fotos-miniatura img:hover {
    transform: scale(1.1);
}
```

---

## 10. Seguridad y Consideraciones

### Validaciones importantes:
1. ✅ Verificar extensión y MIME type
2. ✅ Limitar tamaño de archivo (5MB)
3. ✅ Limitar número de imágenes (5 por anuncio)
4. ✅ Generar nombres únicos para evitar sobrescritura
5. ✅ Sanitizar nombres de archivo
6. ✅ Verificar que el directorio de uploads existe

### Protección adicional:
```php
// En .htaccess dentro de /uploads/
<FilesMatch "\.(php|php3|php4|php5|phtml)$">
    Order Deny,Allow
    Deny from all
</FilesMatch>
```

### Limpieza de archivos huérfanos:
Crear un script de mantenimiento para eliminar imágenes sin anuncio asociado.

---

## 11. Checklist de Implementación

- [ ] Crear estructura de carpetas `/uploads/`
- [ ] Crear tabla `fotos_anuncios` en la base de datos
- [ ] Crear archivo `config/upload_config.php`
- [ ] Crear clase `utils/ImageUploader.php`
- [ ] Crear modelo `models/dataBase/FotosDB.php`
- [ ] Actualizar formulario HTML con `enctype="multipart/form-data"`
- [ ] Añadir input file con `multiple`
- [ ] Implementar preview JavaScript
- [ ] Actualizar método `create()` en `AdsController.php`
- [ ] Actualizar método `create()` en `AnunciosDB.php` para retornar ID
- [ ] Actualizar vista `index.php` para mostrar foto de portada
- [ ] Crear vista detallada del anuncio con galería
- [ ] Añadir estilos CSS para preview y galería
- [ ] Configurar `.htaccess` en `/uploads/` para seguridad
- [ ] Probar subida de imágenes
- [ ] Probar visualización en portada y detalle
- [ ] Implementar eliminación de imágenes al borrar anuncio

---

## 12. Notas Adicionales

- **Extensión GD**: Verificar que PHP tenga habilitada la extensión GD para procesamiento de imágenes
- **Límites PHP**: Revisar `php.ini` para ajustar `upload_max_filesize` y `post_max_size` si es necesario
- **Optimización**: Considerar convertir todas las imágenes a WebP para mejor rendimiento
- **CDN**: Para producción, considerar usar un CDN para servir las imágenes

---

¡Sigue estos pasos en orden y tendrás un sistema completo de subida y gestión de imágenes para tus anuncios! 🎨📸
