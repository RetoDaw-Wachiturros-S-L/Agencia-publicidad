CREATE DATABASE IF NOT EXISTS marketplace;
USE marketplace;

-- Tabla: usuarios (unificada)
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50),
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    fecha_inscripcion DATETIME DEFAULT CURRENT_TIMESTAMP,
    foto_perfil VARCHAR(255),
    tipo_usuario ENUM('ADMINISTRADOR', 'COMERCIANTE', 'VISITANTE') NOT NULL
);

-- Tabla: comerciantes (datos adicionales)
CREATE TABLE comerciantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    nombre_empresa VARCHAR(50) NOT NULL UNIQUE,
    nif_empresa VARCHAR(9) NOT NULL,
    comentario_empresa TEXT,
    num_telefono VARCHAR(20),
    comerciante_desde DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
        ON DELETE CASCADE
);

-- Tabla: anuncios (sin precio)
CREATE TABLE anuncios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_comerciante INT NOT NULL,
    titulo VARCHAR(150) NOT NULL,
    detalles TEXT,
    fecha_publicacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_comerciante) REFERENCES comerciantes(id)
        ON DELETE CASCADE
);

-- Tabla: fotos de anuncios
CREATE TABLE fotos_anuncios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_anuncio INT NOT NULL,
    url_foto VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_anuncio) REFERENCES anuncios(id)
        ON DELETE CASCADE
);

-- Tabla: categorías (tags)
CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) UNIQUE NOT NULL
);

-- Tabla: relación N:M entre anuncios y categorías
CREATE TABLE anuncios_categorias (
    id_anuncio INT NOT NULL,
    id_categoria INT NOT NULL,
    PRIMARY KEY (id_anuncio, id_categoria),
    FOREIGN KEY (id_anuncio) REFERENCES anuncios(id)
        ON DELETE CASCADE,
    FOREIGN KEY (id_categoria) REFERENCES categorias(id)
        ON DELETE CASCADE
);

-- Tabla: favoritos
CREATE TABLE favoritos (
    id_usuario INT NOT NULL,
    id_anuncio INT NOT NULL,
    fecha_guardado DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id_usuario, id_anuncio),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
        ON DELETE CASCADE,
    FOREIGN KEY (id_anuncio) REFERENCES anuncios(id)
        ON DELETE CASCADE
);

-- Tabla: conversaciones
CREATE TABLE conversaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_anuncio INT NOT NULL,
    id_visitante INT NOT NULL,
    id_comerciante INT NOT NULL,
    fecha_inicio DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_anuncio) REFERENCES anuncios(id)
        ON DELETE CASCADE,
    FOREIGN KEY (id_visitante) REFERENCES usuarios(id)
        ON DELETE CASCADE,
    FOREIGN KEY (id_comerciante) REFERENCES comerciantes(id)
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
        ON DELETE CASCADE,
    FOREIGN KEY (id_emisor) REFERENCES usuarios(id)
        ON DELETE CASCADE
);

-- Índices recomendados
CREATE INDEX idx_anuncios_comerciante ON anuncios(id_comerciante);
CREATE INDEX idx_mensajes_conversacion ON mensajes(id_conversacion);
CREATE INDEX idx_conversaciones_anuncio ON conversaciones(id_anuncio);
CREATE INDEX idx_anuncios_categoria ON anuncios_categorias(id_categoria);
