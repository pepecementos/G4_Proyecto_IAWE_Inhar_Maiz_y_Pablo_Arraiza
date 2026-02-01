-- =====================================================
-- Base de datos: AnimeXAI
-- Proyecto: AnimeXAI
-- Motor: MySQL / MariaDB
-- =====================================================

DROP DATABASE IF EXISTS AnimeXAI;
CREATE DATABASE AnimeXAI
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE AnimeXAI;

-- =====================================================
-- TABLA: usuarios
-- =====================================================
CREATE TABLE usuarios (
  id_usuario INT AUTO_INCREMENT PRIMARY KEY,
  nombre_usuario VARCHAR(50) NOT NULL UNIQUE,
  contrasena VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

-- =====================================================
-- TABLA: productos
-- =====================================================
CREATE TABLE productos (
  id_producto INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  descripcion TEXT,
  UNIQUE (nombre)
) ENGINE=InnoDB;

-- =====================================================
-- TABLA: obras (anime / manga)
-- =====================================================
CREATE TABLE obras (
  id_obra INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(150) NOT NULL,
  sinopsis TEXT,
  tipo ENUM('anime','manga') NOT NULL,
  UNIQUE (titulo)
) ENGINE=InnoDB;

-- =====================================================
-- TABLA: capitulos
-- (entidad débil de obras)
-- =====================================================
CREATE TABLE capitulos (
  id_obra INT NOT NULL,
  num_capitulo INT NOT NULL,
  titulo VARCHAR(200) NOT NULL,
  media_valoracion DECIMAL(3,2),
  PRIMARY KEY (id_obra, num_capitulo),
  FOREIGN KEY (id_obra) REFERENCES obras(id_obra)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB;

-- =====================================================
-- TABLA: usuarios_desean_productos
-- =====================================================
CREATE TABLE usuarios_desean_productos (
  id_usuario INT NOT NULL,
  id_producto INT NOT NULL,
  PRIMARY KEY (id_usuario, id_producto),
  FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB;

-- =====================================================
-- TABLA: usuarios_gustan_obras
-- =====================================================
CREATE TABLE usuarios_gustan_obras (
  id_usuario INT NOT NULL,
  id_obra INT NOT NULL,
  PRIMARY KEY (id_usuario, id_obra),
  FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  FOREIGN KEY (id_obra) REFERENCES obras(id_obra)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB;

-- =====================================================
-- TABLA: usuarios_ven_capitulos
-- =====================================================
CREATE TABLE usuarios_ven_capitulos (
  id_usuario INT NOT NULL,
  id_obra INT NOT NULL,
  num_capitulo INT NOT NULL,
  visto_en DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id_usuario, id_obra, num_capitulo),
  FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  FOREIGN KEY (id_obra, num_capitulo)
    REFERENCES capitulos(id_obra, num_capitulo)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB;

-- =====================================================
-- TABLA: usuarios_valoran_capitulos
-- =====================================================
CREATE TABLE usuarios_valoran_capitulos (
  id_usuario INT NOT NULL,
  id_obra INT NOT NULL,
  num_capitulo INT NOT NULL,
  puntuacion TINYINT NOT NULL,
  PRIMARY KEY (id_usuario, id_obra, num_capitulo),
  FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  FOREIGN KEY (id_obra, num_capitulo)
    REFERENCES capitulos(id_obra, num_capitulo)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB;

-- =====================================================
-- DATOS DE EJEMPLO
-- =====================================================

-- USUARIOS
INSERT INTO usuarios (nombre_usuario, contrasena) VALUES
('alex', 'alex123'),
('maria', 'maria123'),
('dani', 'dani123');

-- PRODUCTOS
INSERT INTO productos (nombre, descripcion) VALUES
('Figura Jujutsu', 'Figura coleccionable de Jujutsu Kaisen'),
('Sudadera One Piece', 'Sudadera temática de One Piece'),
('Poster Frieren', 'Poster tamaño A2 de Frieren'),
('Manga Chainsaw Man 1', 'Tomo 1 físico de Chainsaw Man');

-- OBRAS
INSERT INTO obras (titulo, sinopsis, tipo) VALUES
('Jujutsu Kaisen', 'Hechiceros luchan contra maldiciones.', 'anime'),
('Frieren', 'Una elfa revive el viaje tras la aventura.', 'anime'),
('Chainsaw Man', 'Un chico con poderes demoníacos pelea por sobrevivir.', 'manga'),
('One Piece', 'Piratas buscan el gran tesoro.', 'anime'),
('Neon Genesis Evangelion', 'Adolescentes pilotan EVAs contra los Ángeles.', 'anime');

-- CAPITULOS
INSERT INTO capitulos (id_obra, num_capitulo, titulo, media_valoracion) VALUES
(1, 1, 'Ryomen Sukuna', 8.70),
(1, 2, 'Por mí', 8.40),
(2, 1, 'El final del viaje', 9.10),
(2, 2, 'El mago de la corte', 8.95),
(3, 1, 'Dog & Chainsaw', 8.80),
(3, 2, 'Llegada a la ciudad', 8.60),
(4, 1, 'Romance Dawn', 9.00),
(4, 2, 'El hombre del sombrero de paja', 8.85),
(5, 1, 'El ataque del Ángel', 9.20),
(5, 2, 'La bestia', 9.10),
(5, 3, 'Un teléfono que no suena', 8.90);

-- USUARIOS GUSTAN OBRAS
INSERT INTO usuarios_gustan_obras (id_usuario, id_obra) VALUES
(1, 1),
(1, 2),
(2, 2),
(2, 3),
(3, 4),
(1, 5),
(2, 5);

-- USUARIOS VEN CAPITULOS
INSERT INTO usuarios_ven_capitulos (id_usuario, id_obra, num_capitulo) VALUES
(1, 1, 1),
(1, 1, 2),
(1, 2, 1),
(2, 2, 1),
(2, 3, 1),
(3, 4, 1),
(3, 4, 2),
(1, 5, 1),
(1, 5, 2),
(2, 5, 1),
(3, 5, 1);

-- USUARIOS VALORAN CAPITULOS
INSERT INTO usuarios_valoran_capitulos (id_usuario, id_obra, num_capitulo, puntuacion) VALUES
(1, 1, 1, 9),
(1, 2, 1, 10),
(2, 2, 1, 9),
(2, 3, 1, 8),
(3, 4, 1, 10),
(3, 4, 2, 9),
(1, 5, 1, 10),
(1, 5, 2, 9),
(2, 5, 1, 9),
(3, 5, 1, 10);

-- USUARIOS DESEAN PRODUCTOS
INSERT INTO usuarios_desean_productos (id_usuario, id_producto) VALUES
(1, 1),
(1, 3),
(2, 4),
(3, 2);