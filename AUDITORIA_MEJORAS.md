# 🛠️ Auditoría Crítica y Mejoras Aplicadas (Agencia-publicidad)

**Fecha:** 20 de octubre de 2025  
**Rama:** feat/style-add  
**Autor:** Análisis automatizado de código

---

## 🚨 CRÍTICAS Y URGENTES (Prioridad máxima)

### 1. **Validación y Seguridad en Backend**

**❌ Problema detectado:**  
En `controllers/OutController.php`, las contraseñas no están usando `password_hash()` correctamente y falta sanitización de inputs.

**Ubicación:**
```
controllers/OutController.php (líneas 48-115)
```

**✅ Solución:**
```php
// EN VEZ DE guardar $contrasena directamente:
$password_hash = password_hash($contrasena, PASSWORD_DEFAULT);

// Al verificar login (OutController::iniciarSesion):
if (password_verify($contrasenaInput, $usuario['password_hash'])) {
    // Login exitoso
}

// Sanitizar TODOS los inputs:
$nombre = htmlspecialchars(trim($_POST['nombre'] ?? ''), ENT_QUOTES, 'UTF-8');
$email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
```

**Prioridad:** 🔴 URGENTE  
**Impacto:** Seguridad crítica - contraseñas en texto plano, vulnerabilidad XSS

---

### 2. **Gestión de Sesiones - Lógica Duplicada**

**❌ Problema detectado:**  
La sesión se inicia múltiples veces en diferentes archivos:
- `controllers/OutController.php` (línea 27)
- `utils/auth_helper.php` (línea 8)
- Posiblemente en otros controladores

**Ubicación:**
```
controllers/OutController.php
utils/auth_helper.php
```

**✅ Solución:**
Centraliza la gestión de sesión creando funciones específicas en `utils/auth_helper.php`:

```php
<?php
namespace Agenciapublicidad\Utils;

use AgenciaPublicidad\Models\TipoPersonaEnum;

require_once __DIR__ . "/../models/TipoPersonaEnum.php";

// Iniciar sesión una sola vez
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Función para verificar si el usuario está logueado
function isLoggedIn(): bool {
    return !empty($_SESSION['usuario']);
}

// Función para verificar si es admin
function isAdmin(): bool {
    return isLoggedIn() && ($_SESSION['usuario']['tipo'] ?? '') === 'ADMINISTRADOR';
}

// Función para obtener usuario actual
function getCurrentUser(): ?array {
    if (!isLoggedIn()) {
        return null;
    }
    
    return [
        'id' => $_SESSION['usuario']['id'] ?? null,
        'email' => $_SESSION['usuario']['email'] ?? null,
        'nombre' => $_SESSION['usuario']['nombre'] ?? null,
        'apellido' => $_SESSION['usuario']['apellido'] ?? null,
        'tipo' => $_SESSION['usuario']['tipo'] ?? 'COMERCIANTE',
        'id_comerciante' => $_SESSION['usuario']['id_comerciante'] ?? null
    ];
}

// Variables globales para backward compatibility
$isLoggedIn = isLoggedIn();
$isAdmin = isAdmin();
$currentUser = getCurrentUser();
?>
```

**Luego en los controladores:**
```php
// NO hagas session_start() en los controladores
// Solo incluye el helper y usa las funciones

require_once __DIR__ . '/../utils/auth_helper.php';

if (!isAdmin()) {
    mostrarError403();
}
```

**Prioridad:** 🔴 URGENTE  
**Impacto:** Errores de sesión, inconsistencias en autenticación

---

### 3. **Rutas inconsistentes (mayúsculas/minúsculas)**

**❌ Problema detectado:**  
En `controllers/OutController.php` hay rutas con mayúsculas que fallarán en servidores Linux:

```php
// LÍNEAS 177, 182, 236, 239 (YA CORREGIDAS parcialmente)
include 'views/auth/register.php';  // ✅ BIEN
include 'views/auth/login.php';     // ✅ BIEN
```

**Verificar:**
- Busca TODAS las referencias a `Views/` con mayúscula en el proyecto
- Reemplázalas por `views/` (minúscula)

**✅ Solución:**
```bash
# Buscar y reemplazar en todo el proyecto
grep -r "Views/" .
# Reemplazar manualmente o con herramienta
```

**Prioridad:** 🔴 URGENTE  
**Impacto:** El código fallará en producción (Linux es case-sensitive)

---

### 4. **Acceso directo a vistas (sin Router)**

**❌ Problema detectado:**  
Es posible acceder directamente a archivos PHP en `views/`:
```
http://localhost/.../views/auth/register.php  ❌ INSEGURO
```

**Ubicación:**
```
views/auth/register.php
views/auth/login.php
views/index.php
```

**✅ Solución:**
Añade protección al inicio de TODAS las vistas:

```php
<?php
// Al inicio de cada archivo en views/
if (!defined('ACCESSED_VIA_ROUTER')) {
    http_response_code(403);
    die('Acceso directo no permitido');
}
?>
```

Y en el Router (`Router.php`):
```php
private static function loadController($controllerName, $action){
    define('ACCESSED_VIA_ROUTER', true);  // Añade esto
    
    $controllerFile = "./controllers/{$controllerName}.php";
    require_once $controllerFile;
    // ... resto del código
}
```

**Prioridad:** 🟠 ALTA  
**Impacto:** Seguridad - bypass de validaciones y autenticación

---

### 5. **Credenciales en código (config.php)**

**❌ Problema detectado:**  
En `config/config.php` las credenciales están hardcodeadas:

```php
define('HOST', 'wachiturros-do-user-18805607-0.m.db.ondigitalocean.com');
define('DB_NAME', 'marketplace');
define('USER', 'doadmin');
define('PASS', 'AVNS_T7F5ypei-vq0X2smLnX');  // ❌ PELIGROSO
```

**✅ Solución:**

1. Crea un archivo `.env` en la raíz del proyecto (FUERA del webroot si es posible):
```env
DB_HOST=wachiturros-do-user-18805607-0.m.db.ondigitalocean.com
DB_NAME=marketplace
DB_USER=doadmin
DB_PASS=AVNS_T7F5ypei-vq0X2smLnX
DB_PORT=25060
```

2. Añade `.env` al `.gitignore`:
```
.env
```

3. Modifica `config/config.php`:
```php
<?php
// Cargar variables de entorno (simple, sin librería)
if (file_exists(__DIR__ . '/../.env')) {
    $lines = file(__DIR__ . '/../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            putenv($line);
        }
    }
}

define('HOST', getenv('DB_HOST'));
define('DB_NAME', getenv('DB_NAME'));
define('USER', getenv('DB_USER'));
define('PASS', getenv('DB_PASS'));
?>
```

**Prioridad:** 🔴 URGENTE  
**Impacto:** Seguridad crítica - credenciales expuestas en repositorio público

---

## ⚡ MEJORAS IMPORTANTES (Prioridad alta)

### 6. **Comparación incorrecta de tipos (Enum vs String)**

**❌ Problema detectado:**  
En `utils/auth_helper.php` (línea 28) la comparación ya está CORREGIDA:

```php
$isAdmin = $currentUser['tipo'] === 'ADMINISTRADOR';  // ✅ CORRECTO
```

**Estado:** ✅ CORREGIDO (anteriormente usaba `TipoPersonaEnum::ADMINISTRADOR`)

---

### 7. **Falta sanitización consistente en todos los formularios**

**❌ Problema detectado:**  
En `controllers/OutController.php`, el método `store()` valida longitud y formato, pero no sanitiza consistentemente:

```php
// Línea 34-36
$nombre = $_POST['nombre'] ?? '';       // ❌ Sin sanitizar
$apellido = $_POST['apellido'] ?? '';   // ❌ Sin sanitizar
$email = $_POST['email'] ?? '';         // ❌ Sin sanitizar
```

**✅ Solución:**
```php
$nombre = htmlspecialchars(trim($_POST['nombre'] ?? ''), ENT_QUOTES, 'UTF-8');
$apellido = htmlspecialchars(trim($_POST['apellido'] ?? ''), ENT_QUOTES, 'UTF-8');
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
```

**Prioridad:** 🟠 ALTA  
**Impacto:** Vulnerabilidad XSS

---

### 8. **Labels ocultos en formularios (accesibilidad)**

**❌ Problema detectado:**  
En `css/auth.css` (línea 89-93):

```css
label {
  color: #154C7E;
  font-weight: 500;
  font-size: 1em;
  display: none; /* ❌ MALO para accesibilidad */
}
```

**✅ Solución:**
```css
label {
  color: #154C7E;
  font-weight: 500;
  font-size: 0.9em;
  display: block;  /* ✅ Visible */
  margin-bottom: 0.3em;
}
```

O usa `sr-only` para lectores de pantalla:
```css
.sr-only {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap;
  border-width: 0;
}
```

**Prioridad:** 🟡 MEDIA  
**Impacto:** Accesibilidad - usuarios con lectores de pantalla no pueden usar formularios

---

## 🧹 MEJORAS RECOMENDADAS (Prioridad media)

### 9. **Error constructor Comerciante**

**❌ Problema detectado:**  
En `controllers/OutController.php` (línea 168):

```php
$nuevoComerciante = new Comerciante(
    $nombre,
    $apellido,
    $email,
    $contrasena,
    // ... solo 12 argumentos
);
// Error: Expected 14 arguments. Found 12.
```

**✅ Solución:**
Revisa la clase `models/Comerciante.php` y ajusta los argumentos o el constructor.

**Prioridad:** 🟡 MEDIA  
**Impacto:** Error en tiempo de ejecución al registrar comerciantes

---

### 10. **Optimización de imágenes**

**❌ Problema detectado:**  
Las imágenes en `img/` no están optimizadas:
- logo.png
- logo2.png
- portada.png
- etc.

**✅ Solución:**
- Comprime con TinyPNG o herramientas similares
- Convierte a WebP para mejor rendimiento
- Añade lazy loading: `<img loading="lazy" ...>`

**Prioridad:** 🟡 MEDIA  
**Impacto:** Rendimiento - carga lenta de página

---

### 11. **CSS y JS sin minificar**

**❌ Problema detectado:**  
Archivos CSS/JS están sin minificar en producción.

**✅ Solución:**
```bash
# Minificar CSS
npx csso css/auth.css -o css/auth.min.css

# Minificar JS
npx terser js/validaciones.js -o js/validaciones.min.js
```

**Prioridad:** 🟢 BAJA  
**Impacto:** Rendimiento menor

---

## 🕒 MEJORAS MENORES (Prioridad baja)

### 12. **Documentación de endpoints**

**❌ Problema detectado:**  
Falta documentar los endpoints del Router en el README.

**✅ Solución:**
Añade sección al README:
```markdown
## Endpoints disponibles

### Autenticación
- `GET /index.php?controller=OutController&accion=iniciarSesion` - Mostrar formulario login
- `POST /index.php?controller=OutController&accion=iniciarSesion` - Procesar login
- `GET /index.php?controller=OutController&accion=logout` - Cerrar sesión

### Registro (solo admin)
- `GET /index.php?controller=OutController&accion=store` - Mostrar formulario registro
- `POST /index.php?controller=OutController&accion=store` - Procesar registro
```

**Prioridad:** 🟢 BAJA  
**Impacto:** Documentación

---

### 13. **Testing unitario**

**❌ Problema detectado:**  
No hay pruebas unitarias ni de integración.

**✅ Solución:**
Instala PHPUnit y crea tests para modelos y controladores.

**Prioridad:** 🟢 BAJA  
**Impacto:** Calidad de código a largo plazo

---

## ✅ RESUMEN DE ACCIONES INMEDIATAS

### Hacer AHORA (esta semana):
1. ✅ Corregir comparación Enum vs String en `auth_helper.php` - **YA HECHO**
2. 🔴 Implementar `password_hash()` y `password_verify()` en login/registro
3. 🔴 Sanitizar todos los inputs con `htmlspecialchars()` y `filter_var()`
4. 🔴 Mover credenciales a archivo `.env` y añadir al `.gitignore`
5. 🟠 Centralizar gestión de sesión en funciones helper
6. 🟠 Añadir protección contra acceso directo a vistas

### Hacer próximamente (este mes):
7. 🟡 Corregir constructor de `Comerciante`
8. 🟡 Hacer labels visibles o usar `sr-only`
9. 🟡 Optimizar imágenes y añadir lazy loading
10. 🟢 Documentar endpoints en README

---

## 📊 Métricas de Seguridad

| Aspecto | Estado Actual | Estado Objetivo |
|---------|---------------|-----------------|
| Contraseñas hasheadas | ❌ | ✅ |
| Inputs sanitizados | ⚠️ Parcial | ✅ |
| Credenciales seguras | ❌ | ✅ |
| Sesiones centralizadas | ⚠️ Duplicado | ✅ |
| Acceso a vistas protegido | ❌ | ✅ |
| Accesibilidad formularios | ⚠️ Parcial | ✅ |

---

**Última actualización:** 20 de octubre de 2025  
**Revisar nuevamente:** Al completar las mejoras críticas
