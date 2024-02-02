-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-08-2023 a las 21:44:55
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `privanet`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dislike`
--

CREATE TABLE `dislike` (
  `idPublicacion` int(11) NOT NULL,
  `nombreUsuario` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dislike`
--

INSERT INTO `dislike` (`idPublicacion`, `nombreUsuario`) VALUES
(14, 'joaquin2A'),
(16, 'Rodolfo'),
(19, 'Rodolfo'),
(32, 'Rodolfo'),
(33, 'joaquin2A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favorito`
--

CREATE TABLE `favorito` (
  `idPublicacion` int(11) NOT NULL,
  `nombreUsuario` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `favorito`
--

INSERT INTO `favorito` (`idPublicacion`, `nombreUsuario`) VALUES
(15, 'joaquin2A'),
(16, 'joaquin2A'),
(19, 'joaquin2A'),
(28, 'joaquin2A'),
(33, 'Rodolfo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `likes`
--

CREATE TABLE `likes` (
  `idPublicacion` int(11) NOT NULL,
  `nombreUsuario` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `likes`
--

INSERT INTO `likes` (`idPublicacion`, `nombreUsuario`) VALUES
(16, 'joaquin2A'),
(20, 'Rodolfo'),
(28, 'joaquin2A'),
(28, 'Rodolfo'),
(33, 'isaias'),
(35, 'isaias');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicacion`
--

CREATE TABLE `publicacion` (
  `idPublicacion` int(11) NOT NULL,
  `texto` varchar(500) DEFAULT NULL,
  `usuario` varchar(50) NOT NULL,
  `fecha` datetime NOT NULL,
  `imagen` varchar(100) DEFAULT NULL,
  `audio` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `publicacion`
--

INSERT INTO `publicacion` (`idPublicacion`, `texto`, `usuario`, `fecha`, `imagen`, `audio`) VALUES
(12, 'Amo los gatitos!!!', 'vvalentinalopez', '2023-08-05 23:54:30', NULL, './AudiosSubidos/WhatsApp-Ptt-2023-08-02-at-12.11.33.mp3'),
(13, 'publicacion programada', 'vvalentinalopez', '2023-08-05 23:58:00', NULL, NULL),
(14, 'publicación programada segundo intento', 'vvalentinalopez', '2023-08-06 00:08:00', NULL, NULL),
(15, 'holaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholaholahola', 'Rodolfo', '2023-08-06 14:34:58', './ImagenesSubidas/Diseño-sin-título.jpeg', './AudiosSubidos/WhatsApp-Ptt-2023-08-02-at-12.11.32.mp3'),
(16, 'publicación con imagen grande', 'Rodolfo', '2023-08-06 16:10:56', './ImagenesSubidas/lago.jpeg', NULL),
(19, NULL, 'Rodolfo', '2023-08-10 14:10:37', './ImagenesSubidas/lago.jpeg', NULL),
(20, 'audio eliminado', 'Rodolfo', '2023-08-10 14:10:56', NULL, NULL),
(28, '', 'joaquin2A', '2023-08-14 02:55:11', NULL, './AudiosSubidos/WhatsApp-Ptt-2023-08-02-at-12.11.32.mp3'),
(31, '', 'joaquin2A', '2023-08-16 00:20:52', './ImagenesSubidas/lago.jpeg', NULL),
(32, 'dsssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss', 'joaquin2A', '2023-08-16 00:22:00', NULL, NULL),
(33, 'texto mas corto', 'joaquin2A', '2023-08-16 00:22:58', './ImagenesSubidas/lago.jpeg', NULL),
(34, 'esta es mi primera publicación-programada', 'isaias', '2023-08-18 15:47:00', NULL, './AudiosSubidos/WhatsApp-Ptt-2023-08-02-at-12.11.32.mp3'),
(35, 'PUBLICACION PROGRAMADA', 'joaquin2A', '2023-08-18 15:52:00', NULL, NULL),
(36, 'publicacion programada para otro dia', 'isaias', '2023-08-20 12:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `nombre` varchar(50) NOT NULL,
  `contrasenia` varchar(100) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `fechaNacimiento` date NOT NULL,
  `paisResidencia` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`nombre`, `contrasenia`, `correo`, `fechaNacimiento`, `paisResidencia`) VALUES
('isaias', '$2y$10$yUHZNCqlrZ3F2w96sAktHez6MXPCLye5hrRI.IEz4m4bgyWvqa5eu', 'mmm@gmail.com', '2000-03-12', 'Brasil'),
('joaquin', '$2y$10$d59gmW76AtGaW/JT1Um2Ju2K3NEODtU/tk8Q9sxhoPtibc19wgO1C', 'joaquin9@gmail.com', '2003-03-25', 'Argentina'),
('joaquin2A', '$2y$10$7xruH9JwpfgU1XBbrYD9G.oTOMlcVKP9mN1sG0u9v0Yer51OYvtIa', 'joaquin9@gmail.com', '2003-03-25', 'Argentina'),
('Rodolfo', '$2y$10$4GuQgTYL/6qBvpvOlZEC4uZYVZU77ah44LNNAhjEqy7SRy/mTyiUO', 'asd@gmail.com', '1999-02-23', 'Brasil'),
('vvalentinalopez', '$2y$10$L3ELAK/Hr5T4/xB30OD4A.LVswQrvvAL1837hzSASRlkdDuRM7e6W', 'valentinaalopez15@gmail.com', '2003-06-10', 'Argentina');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `dislike`
--
ALTER TABLE `dislike`
  ADD PRIMARY KEY (`idPublicacion`,`nombreUsuario`),
  ADD KEY `nombreUsuario` (`nombreUsuario`);

--
-- Indices de la tabla `favorito`
--
ALTER TABLE `favorito`
  ADD PRIMARY KEY (`idPublicacion`,`nombreUsuario`),
  ADD KEY `nombreUsuario` (`nombreUsuario`);

--
-- Indices de la tabla `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`idPublicacion`,`nombreUsuario`) USING BTREE,
  ADD KEY `nombreUsuario` (`nombreUsuario`);

--
-- Indices de la tabla `publicacion`
--
ALTER TABLE `publicacion`
  ADD PRIMARY KEY (`idPublicacion`),
  ADD KEY `idUsuario` (`usuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`nombre`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `publicacion`
--
ALTER TABLE `publicacion`
  MODIFY `idPublicacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `dislike`
--
ALTER TABLE `dislike`
  ADD CONSTRAINT `dislike_ibfk_1` FOREIGN KEY (`idPublicacion`) REFERENCES `publicacion` (`idPublicacion`) ON UPDATE CASCADE,
  ADD CONSTRAINT `dislike_ibfk_2` FOREIGN KEY (`nombreUsuario`) REFERENCES `usuario` (`nombre`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `favorito`
--
ALTER TABLE `favorito`
  ADD CONSTRAINT `favorito_ibfk_1` FOREIGN KEY (`idPublicacion`) REFERENCES `publicacion` (`idPublicacion`) ON UPDATE CASCADE,
  ADD CONSTRAINT `favorito_ibfk_2` FOREIGN KEY (`nombreUsuario`) REFERENCES `usuario` (`nombre`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`idPublicacion`) REFERENCES `publicacion` (`idPublicacion`) ON UPDATE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`nombreUsuario`) REFERENCES `usuario` (`nombre`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `publicacion`
--
ALTER TABLE `publicacion`
  ADD CONSTRAINT `publicacion_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`nombre`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
