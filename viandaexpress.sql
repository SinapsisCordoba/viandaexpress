-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 10-10-2016 a las 20:01:04
-- Versión del servidor: 5.7.15-0ubuntu0.16.04.1
-- Versión de PHP: 7.0.8-0ubuntu0.16.04.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `viandaexpress`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `usuario` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  `password` varchar(32) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`id`, `usuario`, `password`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

CREATE TABLE `horarios` (
  `id` int(11) NOT NULL,
  `sucursal` int(11) NOT NULL,
  `horario` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `horarios`
--

INSERT INTO `horarios` (`id`, `sucursal`, `horario`) VALUES
(1, 1, '12:00:00'),
(2, 1, '12:00:00'),
(3, 1, '12:30:00'),
(4, 1, '13:00:00'),
(5, 1, '13:30:00'),
(6, 1, '14:00:00'),
(7, 1, '14:30:00'),
(8, 1, '15:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `precio` float NOT NULL,
  `nombre` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`id`, `fecha`, `precio`, `nombre`, `stock`) VALUES
(1, '2016-10-08', 51.1, 'Milanesa con Puré', 180),
(3, '2016-10-08', 50, 'Milanesa con Puré', 300),
(4, '2016-10-06', 50.9, 'Bife a la Criolla1', 101);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `id` int(11) NOT NULL,
  `sucursal` int(11) NOT NULL,
  `total` float NOT NULL,
  `cliente_nombre` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `cliente_telefono` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `cliente_direccion` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `cliente_email` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `envio` tinyint(1) NOT NULL,
  `pedido` varchar(250) COLLATE latin1_spanish_ci NOT NULL,
  `cantidad_menus` int(11) NOT NULL,
  `hora` time NOT NULL,
  `estado` smallint(1) NOT NULL DEFAULT '0',
  `marca_temporal` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`id`, `sucursal`, `total`, `cliente_nombre`, `cliente_telefono`, `cliente_direccion`, `cliente_email`, `envio`, `pedido`, `cantidad_menus`, `hora`, `estado`, `marca_temporal`) VALUES
(3, 1, 303.1, 'Augusto Jair', '0282', 'av olmos 238', 'a@gmail.com', 1, '- 3 Milanesa con Puré: $153\r\n- 1 Milanesa con Puré: $50\r\n', 6, '13:00:00', 0, '2016-10-10 19:32:24'),
(4, 1, 101, 'ckhsd', '93', 'kndfieah', 'a@gmail.com', 0, '- 1 Milanesa con Puré: $51\r\n- 0 Milanesa con Puré: $0\r\n', 2, '15:00:00', 3, '2016-10-07 14:36:04'),
(5, 1, 101, 'ckhsd', '93', 'kndfieah', 'a@gmail.com', 0, '- 1 Milanesa con Puré: $51\r\n- 0 Milanesa con Puré: $0\r\n', 2, '15:00:00', 4, '2016-10-07 14:37:24'),
(6, 1, 101, 'ckhsd', '93', 'kndfieah', 'a@gmail.com', 0, '- 1 Milanesa con Puré: $51\r\n- 0 Milanesa con Puré: $0\r\n', 2, '15:00:00', 4, '2016-10-07 14:38:25'),
(7, 1, 101, 'ckhsd', '93', 'kndfieah', 'a@gmail.com', 0, '- 1 Milanesa con Puré: $51\r\n- 0 Milanesa con Puré: $0\r\n', 2, '15:00:00', 3, '2016-10-07 14:39:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursales`
--

CREATE TABLE `sucursales` (
  `id` int(11) NOT NULL,
  `direccion` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `password` varchar(32) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `sucursales`
--

INSERT INTO `sucursales` (`id`, `direccion`, `password`) VALUES
(1, 'Rosario Santa Fe 100', '827ccb0eea8a706c4c34a16891f84e7b');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventasAdicionales`
--

CREATE TABLE `ventasAdicionales` (
  `id` int(11) NOT NULL,
  `total` float NOT NULL,
  `cantMenus` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sucursal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `ventasAdicionales`
--

INSERT INTO `ventasAdicionales` (`id`, `total`, `cantMenus`, `fecha`, `sucursal`) VALUES
(1, 255.5, 5, '2016-10-10 13:22:27', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sucursales`
--
ALTER TABLE `sucursales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventasAdicionales`
--
ALTER TABLE `ventasAdicionales`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `horarios`
--
ALTER TABLE `horarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `sucursales`
--
ALTER TABLE `sucursales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `ventasAdicionales`
--
ALTER TABLE `ventasAdicionales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
