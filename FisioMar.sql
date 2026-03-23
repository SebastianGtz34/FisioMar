-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 23-03-2026 a las 02:59:52
-- Versión del servidor: 8.4.7
-- Versión de PHP: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `fisiomar`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

DROP TABLE IF EXISTS `citas`;
CREATE TABLE IF NOT EXISTS `citas` (
  `id_cita` int NOT NULL AUTO_INCREMENT,
  `id_paciente` int NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `motivo` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '''Programada'',''Realizada'',''Cancelada''',
  PRIMARY KEY (`id_cita`),
  KEY `id_paciente` (`id_paciente`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`id_cita`, `id_paciente`, `fecha`, `hora`, `motivo`, `estado`) VALUES
(1, 1, '2026-03-03', '18:46:00', 'Prueba', 'Programada'),
(2, 2, '2026-03-03', '18:00:00', 'Prueba 2', 'Realizada'),
(4, 1, '2026-03-10', '20:10:00', 'prueba', 'Programada'),
(5, 2, '2026-03-18', '20:54:00', 'jcjg', 'Realizada'),
(6, 2, '2026-03-10', '22:00:00', 'gcmucvjg', 'Programada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

DROP TABLE IF EXISTS `pacientes`;
CREATE TABLE IF NOT EXISTS `pacientes` (
  `id_paciente` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `sexo` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `edad` int DEFAULT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ocupacion` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_civil` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seguro_medico` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diagnostico` text COLLATE utf8mb4_unicode_ci,
  `antecedentes` text COLLATE utf8mb4_unicode_ci,
  `folio` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estatus` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Activo',
  `contacto_emergencia` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono_emergencia` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_paciente`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`id_paciente`, `nombre`, `apellido`, `fecha_nacimiento`, `sexo`, `edad`, `telefono`, `correo`, `ocupacion`, `estado_civil`, `seguro_medico`, `diagnostico`, `antecedentes`, `folio`, `estatus`, `contacto_emergencia`, `telefono_emergencia`, `fecha_registro`) VALUES
(1, 'Sebastian', 'Gutierrez Rodriguez', '2001-06-17', 'Masculino', 0, '4461445382', 'sebastianhalo2000@gmail.com', 'Trabajador', 'Soltero/a', 'IMSS', 'Plexo Braquial', 'Ligamento cruzado anterior', '', 'Activo', '', '', '2026-03-03 01:49:30'),
(2, 'Victoria', 'Gutierrez Rodriguez', '1996-08-31', 'Femenino', 30, '4424712336', 'sebastianhalo2000@gmail.com', 'Trabajador', 'Unión libre', 'IMSS', 'Prueba', 'Prueba', '', 'Activo', '', '', '2026-03-03 02:05:08'),
(3, 'Dulce Morelia', 'Chavez Olavarrieta', '2000-05-12', 'Femenino', 25, '4421700710', 'olavarrietad@gmail.com', 'Empleada', 'Soltero/a', 'IMSS', 'clínicamente sano', 'NA', '', 'Activo', '', '', '2026-03-04 01:45:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

DROP TABLE IF EXISTS `reportes`;
CREATE TABLE IF NOT EXISTS `reportes` (
  `id_reporte` int NOT NULL AUTO_INCREMENT,
  `id_paciente` int DEFAULT NULL,
  `tipo` enum('Historial Completo','Sesiones Realizadas','Resumen de Tratamientos') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_generado` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_reporte`),
  KEY `id_paciente` (`id_paciente`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `reportes`
--

INSERT INTO `reportes` (`id_reporte`, `id_paciente`, `tipo`, `fecha_generado`) VALUES
(2, 1, 'Sesiones Realizadas', '2026-03-11 03:23:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sesiones`
--

DROP TABLE IF EXISTS `sesiones`;
CREATE TABLE IF NOT EXISTS `sesiones` (
  `id_sesion` int NOT NULL AUTO_INCREMENT,
  `id_cita` int NOT NULL,
  `tipo_tratamiento` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notas` text COLLATE utf8mb4_unicode_ci,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_sesion`),
  KEY `id_cita` (`id_cita`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rol` enum('Admin','Terapeuta','Recepcionista') COLLATE utf8mb4_unicode_ci DEFAULT 'Terapeuta',
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `correo` (`correo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
