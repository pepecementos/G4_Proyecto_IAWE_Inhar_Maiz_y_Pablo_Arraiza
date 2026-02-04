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
  contrasena VARCHAR(255) NOT NULL,
  email VARCHAR(100) DEFAULT NULL
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

-- =====================================================
-- NUEVAS OBRAS (animes y mangas usados en las vistas estáticas)
-- =====================================================
INSERT INTO obras (titulo, sinopsis, tipo) VALUES
('Attack on Titan', 'Humanos luchan por sobrevivir a los titanes', 'anime'),
('Demon Slayer', 'Un joven cazador de demonios busca salvar a su hermana', 'anime'),
('Spy x Family', 'Una familia con secretos que protege la paz', 'anime'),
('Fullmetal Alchemist: Brotherhood', 'Dos hermanos alquimistas buscan recuperar lo perdido', 'anime'),
('My Hero Academia', 'Jóvenes con poderes aspiran a ser héroes', 'anime'),
('Steins;Gate', 'Un grupo descubre cómo alterar el tiempo', 'anime'),
('Berserk', 'Espada, destino y venganza en un mundo oscuro', 'manga'),
('One Punch Man', 'Un héroe que derrota a cualquiera con un golpe', 'manga'),
('Vinland Saga', 'Vikingos, venganza y redención', 'manga'),
('Haikyuu!!', 'Vóley escolar y rivalidad deportiva', 'manga'),
('Death Note', 'Un cuaderno que cambia el destino de las personas', 'manga'),
('Tokyo Revengers', 'Viajes en el tiempo y pandillas juveniles', 'manga'),
('Blue Lock', 'Competencia extrema para crear al delantero perfecto', 'manga'),
('Oshi no Ko', 'Drama en la industria del entretenimiento', 'manga');

-- Añadir capítulos de ejemplo para las nuevas obras (subconsultas para id_obra)
INSERT INTO capitulos (id_obra, num_capitulo, titulo, media_valoracion) VALUES
((SELECT id_obra FROM obras WHERE titulo='Attack on Titan'), 1, 'To You, in 2000 Years: The Fall of Shiganshina, Part 1', 9.10),
((SELECT id_obra FROM obras WHERE titulo='Attack on Titan'), 2, 'That Day: The Fall of Shiganshina, Part 2', 9.05),
((SELECT id_obra FROM obras WHERE titulo='Attack on Titan'), 3, 'A Dim Light Amid Despair: Humanity’s Comeback', 9.00),

((SELECT id_obra FROM obras WHERE titulo='Demon Slayer'), 1, 'Crueldad y sangre', 8.70),
((SELECT id_obra FROM obras WHERE titulo='Demon Slayer'), 2, 'La primera prueba', 8.65),
((SELECT id_obra FROM obras WHERE titulo='Demon Slayer'), 3, 'La marca del cazador', 8.80),

((SELECT id_obra FROM obras WHERE titulo='Spy x Family'), 1, 'Primer contacto', 8.30),
((SELECT id_obra FROM obras WHERE titulo='Spy x Family'), 2, 'Operación Familiar', 8.40),

((SELECT id_obra FROM obras WHERE titulo='Fullmetal Alchemist: Brotherhood'), 1, 'El alquimista cansado', 9.20),
((SELECT id_obra FROM obras WHERE titulo='Fullmetal Alchemist: Brotherhood'), 2, 'Los hermanos Elric', 9.10),

((SELECT id_obra FROM obras WHERE titulo='My Hero Academia'), 1, 'Comienza la Academia', 8.50),
((SELECT id_obra FROM obras WHERE titulo='My Hero Academia'), 2, 'Entrenamiento intensivo', 8.45),

((SELECT id_obra FROM obras WHERE titulo='Steins;Gate'), 1, 'El primer viaje', 9.00),
((SELECT id_obra FROM obras WHERE titulo='Steins;Gate'), 2, 'La puerta del tiempo', 9.05),

((SELECT id_obra FROM obras WHERE titulo='Berserk'), 1, 'La marca del sacrificio', 9.10),
((SELECT id_obra FROM obras WHERE titulo='Berserk'), 2, 'Guts el guerrero', 9.05),

((SELECT id_obra FROM obras WHERE titulo='One Punch Man'), 1, 'El héroe aburrido', 8.80),
((SELECT id_obra FROM obras WHERE titulo='One Punch Man'), 2, 'El torneo', 8.65),

((SELECT id_obra FROM obras WHERE titulo='Vinland Saga'), 1, 'Nacimiento de un guerrero', 8.90),
((SELECT id_obra FROM obras WHERE titulo='Vinland Saga'), 2, 'Sangre y mar', 8.75),

((SELECT id_obra FROM obras WHERE titulo='Haikyuu!!'), 1, 'El primer saque', 8.40),
((SELECT id_obra FROM obras WHERE titulo='Haikyuu!!'), 2, 'Duelo en la cancha', 8.55),

((SELECT id_obra FROM obras WHERE titulo='Death Note'), 1, 'El cuaderno cae', 9.30),
((SELECT id_obra FROM obras WHERE titulo='Death Note'), 2, 'Juego mental', 9.10),

((SELECT id_obra FROM obras WHERE titulo='Tokyo Revengers'), 1, 'Un segundo intento', 8.20),
((SELECT id_obra FROM obras WHERE titulo='Tokyo Revengers'), 2, 'La banda se reúne', 8.15),

((SELECT id_obra FROM obras WHERE titulo='Blue Lock'), 1, 'Bienvenido al Blue Lock', 8.25),
((SELECT id_obra FROM obras WHERE titulo='Blue Lock'), 2, 'Competición despiadada', 8.30),

((SELECT id_obra FROM obras WHERE titulo='Oshi no Ko'), 1, 'El nacimiento de una estrella', 8.60),
((SELECT id_obra FROM obras WHERE titulo='Oshi no Ko'), 2, 'La industria mira', 8.55);

-- Añadir usuario demo que se usó en la interfaz
INSERT INTO usuarios (nombre_usuario, contrasena) VALUES
('inhar', 'inhar123');

-- Relacionar algunas preferencias (opcional)
INSERT INTO usuarios_gustan_obras (id_usuario, id_obra)
VALUES
((SELECT id_usuario FROM usuarios WHERE nombre_usuario='inhar'), (SELECT id_obra FROM obras WHERE titulo='One Piece')),
((SELECT id_usuario FROM usuarios WHERE nombre_usuario='inhar'), (SELECT id_obra FROM obras WHERE titulo='Jujutsu Kaisen'));

-- =====================================================
-- Añadir capítulos adicionales para todas las obras (asegurando al menos 8 capítulos por obra)
-- =====================================================
INSERT INTO capitulos (id_obra, num_capitulo, titulo, media_valoracion) VALUES

/* Jujutsu Kaisen (id_obra=Jujutsu Kaisen tiene 1..2) */
((SELECT id_obra FROM obras WHERE titulo='Jujutsu Kaisen'), 3, 'La batalla continúa', 8.50),
((SELECT id_obra FROM obras WHERE titulo='Jujutsu Kaisen'), 4, 'Sello de poder', 8.40),
((SELECT id_obra FROM obras WHERE titulo='Jujutsu Kaisen'), 5, 'Enfrentamiento', 8.60),
((SELECT id_obra FROM obras WHERE titulo='Jujutsu Kaisen'), 6, 'Revelaciones', 8.55),
((SELECT id_obra FROM obras WHERE titulo='Jujutsu Kaisen'), 7, 'La calma antes de la tormenta', 8.45),
((SELECT id_obra FROM obras WHERE titulo='Jujutsu Kaisen'), 8, 'Nueva amenaza', 8.70),

/* Frieren */
((SELECT id_obra FROM obras WHERE titulo='Frieren'), 3, 'Recuerdos del viaje', 8.30),
((SELECT id_obra FROM obras WHERE titulo='Frieren'), 4, 'Ecos del pasado', 8.35),
((SELECT id_obra FROM obras WHERE titulo='Frieren'), 5, 'El mapa antiguo', 8.25),
((SELECT id_obra FROM obras WHERE titulo='Frieren'), 6, 'Un aliado inesperado', 8.40),
((SELECT id_obra FROM obras WHERE titulo='Frieren'), 7, 'La prueba final', 8.45),
((SELECT id_obra FROM obras WHERE titulo='Frieren'), 8, 'La despedida', 8.50),

/* Chainsaw Man */
((SELECT id_obra FROM obras WHERE titulo='Chainsaw Man'), 2, 'Cap. 2 extra', 8.60),
((SELECT id_obra FROM obras WHERE titulo='Chainsaw Man'), 3, 'Cap. 3 extra', 8.65),
((SELECT id_obra FROM obras WHERE titulo='Chainsaw Man'), 4, 'Cap. 4 extra', 8.55),
((SELECT id_obra FROM obras WHERE titulo='Chainsaw Man'), 5, 'Cap. 5 extra', 8.50),
((SELECT id_obra FROM obras WHERE titulo='Chainsaw Man'), 6, 'Cap. 6 extra', 8.40),
((SELECT id_obra FROM obras WHERE titulo='Chainsaw Man'), 7, 'Cap. 7 extra', 8.45),
((SELECT id_obra FROM obras WHERE titulo='Chainsaw Man'), 8, 'Cap. 8 extra', 8.30),

/* One Piece (ya tiene 1..2) */
((SELECT id_obra FROM obras WHERE titulo='One Piece'), 3, 'El viaje continúa', 8.95),
((SELECT id_obra FROM obras WHERE titulo='One Piece'), 4, 'Nuevos compañeros', 8.85),
((SELECT id_obra FROM obras WHERE titulo='One Piece'), 5, 'Sombra en el mar', 8.80),
((SELECT id_obra FROM obras WHERE titulo='One Piece'), 6, 'El plan', 8.75),
((SELECT id_obra FROM obras WHERE titulo='One Piece'), 7, 'El gran enfrentamiento', 8.90),
((SELECT id_obra FROM obras WHERE titulo='One Piece'), 8, 'La promesa', 8.70),

/* Neon Genesis Evangelion (tiene 1..3) */
((SELECT id_obra FROM obras WHERE titulo='Neon Genesis Evangelion'), 4, 'La verdad se acerca', 9.00),
((SELECT id_obra FROM obras WHERE titulo='Neon Genesis Evangelion'), 5, 'El peso del mundo', 8.95),
((SELECT id_obra FROM obras WHERE titulo='Neon Genesis Evangelion'), 6, 'Interferencia', 8.80),
((SELECT id_obra FROM obras WHERE titulo='Neon Genesis Evangelion'), 7, 'Revelación', 8.85),
((SELECT id_obra FROM obras WHERE titulo='Neon Genesis Evangelion'), 8, 'El último encuentro', 9.10),

/* Attack on Titan (tiene 1..3) */
((SELECT id_obra FROM obras WHERE titulo='Attack on Titan'), 4, 'Asalto final', 9.30),
((SELECT id_obra FROM obras WHERE titulo='Attack on Titan'), 5, 'La caída', 9.10),
((SELECT id_obra FROM obras WHERE titulo='Attack on Titan'), 6, 'El poder oculto', 9.05),
((SELECT id_obra FROM obras WHERE titulo='Attack on Titan'), 7, 'Memorias', 9.00),
((SELECT id_obra FROM obras WHERE titulo='Attack on Titan'), 8, 'Nuevo amanecer', 8.95),

/* Demon Slayer (tiene 1..3) */
((SELECT id_obra FROM obras WHERE titulo='Demon Slayer'), 4, 'Prueba de la llama', 8.75),
((SELECT id_obra FROM obras WHERE titulo='Demon Slayer'), 5, 'Recuerdos quemados', 8.80),
((SELECT id_obra FROM obras WHERE titulo='Demon Slayer'), 6, 'La espada sagrada', 8.85),
((SELECT id_obra FROM obras WHERE titulo='Demon Slayer'), 7, 'El sacrificio', 8.90),
((SELECT id_obra FROM obras WHERE titulo='Demon Slayer'), 8, 'El amanecer', 8.95),

/* Spy x Family (tiene 1..2) */
((SELECT id_obra FROM obras WHERE titulo='Spy x Family'), 3, 'Misión de campo', 8.35),
((SELECT id_obra FROM obras WHERE titulo='Spy x Family'), 4, 'Cita familiar', 8.40),
((SELECT id_obra FROM obras WHERE titulo='Spy x Family'), 5, 'La gran actuación', 8.45),
((SELECT id_obra FROM obras WHERE titulo='Spy x Family'), 6, 'Noche de operaciones', 8.50),
((SELECT id_obra FROM obras WHERE titulo='Spy x Family'), 7, 'Secretos revelados', 8.55),
((SELECT id_obra FROM obras WHERE titulo='Spy x Family'), 8, 'Plan perfecto', 8.60),

/* Fullmetal Alchemist: Brotherhood (1..2) */
((SELECT id_obra FROM obras WHERE titulo='Fullmetal Alchemist: Brotherhood'), 3, 'El precio del alma', 9.00),
((SELECT id_obra FROM obras WHERE titulo='Fullmetal Alchemist: Brotherhood'), 4, 'La alquimia prohibida', 9.05),
((SELECT id_obra FROM obras WHERE titulo='Fullmetal Alchemist: Brotherhood'), 5, 'Hermandad', 9.10),
((SELECT id_obra FROM obras WHERE titulo='Fullmetal Alchemist: Brotherhood'), 6, 'La llave', 9.00),
((SELECT id_obra FROM obras WHERE titulo='Fullmetal Alchemist: Brotherhood'), 7, 'La verdad', 9.15),
((SELECT id_obra FROM obras WHERE titulo='Fullmetal Alchemist: Brotherhood'), 8, 'Restauración', 9.05),

/* My Hero Academia (1..2) */
((SELECT id_obra FROM obras WHERE titulo='My Hero Academia'), 3, 'Simulacro de héroes', 8.55),
((SELECT id_obra FROM obras WHERE titulo='My Hero Academia'), 4, 'El examen', 8.60),
((SELECT id_obra FROM obras WHERE titulo='My Hero Academia'), 5, 'La lección', 8.45),
((SELECT id_obra FROM obras WHERE titulo='My Hero Academia'), 6, 'Batalla de clase', 8.50),
((SELECT id_obra FROM obras WHERE titulo='My Hero Academia'), 7, 'El agente', 8.40),
((SELECT id_obra FROM obras WHERE titulo='My Hero Academia'), 8, 'El camino del héroe', 8.35),

/* Steins;Gate (1..2) */
((SELECT id_obra FROM obras WHERE titulo='Steins;Gate'), 3, 'Resonancia temporal', 9.10),
((SELECT id_obra FROM obras WHERE titulo='Steins;Gate'), 4, 'Ciclos', 9.05),
((SELECT id_obra FROM obras WHERE titulo='Steins;Gate'), 5, 'La elección', 9.00),
((SELECT id_obra FROM obras WHERE titulo='Steins;Gate'), 6, 'Último experimento', 9.15),
((SELECT id_obra FROM obras WHERE titulo='Steins;Gate'), 7, 'Puerta rota', 9.05),
((SELECT id_obra FROM obras WHERE titulo='Steins;Gate'), 8, 'Destino', 9.00),

/* Berserk (1..2) */
((SELECT id_obra FROM obras WHERE titulo='Berserk'), 3, 'La fortaleza oscura', 9.00),
((SELECT id_obra FROM obras WHERE titulo='Berserk'), 4, 'El cazador', 9.05),
((SELECT id_obra FROM obras WHERE titulo='Berserk'), 5, 'Rencor', 9.10),
((SELECT id_obra FROM obras WHERE titulo='Berserk'), 6, 'La luna roja', 9.00),
((SELECT id_obra FROM obras WHERE titulo='Berserk'), 7, 'Sombras', 8.95),
((SELECT id_obra FROM obras WHERE titulo='Berserk'), 8, 'Juicio', 9.15),

/* One Punch Man (1..2) */
((SELECT id_obra FROM obras WHERE titulo='One Punch Man'), 3, 'El desafío', 8.70),
((SELECT id_obra FROM obras WHERE titulo='One Punch Man'), 4, 'El torneo prosigue', 8.60),
((SELECT id_obra FROM obras WHERE titulo='One Punch Man'), 5, 'Encuentro decisivo', 8.75),
((SELECT id_obra FROM obras WHERE titulo='One Punch Man'), 6, 'La alianza', 8.65),
((SELECT id_obra FROM obras WHERE titulo='One Punch Man'), 7, 'Revancha', 8.60),
((SELECT id_obra FROM obras WHERE titulo='One Punch Man'), 8, 'Evolución', 8.55),

/* Vinland Saga (1..2) */
((SELECT id_obra FROM obras WHERE titulo='Vinland Saga'), 3, 'Ruta al norte', 8.80),
((SELECT id_obra FROM obras WHERE titulo='Vinland Saga'), 4, 'La isla', 8.75),
((SELECT id_obra FROM obras WHERE titulo='Vinland Saga'), 5, 'Venganza planeada', 8.90),
((SELECT id_obra FROM obras WHERE titulo='Vinland Saga'), 6, 'Tormenta', 8.85),
((SELECT id_obra FROM obras WHERE titulo='Vinland Saga'), 7, 'Redención', 8.95),
((SELECT id_obra FROM obras WHERE titulo='Vinland Saga'), 8, 'Nuevo linaje', 8.80),

/* Haikyuu!! (1..2) */
((SELECT id_obra FROM obras WHERE titulo='Haikyuu!!'), 3, 'Remontada', 8.60),
((SELECT id_obra FROM obras WHERE titulo='Haikyuu!!'), 4, 'Zona de bloqueo', 8.65),
((SELECT id_obra FROM obras WHERE titulo='Haikyuu!!'), 5, 'La final', 8.70),
((SELECT id_obra FROM obras WHERE titulo='Haikyuu!!'), 6, 'Restauración', 8.55),
((SELECT id_obra FROM obras WHERE titulo='Haikyuu!!'), 7, 'Trabajo en equipo', 8.45),
((SELECT id_obra FROM obras WHERE titulo='Haikyuu!!'), 8, 'Victoria', 8.60),

/* Death Note (1..2) */
((SELECT id_obra FROM obras WHERE titulo='Death Note'), 3, 'El juego continúa', 9.20),
((SELECT id_obra FROM obras WHERE titulo='Death Note'), 4, 'Cazador y presa', 9.10),
((SELECT id_obra FROM obras WHERE titulo='Death Note'), 5, 'Verdad oculta', 9.00),
((SELECT id_obra FROM obras WHERE titulo='Death Note'), 6, 'Caos', 8.95),
((SELECT id_obra FROM obras WHERE titulo='Death Note'), 7, 'Confrontación', 9.05),
((SELECT id_obra FROM obras WHERE titulo='Death Note'), 8, 'El legado', 9.15),

/* Tokyo Revengers (1..2) */
((SELECT id_obra FROM obras WHERE titulo='Tokyo Revengers'), 3, 'El giro del tiempo', 8.25),
((SELECT id_obra FROM obras WHERE titulo='Tokyo Revengers'), 4, 'Rivalidad', 8.30),
((SELECT id_obra FROM obras WHERE titulo='Tokyo Revengers'), 5, 'La traición', 8.35),
((SELECT id_obra FROM obras WHERE titulo='Tokyo Revengers'), 6, 'La promesa', 8.40),
((SELECT id_obra FROM obras WHERE titulo='Tokyo Revengers'), 7, 'Redención', 8.45),
((SELECT id_obra FROM obras WHERE titulo='Tokyo Revengers'), 8, 'Nuevo comienzo', 8.50),

/* Blue Lock (1..2) */
((SELECT id_obra FROM obras WHERE titulo='Blue Lock'), 3, 'La eliminatoria', 8.30),
((SELECT id_obra FROM obras WHERE titulo='Blue Lock'), 4, 'Desafío personal', 8.35),
((SELECT id_obra FROM obras WHERE titulo='Blue Lock'), 5, 'La estrategia', 8.40),
((SELECT id_obra FROM obras WHERE titulo='Blue Lock'), 6, 'Entrenamiento extremo', 8.45),
((SELECT id_obra FROM obras WHERE titulo='Blue Lock'), 7, 'La final', 8.55),
((SELECT id_obra FROM obras WHERE titulo='Blue Lock'), 8, 'El delantero perfecto', 8.60),

/* Oshi no Ko (1..2) */
((SELECT id_obra FROM obras WHERE titulo='Oshi no Ko'), 3, 'Ascenso', 8.60),
((SELECT id_obra FROM obras WHERE titulo='Oshi no Ko'), 4, 'La fama', 8.55),
((SELECT id_obra FROM obras WHERE titulo='Oshi no Ko'), 5, 'Oscuridad en el set', 8.50),
((SELECT id_obra FROM obras WHERE titulo='Oshi no Ko'), 6, 'La producción', 8.45),
((SELECT id_obra FROM obras WHERE titulo='Oshi no Ko'), 7, 'La caída', 8.40),
((SELECT id_obra FROM obras WHERE titulo='Oshi no Ko'), 8, 'Resurgir', 8.65);

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

-- Nota: si ya tienes una base de datos creada de una versión anterior,
-- ejecuta el siguiente comando para añadir la columna 'email' a la tabla usuarios
-- (MySQL 8+ soporta ADD COLUMN IF NOT EXISTS; si tu versión no la soporta,
-- ejecuta manualmente o ignora si ya está presente):
ALTER TABLE usuarios ADD COLUMN IF NOT EXISTS email VARCHAR(100) DEFAULT NULL;