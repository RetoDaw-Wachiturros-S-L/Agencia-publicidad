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
