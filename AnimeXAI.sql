-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-02-2026 a las 02:58:01
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `animexai`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `capitulos`
--

CREATE TABLE `capitulos` (
  `id_obra` int(11) NOT NULL,
  `num_capitulo` int(11) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `media_valoracion` decimal(3,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `capitulos`
--

INSERT INTO `capitulos` (`id_obra`, `num_capitulo`, `titulo`, `media_valoracion`) VALUES
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `obras`
--

CREATE TABLE `obras` (
  `id_obra` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `sinopsis` text DEFAULT NULL,
  `tipo` enum('anime','manga') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `obras`
--

INSERT INTO `obras` (`id_obra`, `titulo`, `sinopsis`, `tipo`) VALUES
(1, 'Jujutsu Kaisen', 'Hechiceros luchan contra maldiciones.', 'anime'),
(2, 'Frieren', 'Una elfa revive el viaje tras la aventura.', 'anime'),
(3, 'Chainsaw Man', 'Un chico con poderes demoníacos pelea por sobrevivir.', 'manga'),
(4, 'One Piece', 'Piratas buscan el gran tesoro.', 'anime'),
(5, 'Neon Genesis Evangelion', 'Adolescentes pilotan EVAs contra los Ángeles.', 'anime');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre`, `descripcion`) VALUES
(1, 'Figura Jujutsu', 'Figura coleccionable de Jujutsu Kaisen'),
(2, 'Sudadera One Piece', 'Sudadera temática de One Piece'),
(3, 'Poster Frieren', 'Poster tamaño A2 de Frieren'),
(4, 'Manga Chainsaw Man 1', 'Tomo 1 físico de Chainsaw Man');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre_usuario`, `contrasena`) VALUES
(1, 'alex', 'alex123'),
(2, 'maria', 'maria123'),
(3, 'dani', 'dani123'),
(4, 'Inhar', '$2y$10$cyIP0dFX6.KbtceaeOmqeO5DDUU8klwP56hLGi78WWCqy9x7w63OG');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_desean_productos`
--

CREATE TABLE `usuarios_desean_productos` (
  `id_usuario` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios_desean_productos`
--

INSERT INTO `usuarios_desean_productos` (`id_usuario`, `id_producto`) VALUES
(1, 1),
(1, 3),
(2, 4),
(3, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_gustan_obras`
--

CREATE TABLE `usuarios_gustan_obras` (
  `id_usuario` int(11) NOT NULL,
  `id_obra` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios_gustan_obras`
--

INSERT INTO `usuarios_gustan_obras` (`id_usuario`, `id_obra`) VALUES
(1, 1),
(1, 2),
(1, 5),
(2, 2),
(2, 3),
(2, 5),
(3, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_valoran_capitulos`
--

CREATE TABLE `usuarios_valoran_capitulos` (
  `id_usuario` int(11) NOT NULL,
  `id_obra` int(11) NOT NULL,
  `num_capitulo` int(11) NOT NULL,
  `puntuacion` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios_valoran_capitulos`
--

INSERT INTO `usuarios_valoran_capitulos` (`id_usuario`, `id_obra`, `num_capitulo`, `puntuacion`) VALUES
(1, 1, 1, 9),
(1, 2, 1, 10),
(1, 5, 1, 10),
(1, 5, 2, 9),
(2, 2, 1, 9),
(2, 3, 1, 8),
(2, 5, 1, 9),
(3, 4, 1, 10),
(3, 4, 2, 9),
(3, 5, 1, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_ven_capitulos`
--

CREATE TABLE `usuarios_ven_capitulos` (
  `id_usuario` int(11) NOT NULL,
  `id_obra` int(11) NOT NULL,
  `num_capitulo` int(11) NOT NULL,
  `visto_en` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios_ven_capitulos`
--

INSERT INTO `usuarios_ven_capitulos` (`id_usuario`, `id_obra`, `num_capitulo`, `visto_en`) VALUES
(1, 1, 1, '2026-02-01 13:40:14'),
(1, 1, 2, '2026-02-01 13:40:14'),
(1, 2, 1, '2026-02-01 13:40:14'),
(1, 5, 1, '2026-02-01 13:40:14'),
(1, 5, 2, '2026-02-01 13:40:14'),
(2, 2, 1, '2026-02-01 13:40:14'),
(2, 3, 1, '2026-02-01 13:40:14'),
(2, 5, 1, '2026-02-01 13:40:14'),
(3, 4, 1, '2026-02-01 13:40:14'),
(3, 4, 2, '2026-02-01 13:40:14'),
(3, 5, 1, '2026-02-01 13:40:14');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `capitulos`
--
ALTER TABLE `capitulos`
  ADD PRIMARY KEY (`id_obra`,`num_capitulo`);

--
-- Indices de la tabla `obras`
--
ALTER TABLE `obras`
  ADD PRIMARY KEY (`id_obra`),
  ADD UNIQUE KEY `titulo` (`titulo`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`);

--
-- Indices de la tabla `usuarios_desean_productos`
--
ALTER TABLE `usuarios_desean_productos`
  ADD PRIMARY KEY (`id_usuario`,`id_producto`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `usuarios_gustan_obras`
--
ALTER TABLE `usuarios_gustan_obras`
  ADD PRIMARY KEY (`id_usuario`,`id_obra`),
  ADD KEY `id_obra` (`id_obra`);

--
-- Indices de la tabla `usuarios_valoran_capitulos`
--
ALTER TABLE `usuarios_valoran_capitulos`
  ADD PRIMARY KEY (`id_usuario`,`id_obra`,`num_capitulo`),
  ADD KEY `id_obra` (`id_obra`,`num_capitulo`);

--
-- Indices de la tabla `usuarios_ven_capitulos`
--
ALTER TABLE `usuarios_ven_capitulos`
  ADD PRIMARY KEY (`id_usuario`,`id_obra`,`num_capitulo`),
  ADD KEY `id_obra` (`id_obra`,`num_capitulo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `obras`
--
ALTER TABLE `obras`
  MODIFY `id_obra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `capitulos`
--
ALTER TABLE `capitulos`
  ADD CONSTRAINT `capitulos_ibfk_1` FOREIGN KEY (`id_obra`) REFERENCES `obras` (`id_obra`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios_desean_productos`
--
ALTER TABLE `usuarios_desean_productos`
  ADD CONSTRAINT `usuarios_desean_productos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuarios_desean_productos_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios_gustan_obras`
--
ALTER TABLE `usuarios_gustan_obras`
  ADD CONSTRAINT `usuarios_gustan_obras_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuarios_gustan_obras_ibfk_2` FOREIGN KEY (`id_obra`) REFERENCES `obras` (`id_obra`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios_valoran_capitulos`
--
ALTER TABLE `usuarios_valoran_capitulos`
  ADD CONSTRAINT `usuarios_valoran_capitulos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuarios_valoran_capitulos_ibfk_2` FOREIGN KEY (`id_obra`,`num_capitulo`) REFERENCES `capitulos` (`id_obra`, `num_capitulo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios_ven_capitulos`
--
ALTER TABLE `usuarios_ven_capitulos`
  ADD CONSTRAINT `usuarios_ven_capitulos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuarios_ven_capitulos_ibfk_2` FOREIGN KEY (`id_obra`,`num_capitulo`) REFERENCES `capitulos` (`id_obra`, `num_capitulo`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
