-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 05-04-2025 a las 18:05:55
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
-- Base de datos: `cenefco`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `certificados`
--

CREATE TABLE `certificados` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `precioIndividual` int(11) NOT NULL,
  `precioCurso` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `fechaEmision` date NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chatbot`
--

CREATE TABLE `chatbot` (
  `id` int(11) NOT NULL,
  `mensaje` text DEFAULT NULL,
  `contenido` text NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentario`
--

CREATE TABLE `comentario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `asunto` varchar(100) NOT NULL,
  `mensaje` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `docente` varchar(100) DEFAULT NULL,
  `categoria` varchar(100) DEFAULT NULL,
  `descripcion` longtext NOT NULL,
  `precio` varchar(11) NOT NULL,
  `fechaInicio` date DEFAULT NULL,
  `fechaFin` date DEFAULT NULL,
  `imagen` varchar(100) DEFAULT NULL,
  `grupoFacebook` varchar(100) DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `mostrarInicio` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docentes`
--

CREATE TABLE `docentes` (
  `id` int(11) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `firma` varchar(100) DEFAULT NULL,
  `curriculum` varchar(100) DEFAULT NULL,
  `telefono` varchar(100) NOT NULL,
  `estadoCivil` varchar(100) NOT NULL,
  `direccionDomicilio` varchar(100) DEFAULT NULL,
  `universidad` varchar(100) NOT NULL,
  `observacion` text NOT NULL,
  `carnet` varchar(15) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes`
--

CREATE TABLE `estudiantes` (
  `id` int(11) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `carnet` varchar(50) NOT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `telefono` varchar(100) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `direccionDomicilio` varchar(50) DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `id` int(11) NOT NULL DEFAULT 0,
  `titulo` varchar(100) NOT NULL,
  `docente` varchar(100) DEFAULT NULL,
  `categoria` varchar(100) DEFAULT NULL,
  `descripcion` longtext NOT NULL,
  `precio` varchar(11) NOT NULL,
  `fechaInicio` date DEFAULT NULL,
  `fechaFin` date DEFAULT NULL,
  `imagen` varchar(100) DEFAULT NULL,
  `grupoFacebook` varchar(100) DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `mostrarInicio` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `cantidad` int(100) NOT NULL,
  `fechaAdquisicion` date NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `role` varchar(50) DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `correo`, `role`, `created_at`) VALUES
(6, 'alvaroq', '$2y$10$9nDgSreT22pOdNz1dWxpoeGCsVLijjEkTml/GFZHxxEL1HswJCL4O', 'alva1@gmail.com', 'user', '2025-03-05 22:01:43'),
(7, 'alvaro1', '$2y$10$sfiH.pu2Q009n82CFlADuO25isfLqBU8qej4fU02NN1thosbvyfEO', 'alvaq1@gmail.com', 'user', '2025-03-05 22:14:56'),
(8, 'juan', '$2y$10$KT3Fg1YOCOUBbmxysjBHE.cLS.C2qxYpqk5lIZemoD15Bd1ytTJLm', 'juan@gmail.com', 'user', '2025-03-05 22:20:50'),
(9, 'Alvaro Medrnao', '$2y$10$QlyO6FvgJe2thp1SI1F/xeksH285Y1VBEuX5i725wQR.VQEaIjdVy', 'aljak@123.com', 'user', '2025-03-07 01:18:38'),
(10, 'unico', '$2y$10$gQS/qm5ZX2SeKqQoCDXbB.uKTNG.WrhqxbjtyB0wFhH/q9saerf0W', 'unico@gmai.com', 'user', '2025-03-07 01:28:32'),
(12, 'asdf', '$2y$10$seuu2I/w73TjWVmmJ/PauOWOWZd6XiVAiHPoE5rvfdTnsSmHaYnrC', 'asdf@gmail.com', 'user', '2025-03-07 01:37:36'),
(14, 'un', '$2y$10$rfuKF5kSGfu57pWOfyteYO0grOHENVJI/YCcL/10zLo.0qVXADc4.', 'un@gmail.com', 'user', '2025-03-07 01:50:38'),
(15, 'Adminsitrador', '$2y$12$CD0QKfgr5fTzMqUlkNtP/O9tzTbFRJXD8uGwudNxUeVDdULIc4QMO', 'administrador@gmail.com', 'Administrador', '2025-03-08 01:12:59'),
(25, 'Administrador', '$2y$12$BfsaRB8pnTJetOpZTHZzROkY5VMHY5r5WePCJMQgU0hBpqUnV4ywC', 'admin@gmail.com', 'Administrador', '2025-03-10 22:45:33'),
(26, 'Ventas', '1234Qwer', 'ventas@gmail.com', 'Vendedor', '2025-03-26 12:31:15'),
(27, 'ventas@gmail.com', '1234qwer', 'ventas1@gmail.com', 'Vendedor', '2025-03-26 12:32:58'),
(28, 'vendedor', '$2y$12$hkCkA7aUL4B5O4jrrk5aie0rqeEK4942XvWBsdmqiwFENw856c.86', 'venta@gmail.com', 'Vendedor', '2025-03-26 12:33:52'),
(29, 'vendedor', '$2y$12$DVZsSA.2CLMXMN0THRC/..YgCoaKQtZvvu/EnppTJEUcBIx7j23b6', 'vendedor@gmail.com', 'Vendedor', '2025-03-26 12:41:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `id_curso` int(11) DEFAULT NULL,
  `id_certificado` int(11) DEFAULT NULL,
  `id_estudiante` int(11) DEFAULT NULL,
  `comprobante` varchar(255) DEFAULT NULL,
  `externoNombre` varchar(100) DEFAULT NULL,
  `externoCarnet` varchar(100) DEFAULT NULL,
  `precio` decimal(11,0) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `tipo` varchar(100) NOT NULL,
  `user` varchar(100) NOT NULL,
  `createt_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `certificados`
--
ALTER TABLE `certificados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `chatbot`
--
ALTER TABLE `chatbot`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `docentes`
--
ALTER TABLE `docentes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_curso` (`id_curso`),
  ADD KEY `fk_certificado` (`id_certificado`),
  ADD KEY `fk_estudiante` (`id_estudiante`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `certificados`
--
ALTER TABLE `certificados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `chatbot`
--
ALTER TABLE `chatbot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `comentario`
--
ALTER TABLE `comentario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `docentes`
--
ALTER TABLE `docentes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `fk_certificado` FOREIGN KEY (`id_certificado`) REFERENCES `certificados` (`id`),
  ADD CONSTRAINT `fk_curso` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id`),
  ADD CONSTRAINT `fk_estudiante` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiantes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
