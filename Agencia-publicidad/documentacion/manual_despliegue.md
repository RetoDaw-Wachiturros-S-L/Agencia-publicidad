# Manual de Despliegue

Este manual describe los pasos necesarios para desplegar el proyecto Agencia-publicidad en un entorno local o de producción.

## Requisitos previos
- Servidor web compatible (recomendado: Apache o Nginx)
- PHP >= 7.4
- MySQL o MariaDB
- Acceso al repositorio del proyecto

## 1. Clonar el repositorio
Clona el repositorio en el directorio deseado:
```bash
# Usando Git
git clone https://github.com/RetoDaw-Wachiturros-S-L/Agencia-publicidad.git
```

## 2. Configurar el entorno
Crea un archivo .env en el que definas las credenciales de la base de datos de la siguiente manera:

```
DB_HOST=(TU IP)
DB_NAME=(NOMBRE DE LA BASE DE DATOS)
DB_USER=(USUARIO DE LA BASE DE DATOS)
DB_PASS=(CONTRASEÑA DE LA BASE DE DATOS)
DB_PORT=(PUERTO DE LA BASE DE DATOS)
```

## 3. Crear la base de datos
- Crea una base de datos en MySQL/MariaDB.
- Ejecuta el script SQL para crear las tablas y datos iniciales:
```bash
mysql -u usuario -p nombre_bd < script/script.sql
```

## 4. Configurar permisos de carpetas
Asegúrate de que las carpetas de subida (`uploads/`) tengan permisos de escritura para el servidor web.

## 5. Configurar el servidor web
- Apunta el DocumentRoot a la carpeta principal del proyecto.
- Configura las reglas de reescritura si usas URLs amigables (mod_rewrite en Apache).

## 6. Comprobar configuración PHP
- Verifica que las extensiones necesarias estén habilitadas (pdo_mysql, fileinfo, etc).
- Revisa el límite de subida de archivos en `php.ini` si se van a subir imágenes grandes. (Nuestro proyecto usa max 5MB)

## 7. Acceder a la aplicación
Abre el navegador y accede a la URL configurada (por ejemplo, `http://localhost/Agencia-publicidad`).

## 9. Despliegue en producción
- Repite los pasos anteriores en el servidor de producción.
- Usa HTTPS y configura correctamente los permisos y la seguridad.
- No subas el archivo `.env` ni carpetas sensibles al repositorio.

## 10. Solución de problemas
- Revisa los logs de PHP y del servidor web ante cualquier error.
- Comprueba la configuración de la base de datos y las rutas.
- Verifica los permisos de carpetas y archivos.

---
Este manual cubre los pasos básicos para desplegar el proyecto. Si tienes necesidades específicas (Docker, CI/CD, etc.), adapta los pasos según tu entorno.

Recordamos que este proyecto ha sido desarrollado en Windows y puede ser que cause errores en producción si se despliega en un sistema Linux.
