-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 07-10-2024 a las 15:30:51
-- Versión del servidor: 8.0.39-0ubuntu0.22.04.1
-- Versión de PHP: 8.1.2-1ubuntu2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `portfolio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Project`
--

CREATE TABLE `Project` (
  `id` int NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `Project`
--

INSERT INTO `Project` (`id`, `name`, `description`) VALUES
(1, 'FirstTwig', 'Proyecto para practicar Twig'),
(2, 'TokyoNightV2', 'Tema para Discord basado en TokyoNight');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ProjectTechnology`
--

CREATE TABLE `ProjectTechnology` (
  `projectId` int NOT NULL,
  `technologyId` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `ProjectTechnology`
--

INSERT INTO `ProjectTechnology` (`projectId`, `technologyId`) VALUES
(1, 1),
(2, 1),
(1, 2),
(2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Technology`
--

CREATE TABLE `Technology` (
  `id` int NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `Technology`
--

INSERT INTO `Technology` (`id`, `name`, `description`) VALUES
(1, 'HTML', 'HTML es un lenguaje de marcado que posibilita definir la estructura de nuestro documento mediante etiquetas. Este lenguaje ofrece una gran adaptabilidad, una ...'),
(2, 'CSS', 'CSS (siglas en inglés de Cascading Style Sheets; en español: «hojas de estilo en cascada») es un lenguaje informático especializado en definir y cohesionar ...');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Project`
--
ALTER TABLE `Project`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ProjectTechnology`
--
ALTER TABLE `ProjectTechnology`
  ADD PRIMARY KEY (`projectId`,`technologyId`),
  ADD KEY `technologyId_FK` (`technologyId`);

--
-- Indices de la tabla `Technology`
--
ALTER TABLE `Technology`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Project`
--
ALTER TABLE `Project`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `Technology`
--
ALTER TABLE `Technology`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ProjectTechnology`
--
ALTER TABLE `ProjectTechnology`
  ADD CONSTRAINT `projectId_FK` FOREIGN KEY (`projectId`) REFERENCES `Project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `technologyId_FK` FOREIGN KEY (`technologyId`) REFERENCES `Technology` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;