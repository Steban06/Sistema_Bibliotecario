-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-02-2025 a las 00:34:52
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
-- Base de datos: `biblioteca_bd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carreras`
--

CREATE TABLE `carreras` (
  `codigo` int(5) NOT NULL,
  `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carreras`
--

INSERT INTO `carreras` (`codigo`, `descripcion`) VALUES
(4401, 'Analisis y Diseño de sistemas'),
(4403, 'Enfermería'),
(4409, 'Administración y Gestion Municipal'),
(4413, 'Ingeniería Civil'),
(4426, 'Ingeniería Sistemas'),
(4427, 'Turismo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docentes`
--

CREATE TABLE `docentes` (
  `cedula` varchar(10) NOT NULL,
  `nombres` varchar(30) NOT NULL,
  `apellidos` varchar(30) NOT NULL,
  `telefono` varchar(12) NOT NULL,
  `direccion` text NOT NULL,
  `email` varchar(30) NOT NULL,
  `materia` varchar(30) DEFAULT NULL,
  `estado` varchar(10) NOT NULL DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `docentes`
--

INSERT INTO `docentes` (`cedula`, `nombres`, `apellidos`, `telefono`, `direccion`, `email`, `materia`, `estado`) VALUES
('10200751', 'Emily Del Valle', 'Fermin Sanchez', '04264887991', 'Desconocida', 'Feproca18@gmail.com', 'Algebra lineal', 'Activo'),
('29985988', 'probando', 'probando', '12345678909', 'Desconocida', 'alguno@gmail.com', 'una por ahi', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes`
--

CREATE TABLE `estudiantes` (
  `cedula` varchar(10) NOT NULL,
  `nombres` varchar(30) NOT NULL,
  `apellidos` varchar(30) NOT NULL,
  `telefono` varchar(11) NOT NULL,
  `direccion` text NOT NULL,
  `email` varchar(50) NOT NULL,
  `carrera` int(2) NOT NULL,
  `semestre` varchar(4) NOT NULL,
  `estado` varchar(10) NOT NULL DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estudiantes`
--

INSERT INTO `estudiantes` (`cedula`, `nombres`, `apellidos`, `telefono`, `direccion`, `email`, `carrera`, `semestre`, `estado`) VALUES
('29985230', 'Gabrielis Simforoza', 'Marcano Moreno', '04127951298', 'El ricon del tuey', 'Gabi@gmail.com', 4426, 'V', 'Activo'),
('29985989', 'Esteban David', 'Salazar Fermin', '04266974136', 'San Juan', 'stevenfermin125@gmail.com', 4426, 'VII', 'Activo'),
('44444444', 'prueba', 'prueba', '04267777777', '', 'stevenfermi125@gmail.com', 4401, 'IV', 'Inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `id` int(11) NOT NULL,
  `cota` varchar(10) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `autor` varchar(50) NOT NULL,
  `area` varchar(50) NOT NULL,
  `editorial` varchar(50) NOT NULL,
  `edicion` varchar(30) NOT NULL DEFAULT 'No posee',
  `tomos` varchar(30) NOT NULL DEFAULT 'No posee',
  `ejemplares_tot` int(2) NOT NULL,
  `ejemplares_dis` int(3) NOT NULL,
  `fecha` date NOT NULL,
  `estado` varchar(15) NOT NULL DEFAULT 'Disponible'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`id`, `cota`, `titulo`, `autor`, `area`, `editorial`, `edicion`, `tomos`, `ejemplares_tot`, `ejemplares_dis`, `fecha`, `estado`) VALUES
(1, '11F111', 'Hola', 'esteban salazar', 'Buenas tardes', 'Fermin', 'No posee', 'No posee', 5, 3, '2025-01-06', 'Disponible'),
(2, '22FF222', 'Libro ejemplo', 'Simon Bolivar', 'Patria', 'edmundo', 'No posee', 'No posee', 10, 9, '2025-01-01', 'No disponible');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pasantias`
--

CREATE TABLE `pasantias` (
  `id` int(11) NOT NULL,
  `cota` varchar(15) NOT NULL,
  `titulo` text NOT NULL,
  `autor` varchar(30) NOT NULL,
  `tutor` varchar(30) NOT NULL,
  `institucion` text NOT NULL,
  `fecha_presentacion` varchar(8) NOT NULL,
  `estado` varchar(15) NOT NULL DEFAULT 'Disponible'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pasantias`
--

INSERT INTO `pasantias` (`id`, `cota`, `titulo`, `autor`, `tutor`, `institucion`, `fecha_presentacion`, `estado`) VALUES
(1, '33H333', 'Pasantia Test', 'Stefen Hokin', 'Norgelis', 'Gaspar Marcano', '2025-01', 'Disponible');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamos`
--

CREATE TABLE `prestamos` (
  `ID` int(11) NOT NULL,
  `cedula_persona` varchar(10) NOT NULL,
  `cota_documento` varchar(10) NOT NULL,
  `fecha_salida` date NOT NULL,
  `fecha_entrada` date NOT NULL,
  `estado` enum('Prestado','No devuelto','Devuelto') NOT NULL DEFAULT 'Prestado',
  `observaciones` text NOT NULL,
  `ususario_registro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `prestamos`
--

INSERT INTO `prestamos` (`ID`, `cedula_persona`, `cota_documento`, `fecha_salida`, `fecha_entrada`, `estado`, `observaciones`, `ususario_registro`) VALUES
(1, '29985989', '22FF222', '2025-01-19', '2025-01-20', 'Devuelto', 'No hay observaciones', 1),
(2, '29985989', '22FF222', '2025-01-19', '2025-01-20', 'Devuelto', 'No hay observaciones', 1),
(3, '29985989', '22FF222', '2025-01-19', '2025-01-20', 'Devuelto', 'No hay observaciones', 1),
(4, '29985989', '11F111', '2025-01-19', '2025-01-20', 'Devuelto', 'No hay observaciones', 1),
(5, '29985989', '11F111', '2025-01-21', '2025-01-20', 'Devuelto', 'No hay observaciones', 1),
(6, '29985989', '77A778', '2025-01-22', '2025-01-22', 'Prestado', 'No hay observaciones', 1),
(7, '29985989', '33H333', '2025-01-22', '2025-01-22', 'Devuelto', 'No hay observaciones', 1),
(8, '29985989', '44J444', '2025-01-28', '2025-01-28', 'Devuelto', 'No hay observaciones', 1),
(9, '29985230', '77A778', '2025-01-30', '2025-01-31', 'Prestado', 'No hay observaciones', 1),
(10, '10200751', '11F111', '2025-02-02', '2025-02-03', 'Devuelto', 'No hay observaciones', 1),
(17, '10200751', '44J444', '2025-02-02', '2025-02-03', 'Prestado', 'No hay observaciones', 1),
(18, '29985230', '77A777', '2025-02-03', '2025-02-03', 'Prestado', 'No hay observaciones', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios_comunitarios`
--

CREATE TABLE `servicios_comunitarios` (
  `id` int(11) NOT NULL,
  `cota` varchar(15) NOT NULL,
  `titulo` text NOT NULL,
  `autores` text NOT NULL,
  `tutor_academico` varchar(30) NOT NULL,
  `tutor_comunitario` varchar(30) NOT NULL,
  `institucion` text NOT NULL,
  `fecha_presentacion` varchar(8) NOT NULL,
  `estado` varchar(15) NOT NULL DEFAULT 'Disponible'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicios_comunitarios`
--

INSERT INTO `servicios_comunitarios` (`id`, `cota`, `titulo`, `autores`, `tutor_academico`, `tutor_comunitario`, `institucion`, `fecha_presentacion`, `estado`) VALUES
(1, '44J444', 'Servico Test', 'Esteban Salazar\r\nJesus Rios \r\nJesus Villalba\r\nEDMUNDO GONZALEZ', 'Mariely Salazar', 'No me acuerdo', 'Antonia Matilde Mata', '2025-01', 'No disponible'),
(2, '66J666', 'Servico Test 2', 'Esteban Salzar\r\nJesus Rios\r\nJesus Villalba', 'Mariely Salazar', 'No me acuerdo', 'Antonia Matilde Mata', '2025-01', 'Disponible');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajos_investigacion`
--

CREATE TABLE `trabajos_investigacion` (
  `id` int(11) NOT NULL,
  `cota` varchar(15) NOT NULL,
  `titulo` text NOT NULL,
  `autor` varchar(30) NOT NULL,
  `tutor` varchar(30) NOT NULL,
  `tipo` enum('Pregrado','Postgrado') NOT NULL,
  `area` varchar(30) NOT NULL,
  `mencion` varchar(20) NOT NULL,
  `metodologia` varchar(30) NOT NULL,
  `fecha_presentacion` varchar(8) NOT NULL,
  `estado` varchar(15) NOT NULL DEFAULT 'Disponible'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `trabajos_investigacion`
--

INSERT INTO `trabajos_investigacion` (`id`, `cota`, `titulo`, `autor`, `tutor`, `tipo`, `area`, `mencion`, `metodologia`, `fecha_presentacion`, `estado`) VALUES
(1, '77A777', 'Prueba de Trabajo', 'Esteban', 'Mario Rivas', 'Pregrado', 'Redes', 'No sé', 'Cuantitativa', '2024-12', 'Disponible'),
(2, '77A776', 'Prueba de Trabajo', 'Esteban', 'Mario Rivas', 'Postgrado', 'Redes', 'No sé', 'Cuantitativa', '2025-01', 'No disponible'),
(3, '77A778', 'Prueba de Trabajo', 'Esteban', 'Mario Rivas', 'Postgrado', 'Redes', 'No sé', 'Cuantitativa', '1999-03', 'Disponible'),
(4, '77A771', 'Prueba de Trabajo', 'Esteban', 'Mario Rivas', 'Postgrado', 'Redes', 'No sé', 'Cuantitativa', '2025-01', 'No disponible');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `cedula` varchar(10) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `cargo` varchar(20) NOT NULL,
  `user` varchar(30) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `cedula`, `nombres`, `apellidos`, `cargo`, `user`, `password`) VALUES
(1, '29985989', 'Esteban David', 'Salazar Fermin', 'ADMINISTRADOR', 'admin1', 'admin1'),
(2, '11111111', 'Cristofer', 'Benitez', 'ADMINISTRADOR', 'admin2', 'admin2');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carreras`
--
ALTER TABLE `carreras`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `docentes`
--
ALTER TABLE `docentes`
  ADD PRIMARY KEY (`cedula`);

--
-- Indices de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD PRIMARY KEY (`cedula`),
  ADD KEY `carrera` (`carrera`);

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pasantias`
--
ALTER TABLE `pasantias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `cota_documento` (`cota_documento`),
  ADD KEY `cedula_persona` (`cedula_persona`) USING BTREE,
  ADD KEY `ususario_registro` (`ususario_registro`);

--
-- Indices de la tabla `servicios_comunitarios`
--
ALTER TABLE `servicios_comunitarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `trabajos_investigacion`
--
ALTER TABLE `trabajos_investigacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `libros`
--
ALTER TABLE `libros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pasantias`
--
ALTER TABLE `pasantias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `servicios_comunitarios`
--
ALTER TABLE `servicios_comunitarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `trabajos_investigacion`
--
ALTER TABLE `trabajos_investigacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD CONSTRAINT `estudiantes_ibfk_1` FOREIGN KEY (`carrera`) REFERENCES `carreras` (`codigo`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD CONSTRAINT `prestamos_ibfk_1` FOREIGN KEY (`ususario_registro`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
