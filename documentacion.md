<style>
/* Estilos CSS para exportar a PDF */
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap');

body {
  font-family: 'DM Sans', sans-serif;
  color: #101828;
  line-height: 1.6;
  max-width: 21cm;
  margin: 0 auto;
  padding: 2cm;
  background-color: #FFF5E6;
}

h1 {
  color: #154C7E;
  font-size: 28pt;
  font-weight: 700;
  margin-bottom: 10px;
  border-bottom: 3px solid #154C7E;
  padding-bottom: 10px;
}

h2 {
  color: #154C7E;
  font-size: 20pt;
  font-weight: 700;
  margin-top: 30px;
  margin-bottom: 15px;
}

h3 {
  color: #101828;
  font-size: 16pt;
  font-weight: 600;
  margin-top: 20px;
  margin-bottom: 10px;
}

h4 {
  color: #154C7E;
  font-size: 14pt;
  font-weight: 600;
  margin-top: 15px;
  margin-bottom: 8px;
}

.portada {
  background-color: #FFF5E6;
  padding: 60px 40px;
  text-align: center;
  border: 3px solid #154C7E;
  margin-bottom: 40px;
}

.portada h1 {
  border: none;
  margin-bottom: 5px;
}

.portada .subtitulo {
  color: #154C7E;
  font-size: 18pt;
  font-weight: 500;
  margin-bottom: 40px;
}

.portada .info {
  background-color: white;
  padding: 20px;
  border-radius: 8px;
  margin-top: 30px;
  text-align: left;
}

.linea-separador {
  height: 3px;
  background-color: #154C7E;
  margin: 20px 0;
}

.linea-secundaria {
  height: 2px;
  background-color: #FFCDC1;
  margin: 15px 0;
}

.caja-info {
  background-color: #FFCDC1;
  padding: 15px 20px;
  border-left: 4px solid #F16849;
  margin: 20px 0;
}

.caja-importante {
  background-color: #FFF5E6;
  padding: 15px 20px;
  border: 2px solid #154C7E;
  margin: 20px 0;
}

.destaque {
  color: #F16849;
  font-weight: 600;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin: 20px 0;
}

th {
  background-color: #154C7E;
  color: white;
  padding: 12px;
  text-align: left;
  font-weight: 600;
}

td {
  padding: 10px 12px;
  border-bottom: 1px solid #FFCDC1;
}

tr:nth-child(even) {
  background-color: #FFF5E6;
}

ul, ol {
  margin-left: 20px;
}

li {
  margin-bottom: 8px;
}

code {
  background-color: #FFF5E6;
  padding: 2px 6px;
  border-radius: 3px;
  font-family: 'Courier New', monospace;
  color: #154C7E;
}

pre {
  background-color: #101828;
  color: #FFF5E6;
  padding: 15px;
  border-radius: 5px;
  overflow-x: auto;
  border-left: 4px solid #154C7E;
}

blockquote {
  border-left: 4px solid #F16849;
  padding-left: 20px;
  margin-left: 0;
  color: #101828;
  font-style: italic;
}

.salto-pagina {
  page-break-after: always;
}
</style>

<div class="portada">

# 📱 Agencia de Publicidad Digital

<div class="subtitulo">Asociación de Comerciantes de Vitoria</div>

<div class="info">

**Proyecto:** Plataforma Web de Anuncios Gratuitos  
**Cliente:** Asociación de Comerciantes de Vitoria  
**Equipo:** Wachiturros S.L.

**Integrantes:**
- David Gonzalez
- Dani Tomicic
- Koldo Soriguren

**Curso:** CFGS - Desarrollo de Aplicaciones Web  
**Fecha:** Octubre 2025  
**Versión:** 1.0

</div>

</div>

<div class="linea-separador"></div>

## 📋 Índice de Contenidos

1. **Análisis de Requerimientos**
   - a. Requerimientos del proyecto (historias de usuario)
   - b. Planificación (diagrama de Gantt)

2. **Diseño de la Solución**
   - a. Diseño de la Base de Datos
   - b. Diagrama de Arquitectura
   - c. Guía de Estilos
   - d. Diseño de Interfaces
   - e. Diagramas de Navegación

3. **Desarrollo de la Solución**

4. **Manual de Despliegue**

5. **Manual de Usuario**

<div class="linea-separador"></div>
<div class="salto-pagina"></div>

# 1. Análisis de Requerimientos

<div class="linea-secundaria"></div>

## 1.a. Requerimientos del Proyecto (Historias de Usuario)

### Contexto del Proyecto

[Aquí escribe el contexto]

<div class="caja-info">

**💡 Nota importante:** [Añade notas relevantes aquí]

</div>

### Épicas

#### Épica 1: [Nombre de la Épica]

[Descripción de la épica]

<div class="linea-secundaria"></div>

### Historias de Usuario

#### HU-001: [Título de la Historia]

- **Como** [rol]
- **Quiero** [funcionalidad]
- **Para** [beneficio/objetivo]

**Criterios de aceptación:**
- [ ] Criterio 1
- [ ] Criterio 2
- [ ] Criterio 3

**Prioridad:** <span class="destaque">[Alta/Media/Baja]</span>  
**Estimación:** [X] puntos

<div class="linea-secundaria"></div>

#### HU-002: [Título de la Historia]

- **Como** [rol]
- **Quiero** [funcionalidad]
- **Para** [beneficio/objetivo]

**Criterios de aceptación:**
- [ ] Criterio 1
- [ ] Criterio 2
- [ ] Criterio 3

**Prioridad:** <span class="destaque">[Alta/Media/Baja]</span>  
**Estimación:** [X] puntos

<div class="linea-secundaria"></div>

[Continúa añadiendo más historias de usuario...]

---

## 1.b. Planificación (Diagrama de Gantt)

### Cronograma del Proyecto

**Duración total:** 39 días (8 semanas)  
**Inicio:** 8 de septiembre 2025  
**Entrega:** 30 de octubre 2025

### Diagrama de Gantt

[Inserta aquí tu diagrama de Gantt - Puedes usar imagen o tabla]

### Hitos Importantes

| Fecha | Hito | Estado |
|-------|------|--------|
| [DD/MM] | [Descripción del hito] | ✅ / ⏳ / ❌ |
| [DD/MM] | [Descripción del hito] | ✅ / ⏳ / ❌ |
| [DD/MM] | [Descripción del hito] | ✅ / ⏳ / ❌ |

<div class="caja-importante">

**⚠️ Notas sobre la planificación:**

[Añade aquí observaciones importantes sobre la planificación]

</div>

<div class="linea-separador"></div>
<div class="salto-pagina"></div>

# 2. Diseño de la Solución

<div class="linea-secundaria"></div>

## 2.a. Diseño de la Base de Datos

### Modelo Entidad-Relación

[Inserta aquí el diagrama ER]

### Descripción de Entidades

#### Tabla: [NOMBRE_TABLA]

| Campo | Tipo | Restricciones | Descripción |
|-------|------|---------------|-------------|
| [campo1] | [tipo] | [PK/FK/NOT NULL] | [descripción] |
| [campo2] | [tipo] | [restricción] | [descripción] |

### Relaciones

- [Tabla A] (cardinalidad) ——→ (cardinalidad) [Tabla B]: [Descripción de la relación]

### Script SQL

```sql
CREATE DATABASE IF NOT EXISTS marketplace;
USE marketplace;

-- Tabla: comerciantes (vendedores)
CREATE TABLE comerciantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_empresa VARCHAR(50) NOT NULL UNIQUE,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(100),
    password_hash VARCHAR(255) NOT NULL,
    fecha_inscripcion DATETIME DEFAULT CURRENT_TIMESTAMP,
    num_telefono VARCHAR(20),
    email VARCHAR(100) UNIQUE,
    foto_perfil VARCHAR(255)
);

-- Tabla: visitantes (compradores)
CREATE TABLE visitantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    fecha_alta DATETIME DEFAULT CURRENT_TIMESTAMP,
    num_telefono VARCHAR(9),
    email VARCHAR(100) UNIQUE,
    foto_perfil VARCHAR(255)
);

-- Tabla: anuncios
CREATE TABLE anuncios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_prod VARCHAR(150) NOT NULL,
    foto_principal VARCHAR(255),
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    fecha_publicacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    id_vendedor INT NOT NULL,
    categoria VARCHAR(100),
    FOREIGN KEY (id_vendedor) REFERENCES comerciantes(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- Tabla: favoritos
CREATE TABLE favoritos (
    id_usuario INT,
    id_anuncio INT,
    fecha_guardado DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id_usuario, id_anuncio),
    FOREIGN KEY (id_usuario) REFERENCES visitantes(id)
        ON DELETE CASCADE,
    FOREIGN KEY (id_anuncio) REFERENCES anuncios(id)
        ON DELETE CASCADE
);

-- Tabla: conversaciones
CREATE TABLE conversaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_anuncio INT NOT NULL,
    id_visitante INT NOT NULL,
    id_vendedor INT NOT NULL,
    fecha_inicio DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_anuncio) REFERENCES anuncios(id)
        ON DELETE CASCADE,
    FOREIGN KEY (id_visitante) REFERENCES visitantes(id)
        ON DELETE CASCADE,
    FOREIGN KEY (id_vendedor) REFERENCES comerciantes(id)
        ON DELETE CASCADE
);

-- Tabla: mensajes
CREATE TABLE mensajes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_conversacion INT NOT NULL,
    id_emisor INT NOT NULL,
    contenido TEXT NOT NULL,
    fecha_envio DATETIME DEFAULT CURRENT_TIMESTAMP,
    visto BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (id_conversacion) REFERENCES conversaciones(id)
        ON DELETE CASCADE
    -- FOREIGN KEY (id_emisor) se omite por ambigüedad entre visitante y comerciante
);

-- Índices recomendados
CREATE INDEX idx_anuncios_vendedor ON anuncios(id_vendedor);
CREATE INDEX idx_mensajes_conversacion ON mensajes(id_conversacion);
CREATE INDEX idx_conversaciones_anuncio ON conversaciones(id_anuncio);
```

<div class="linea-secundaria"></div>

## 2.b. Diagrama de Arquitectura

### Arquitectura General del Sistema

[Inserta aquí el diagrama de arquitectura]

### Descripción de Capas

#### Capa de Presentación
[Descripción]

#### Capa de Lógica de Negocio
[Descripción]

#### Capa de Datos
[Descripción]

### Stack Tecnológico

| Componente | Tecnología | Versión |
|------------|------------|---------|
| Frontend | CCS3, JS | [versión] |
| Backend | PHP | [versión] |
| Base de Datos | MYSQL | [versión] |
| Servidor Web | APACHE2 | [versión] |

<div class="linea-secundaria"></div>

## 2.c. Guía de Estilos

### Paleta de Colores

#### Modo Claro

| Color | Código | Uso |
|-------|--------|-----|
| **Principal** | `#FFF5E6` | Fondo principal |
| **Secundario** | `#154C7E` | Textos principales, botones |
| **Acento 1** | `#FFCDC1` | Elementos destacados |
| **Acento 2** | `#F16849` | Llamadas a la acción |

#### Modo Oscuro

| Color | Código | Uso |
|-------|--------|-----|
| **Principal** | `#101828` | Fondo principal |
| **Secundario** | `#FFCF70` | Textos principales |
| **Acento 1** | `#02304D` | Elementos destacados |
| **Acento 2** | `#4A32A8` | Llamadas a la acción |

### Tipografía

- **Fuente principal:** DM Sans
- **Títulos:** DM Sans Bold (700)
- **Subtítulos:** DM Sans SemiBold (600)
- **Texto normal:** DM Sans Regular (400)

### Componentes

[Describe los componentes de tu interfaz: botones, formularios, tarjetas, etc.]

<div class="linea-secundaria"></div>

## 2.d. Diseño de Interfaces

### Wireframes

[Inserta aquí los wireframes de baja fidelidad]

### Mockups

#### Pantalla: [Nombre de la Pantalla]

[Inserta imagen del mockup]

**Descripción:**
[Describe los elementos principales de la interfaz]

**Elementos principales:**
- [Elemento 1]
- [Elemento 2]
- [Elemento 3]

<div class="linea-secundaria"></div>

## 2.e. Diagramas de Navegación

### Flujo de Navegación Principal

[Inserta aquí el diagrama de navegación]

### Descripción de Flujos

#### Flujo 1: [Nombre del Flujo]

1. [Paso 1]
2. [Paso 2]
3. [Paso 3]

<div class="linea-separador"></div>
<div class="salto-pagina"></div>

# 3. Desarrollo de la Solución

<div class="linea-secundaria"></div>

## 3.1. Estructura del Proyecto

```
├── 📁 Views
│   ├── 📁 auth
│   │   ├── 🐘 login.php
│   │   └── 🐘 register.php
│   ├── 🐘 index.php
│   ├── 🐘 index2.php
│   └── 🐘 portada.php
├── 📁 config
│   └── 🐘 config.php
├── 📁 controllers
│   ├── 🐘 AdsController.php
│   ├── 🐘 OutController.php
│   └── 🐘 mainController.php
├── 📁 css
│   ├── 🎨 index.css
│   ├── 🎨 layout.css
│   ├── 🎨 login.css
│   └── 🎨 portada.css
├── 📁 img
│   ├── 🖼️ lampara.png
│   ├── 🖼️ login.png
│   ├── 🖼️ logo.png
│   ├── 🖼️ logo2.png
│   ├── 🖼️ logo_SSombra.png
│   ├── 🖼️ lupa.png
│   └── 🖼️ portada.png
├── 📁 js
│   ├── 📄 index.js
│   ├── 📄 login.js
│   ├── 📄 register.js
│   └── 📄 validaciones.js
├── 📁 models
│   ├── 📁 dataBase
│   │   ├── 🐘 AnunciosDB.php
│   │   ├── 🐘 DBCon.php
│   │   ├── 🐘 DBFunctions.php
│   │   ├── 🐘 DBUser.php
│   │   └── 📄 ca-certificate.crt
│   ├── 🐘 Anuncio.php
│   ├── 🐘 Comerciante.php
│   ├── 🐘 TipoPersonaEnum.php
│   └── 🐘 UsuarioRegistrado.php
├── 📁 script
│   └── 📄 script.sql
├── 📁 utils
│   └── 🐘 auth_helper.php
├── 🐘 Router.php
└── 🐘 index.php
```

## 3.2. Desarrollo del Backend

### [Módulo/Funcionalidad 1]

**Descripción:**
[Explica qué hace este módulo]

**Código relevante:**

```javascript
// Aquí va tu código con comentarios explicativos
function ejemplo() {
  // Comentario explicando la lógica
}
```

**Explicación:**
[Explica las partes importantes del código]

<div class="caja-info">

**💡 Decisión técnica:** [Explica por qué tomaste ciertas decisiones]

</div>

<div class="linea-secundaria"></div>

## 3.3. Desarrollo del Frontend

### [Componente/Funcionalidad 1]

**Descripción:**
[Explica qué hace este componente]

**Código relevante:**

```html
<!-- Aquí va tu código HTML/CSS/JS -->
```

**Explicación:**
[Explica las partes importantes del código]

<div class="linea-secundaria"></div>

## 3.4. Integración y Testing

### Pruebas Realizadas

| Prueba | Tipo | Resultado | Observaciones |
|--------|------|-----------|---------------|
| [Nombre] | [Unitaria/Integración] | ✅ / ❌ | [Notas] |

<div class="linea-separador"></div>
<div class="salto-pagina"></div>

# 4. Manual de Despliegue

<div class="linea-secundaria"></div>

## 4.1. Requisitos Previos

### Software Necesario

- [Software 1] - Versión [X.X]
- [Software 2] - Versión [X.X]
- [Software 3] - Versión [X.X]

### Configuración del Servidor

[Describe la configuración necesaria]

<div class="linea-secundaria"></div>

## 4.2. Pasos de Instalación

### Paso 1: [Título del Paso]

```bash
# Comandos a ejecutar
```

**Explicación:**
[Explica qué hace este paso]

### Paso 2: [Título del Paso]

```bash
# Comandos a ejecutar
```

**Explicación:**
[Explica qué hace este paso]

<div class="caja-importante">

**⚠️ Importante:** [Notas críticas sobre el despliegue]

</div>

<div class="linea-secundaria"></div>

## 4.3. Configuración de la Base de Datos

### Creación de la Base de Datos

```sql
-- Script SQL
```

### Configuración de Conexión

```
HOST: [host]
PORT: [puerto]
DATABASE: [nombre_bd]
USER: [usuario]
PASSWORD: [contraseña]
```

<div class="linea-secundaria"></div>

## 4.4. Verificación del Despliegue

### Checklist de Verificación

- [ ] Servidor web funcionando correctamente
- [ ] Base de datos accesible
- [ ] Aplicación accesible desde navegador
- [ ] Todas las funcionalidades operativas
- [ ] Logs sin errores críticos

<div class="linea-separador"></div>
<div class="salto-pagina"></div>

# 5. Manual de Usuario

<div class="linea-secundaria"></div>

## 5.1. Introducción

### ¿Qué es [Nombre de la Aplicación]?

[Descripción breve de la aplicación]

### ¿A quién va dirigida?

[Describe el público objetivo]

<div class="linea-secundaria"></div>

## 5.2. Primeros Pasos

### Registro de Usuario

1. [Paso 1]
2. [Paso 2]
3. [Paso 3]

[Inserta capturas de pantalla]

### Inicio de Sesión

1. [Paso 1]
2. [Paso 2]

[Inserta capturas de pantalla]

<div class="linea-secundaria"></div>

## 5.3. Funcionalidades Principales

### [Funcionalidad 1]

**¿Cómo usar esta funcionalidad?**

1. [Paso 1]
2. [Paso 2]
3. [Paso 3]

[Inserta capturas de pantalla con anotaciones]

<div class="caja-info">

**💡 Consejo:** [Añade consejos útiles para el usuario]

</div>

### [Funcionalidad 2]

**¿Cómo usar esta funcionalidad?**

1. [Paso 1]
2. [Paso 2]
3. [Paso 3]

<div class="linea-secundaria"></div>

## 5.4. Preguntas Frecuentes (FAQ)

### ¿[Pregunta 1]?

[Respuesta]

### ¿[Pregunta 2]?

[Respuesta]

<div class="linea-secundaria"></div>

## 5.5. Soporte y Contacto

**Email:** [email de contacto]  
**Teléfono:** [teléfono]  
**Horario de atención:** [horario]

<div class="linea-separador"></div>

---

<div style="text-align: center; color: #154C7E; margin-top: 40px;">

**Documento generado el** [Fecha]  
**Versión** 1.0  
© 2025 - Todos los derechos reservados

</div>