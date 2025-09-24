-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-09-2025 a las 20:41:15
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
-- Base de datos: `activus_db`
--
CREATE DATABASE IF NOT EXISTS `activus_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `activus_db`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia`
--

DROP TABLE IF EXISTS `asistencia`;
CREATE TABLE `asistencia` (
  `ID_Asistencia` int(11) NOT NULL,
  `ID_Socio` int(11) NOT NULL,
  `ID_Clase_Programada` int(11) DEFAULT NULL,
  `Fecha` date DEFAULT NULL,
  `Hora` time DEFAULT NULL,
  `Resultado` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asistencia`
--

INSERT INTO `asistencia` (`ID_Asistencia`, `ID_Socio`, `ID_Clase_Programada`, `Fecha`, `Hora`, `Resultado`) VALUES
(1, 6, NULL, '2025-09-25', '18:05:00', 'Permitido'),
(2, 8, NULL, '2025-09-25', '18:10:00', 'Denegado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `certificado`
--

DROP TABLE IF EXISTS `certificado`;
CREATE TABLE `certificado` (
  `ID_Certificado` int(11) NOT NULL,
  `ID_Usuario` int(11) DEFAULT NULL,
  `Imagen_Certificado` varchar(255) DEFAULT NULL,
  `Aprobado` tinyint(1) DEFAULT NULL,
  `Fecha_Emision` date NOT NULL,
  `Fecha_Vencimiento` date DEFAULT NULL,
  `Fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clase`
--

DROP TABLE IF EXISTS `clase`;
CREATE TABLE `clase` (
  `ID_Clase` int(11) NOT NULL,
  `ID_Profesor` int(11) DEFAULT NULL,
  `ID_Usuario` int(11) DEFAULT NULL,
  `Nombre_Clase` varchar(100) DEFAULT NULL,
  `Capacidad_Maxima` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clase`
--

INSERT INTO `clase` (`ID_Clase`, `ID_Profesor`, `ID_Usuario`, `Nombre_Clase`, `Capacidad_Maxima`) VALUES
(1, 1, 3, 'Zumba', 25),
(2, 2, 5, 'Spinning', 20);

--
-- Disparadores `clase`
--
DROP TRIGGER IF EXISTS `trg_clase_profesor_ins`;
DELIMITER $$
CREATE TRIGGER `trg_clase_profesor_ins` BEFORE INSERT ON `clase` FOR EACH ROW BEGIN
  IF NEW.ID_Profesor IS NULL THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'ID_Profesor obligatorio';
  END IF;

  IF NOT EXISTS (
    SELECT 1
    FROM Usuario_Rol ur
    JOIN Rol r ON r.ID_Rol = ur.ID_Rol
    WHERE ur.ID_Usuario = NEW.ID_Profesor
      AND r.Nombre = 'Profesor'
  ) THEN
    SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'El ID_Profesor debe ser un Usuario con rol Profesor';
  END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `trg_clase_profesor_upd`;
DELIMITER $$
CREATE TRIGGER `trg_clase_profesor_upd` BEFORE UPDATE ON `clase` FOR EACH ROW BEGIN
  IF NEW.ID_Profesor IS NULL THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'ID_Profesor obligatorio';
  END IF;

  IF NOT EXISTS (
    SELECT 1
    FROM Usuario_Rol ur
    JOIN Rol r ON r.ID_Rol = ur.ID_Rol
    WHERE ur.ID_Usuario = NEW.ID_Profesor
      AND r.Nombre = 'Profesor'
  ) THEN
    SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'El ID_Profesor debe ser un Usuario con rol Profesor';
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clase_programada`
--

DROP TABLE IF EXISTS `clase_programada`;
CREATE TABLE `clase_programada` (
  `ID_Clase_Programada` int(11) NOT NULL,
  `ID_Clase` int(11) DEFAULT NULL,
  `ID_Sala` int(11) DEFAULT NULL,
  `Fecha` date DEFAULT NULL,
  `Hora_Inicio` time DEFAULT NULL,
  `Hora_Fin` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clase_programada`
--

INSERT INTO `clase_programada` (`ID_Clase_Programada`, `ID_Clase`, `ID_Sala`, `Fecha`, `Hora_Inicio`, `Hora_Fin`) VALUES
(1, 1, 3, '2025-09-25', '18:00:00', '19:00:00'),
(2, 2, 2, '2025-09-26', '19:00:00', '20:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion_gym`
--

DROP TABLE IF EXISTS `configuracion_gym`;
CREATE TABLE `configuracion_gym` (
  `ID_Configuracion_Gym` int(11) NOT NULL,
  `ID_Usuario` int(11) DEFAULT NULL,
  `Ubicacion` varchar(255) DEFAULT NULL,
  `Nombre_Gym` varchar(100) DEFAULT NULL,
  `Logo_PNG` varchar(255) DEFAULT NULL,
  `Color_Fondo` varchar(50) DEFAULT NULL,
  `Color_Elemento` varchar(50) DEFAULT NULL,
  `ID_Admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejercicio`
--

DROP TABLE IF EXISTS `ejercicio`;
CREATE TABLE `ejercicio` (
  `ID_Ejercicio` int(11) NOT NULL,
  `Nombre_Ejercicio` varchar(100) NOT NULL,
  `Descripcion` text DEFAULT NULL,
  `Tips` text DEFAULT NULL,
  `Instrucciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ejercicio`
--

INSERT INTO `ejercicio` (`ID_Ejercicio`, `Nombre_Ejercicio`, `Descripcion`, `Tips`, `Instrucciones`) VALUES
(1, 'Sentadillas', 'Ejercicio para tren inferior', 'Mantener espalda recta', 'Flexionar rodillas y bajar'),
(2, 'Press banca', 'Ejercicio para pecho', 'Usar peso adecuado', 'Bajar barra hasta el pecho y subir'),
(3, 'Curl bíceps', 'Ejercicio para brazos', 'No balancear el cuerpo', 'Flexionar codo levantando mancuerna'),
(4, 'Plancha', 'Ejercicio isométrico para abdomen', 'Mantener alineación corporal', 'Sostener posición con abdomen contraído'),
(5, 'Peso muerto', 'Ejercicio para tren inferior y espalda baja', 'Mantener la barra cerca del cuerpo', 'Flexionar la cadera y levantar la barra con la espalda recta'),
(6, 'Dominadas', 'Ejercicio de espalda y brazos', 'No balancear el cuerpo', 'Colgarse de la barra y elevar el cuerpo hasta que la barbilla pase la barra'),
(7, 'Press militar', 'Ejercicio de hombros', 'Mantener abdomen contraído', 'Empujar la barra o mancuernas hacia arriba desde los hombros'),
(8, 'Crunch abdominal', 'Ejercicio básico de abdomen', 'No tirar del cuello', 'Flexionar el tronco llevando el pecho hacia las rodillas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejercicio_equipo`
--

DROP TABLE IF EXISTS `ejercicio_equipo`;
CREATE TABLE `ejercicio_equipo` (
  `ID_Ejercicio` int(11) NOT NULL,
  `ID_Equipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ejercicio_equipo`
--

INSERT INTO `ejercicio_equipo` (`ID_Ejercicio`, `ID_Equipo`) VALUES
(1, 7),
(2, 2),
(3, 1),
(4, 6),
(5, 2),
(6, 7),
(7, 1),
(8, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejercicio_musculo`
--

DROP TABLE IF EXISTS `ejercicio_musculo`;
CREATE TABLE `ejercicio_musculo` (
  `ID_Ejercicio` int(11) NOT NULL,
  `ID_Musculo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ejercicio_musculo`
--

INSERT INTO `ejercicio_musculo` (`ID_Ejercicio`, `ID_Musculo`) VALUES
(1, 7),
(2, 1),
(3, 4),
(4, 6),
(5, 2),
(5, 7),
(6, 2),
(6, 4),
(7, 3),
(8, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo`
--

DROP TABLE IF EXISTS `equipo`;
CREATE TABLE `equipo` (
  `ID_Equipo` int(11) NOT NULL,
  `Nombre_Equipo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `equipo`
--

INSERT INTO `equipo` (`ID_Equipo`, `Nombre_Equipo`) VALUES
(1, 'Mancuernas'),
(2, 'Barra Olímpica'),
(3, 'Cinta de correr'),
(4, 'Bicicleta fija'),
(5, 'Máquina de poleas'),
(6, 'Colchoneta'),
(7, 'Peso corporal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_membresia_socio`
--

DROP TABLE IF EXISTS `estado_membresia_socio`;
CREATE TABLE `estado_membresia_socio` (
  `ID_Estado_Membresia_Socio` int(11) NOT NULL,
  `Nombre_Estado_Membresia_Socio` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado_membresia_socio`
--

INSERT INTO `estado_membresia_socio` (`ID_Estado_Membresia_Socio`, `Nombre_Estado_Membresia_Socio`) VALUES
(1, 'Activa'),
(2, 'Vencida'),
(3, 'Pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_usuario`
--

DROP TABLE IF EXISTS `estado_usuario`;
CREATE TABLE `estado_usuario` (
  `ID_Estado_Usuario` int(11) NOT NULL,
  `Nombre_Estado_Usuario` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado_usuario`
--

INSERT INTO `estado_usuario` (`ID_Estado_Usuario`, `Nombre_Estado_Usuario`) VALUES
(1, 'Activo'),
(2, 'Inactivo'),
(3, 'Suspendido');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario_funcionamiento`
--

DROP TABLE IF EXISTS `horario_funcionamiento`;
CREATE TABLE `horario_funcionamiento` (
  `ID_Horario_Funcionamiento` int(11) NOT NULL,
  `ID_Configuracion_Gym` int(11) DEFAULT NULL,
  `Dia_Semana` varchar(20) DEFAULT NULL,
  `Hora_Apertura` time DEFAULT NULL,
  `Hora_Cierre` time DEFAULT NULL,
  `Habilitacion` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `membresia_socio`
--

DROP TABLE IF EXISTS `membresia_socio`;
CREATE TABLE `membresia_socio` (
  `ID_Membresia_Socio` int(11) NOT NULL,
  `ID_Usuario` int(11) DEFAULT NULL,
  `ID_Tipo_Membresia` int(11) DEFAULT NULL,
  `ID_Estado_Membresia_Socio` int(11) DEFAULT NULL,
  `Fecha_Inicio` date DEFAULT NULL,
  `Fecha_Fin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `membresia_socio`
--

INSERT INTO `membresia_socio` (`ID_Membresia_Socio`, `ID_Usuario`, `ID_Tipo_Membresia`, `ID_Estado_Membresia_Socio`, `Fecha_Inicio`, `Fecha_Fin`) VALUES
(1, 6, 1, 1, '2025-09-01', '2025-09-30'),
(2, 7, 2, 1, '2025-09-01', '2025-11-30'),
(3, 8, 3, 1, '2025-01-01', '2025-12-31'),
(4, 9, 1, 1, '2025-09-01', '2025-09-30'),
(5, 10, 2, 1, '2025-09-01', '2025-11-30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `musculo`
--

DROP TABLE IF EXISTS `musculo`;
CREATE TABLE `musculo` (
  `ID_Musculo` int(11) NOT NULL,
  `Nombre_Musculo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `musculo`
--

INSERT INTO `musculo` (`ID_Musculo`, `Nombre_Musculo`) VALUES
(1, 'Pecho'),
(2, 'Espalda'),
(3, 'Hombros'),
(4, 'Bíceps'),
(5, 'Tríceps'),
(6, 'Abdomen'),
(7, 'Piernas'),
(8, 'Glúteos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nivel_dificultad`
--

DROP TABLE IF EXISTS `nivel_dificultad`;
CREATE TABLE `nivel_dificultad` (
  `ID_Nivel_Dificultad` int(11) NOT NULL,
  `Nombre_Nivel_Dificultad` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `nivel_dificultad`
--

INSERT INTO `nivel_dificultad` (`ID_Nivel_Dificultad`, `Nombre_Nivel_Dificultad`) VALUES
(1, 'Básico'),
(2, 'Intermedio'),
(3, 'Avanzado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

DROP TABLE IF EXISTS `pago`;
CREATE TABLE `pago` (
  `ID_Pago` int(11) NOT NULL,
  `ID_Membresia_Socio` int(11) DEFAULT NULL,
  `ID_Usuario` int(11) DEFAULT NULL,
  `ID_Usuario_Registro` int(11) NOT NULL,
  `Fecha_Pago` date NOT NULL DEFAULT curdate(),
  `Hora_Pago` time NOT NULL DEFAULT curtime(),
  `Monto` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pago`
--

INSERT INTO `pago` (`ID_Pago`, `ID_Membresia_Socio`, `ID_Usuario`, `ID_Usuario_Registro`, `Fecha_Pago`, `Hora_Pago`, `Monto`) VALUES
(6, 1, 6, 0, '2025-09-01', '23:53:41', 10000.00),
(7, 2, 7, 0, '2025-09-01', '23:53:41', 27000.00),
(8, 3, 8, 0, '2025-01-01', '23:53:41', 95000.00),
(9, 4, 9, 0, '2025-09-01', '23:53:41', 10000.00),
(10, 5, 10, 0, '2025-09-01', '23:53:41', 27000.00);

--
-- Disparadores `pago`
--
DROP TRIGGER IF EXISTS `trg_pago_admin_ins`;
DELIMITER $$
CREATE TRIGGER `trg_pago_admin_ins` BEFORE INSERT ON `pago` FOR EACH ROW BEGIN
  IF NOT EXISTS (
      SELECT 1
      FROM Usuario_Rol ur
      JOIN Rol r ON ur.ID_Rol = r.ID_Rol
      WHERE ur.ID_Usuario = NEW.ID_Usuario_Registro
      AND r.Nombre = 'Administrativo'
  ) THEN
    SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'El ID_Usuario_Registro debe ser un Usuario con rol Administrativo';
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

DROP TABLE IF EXISTS `permiso`;
CREATE TABLE `permiso` (
  `ID_Permiso` int(11) NOT NULL,
  `Nombre_Permiso` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `permiso`
--

INSERT INTO `permiso` (`ID_Permiso`, `Nombre_Permiso`) VALUES
(1, 'Gestionar Usuarios'),
(2, 'Gestionar Clases'),
(3, 'Gestionar Rutinas'),
(4, 'Registrar Asistencia'),
(5, 'Gestionar Pagos'),
(6, 'Ver Reportes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserva`
--

DROP TABLE IF EXISTS `reserva`;
CREATE TABLE `reserva` (
  `ID_Reserva` int(11) NOT NULL,
  `ID_Clase_Programada` int(11) NOT NULL,
  `ID_Socio` int(11) NOT NULL,
  `Fecha_Reserva` date DEFAULT curdate(),
  `Estado_Reserva` enum('Pendiente','Confirmada','Cancelada') NOT NULL DEFAULT 'Pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reserva`
--

INSERT INTO `reserva` (`ID_Reserva`, `ID_Clase_Programada`, `ID_Socio`, `Fecha_Reserva`, `Estado_Reserva`) VALUES
(1, 1, 6, '2025-09-23', 'Pendiente'),
(2, 2, 7, '2025-09-23', 'Pendiente');

--
-- Disparadores `reserva`
--
DROP TRIGGER IF EXISTS `trg_reserva_unica`;
DELIMITER $$
CREATE TRIGGER `trg_reserva_unica` BEFORE INSERT ON `reserva` FOR EACH ROW BEGIN
  IF EXISTS (
      SELECT 1
      FROM Reserva r
      WHERE r.ID_Socio = NEW.ID_Socio
      AND r.ID_Clase_Programada = NEW.ID_Clase_Programada
  ) THEN
    SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'El socio ya tiene una reserva para esta clase';
  END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `trg_validar_capacidad_reserva`;
DELIMITER $$
CREATE TRIGGER `trg_validar_capacidad_reserva` BEFORE INSERT ON `reserva` FOR EACH ROW BEGIN
    DECLARE cupo_actual INT;
    DECLARE capacidad_max INT;

    -- Contar cuántas reservas existen para la clase programada
    SELECT COUNT(*)
    INTO cupo_actual
    FROM Reserva
    WHERE ID_Clase_Programada = NEW.ID_Clase_Programada;

    -- Obtener la capacidad máxima de la clase
    SELECT c.Capacidad_Maxima
    INTO capacidad_max
    FROM Clase_Programada cp
    JOIN Clase c ON cp.ID_Clase = c.ID_Clase
    WHERE cp.ID_Clase_Programada = NEW.ID_Clase_Programada;

    -- Validar que no supere el cupo
    IF cupo_actual >= capacidad_max THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = '⚠️ No se puede reservar: la clase ya alcanzó su capacidad máxima';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

DROP TABLE IF EXISTS `rol`;
CREATE TABLE `rol` (
  `ID_Rol` int(11) NOT NULL,
  `Nombre_Rol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`ID_Rol`, `Nombre_Rol`) VALUES
(1, 'Administrador'),
(2, 'Profesor'),
(3, 'Administrativo'),
(4, 'Socio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_permiso`
--

DROP TABLE IF EXISTS `rol_permiso`;
CREATE TABLE `rol_permiso` (
  `ID_Rol` int(11) NOT NULL,
  `ID_Permiso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rutina`
--

DROP TABLE IF EXISTS `rutina`;
CREATE TABLE `rutina` (
  `ID_Rutina` int(11) NOT NULL,
  `ID_Usuario` int(11) DEFAULT NULL,
  `ID_Nivel_Dificultad` int(11) DEFAULT NULL,
  `Nombre_Rutina` varchar(100) DEFAULT NULL,
  `Duracion_Aprox` int(11) DEFAULT NULL,
  `Cant_Dias_Semana` int(11) DEFAULT NULL,
  `Descripcion` text DEFAULT NULL,
  `ID_Profesor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rutina_ejercicio`
--

DROP TABLE IF EXISTS `rutina_ejercicio`;
CREATE TABLE `rutina_ejercicio` (
  `ID_Rutina` int(11) NOT NULL,
  `ID_Ejercicio` int(11) NOT NULL,
  `Series` int(11) DEFAULT NULL,
  `Repeticiones` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sala`
--

DROP TABLE IF EXISTS `sala`;
CREATE TABLE `sala` (
  `ID_Sala` int(11) NOT NULL,
  `Nombre_Sala` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sala`
--

INSERT INTO `sala` (`ID_Sala`, `Nombre_Sala`) VALUES
(1, 'Sala Musculación'),
(2, 'Sala Cardio'),
(3, 'Sala Clases Grupales');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `socio`
--

DROP TABLE IF EXISTS `socio`;
CREATE TABLE `socio` (
  `ID_Usuario` int(11) NOT NULL,
  `Fecha_Nacimiento` date DEFAULT NULL,
  `Fecha_Alta` date NOT NULL DEFAULT curdate(),
  `Hora_Alta` time NOT NULL DEFAULT curtime()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `socio`
--

INSERT INTO `socio` (`ID_Usuario`, `Fecha_Nacimiento`, `Fecha_Alta`, `Hora_Alta`) VALUES
(6, '2000-01-01', '2025-09-24', '10:24:10'),
(7, '2000-02-02', '2025-09-24', '10:24:10'),
(8, '2000-03-03', '2025-09-24', '10:24:10'),
(9, '2000-04-04', '2025-09-24', '10:24:10'),
(10, '2000-05-05', '2025-09-24', '10:24:10'),
(11, '2010-05-15', '2025-09-24', '10:24:10'),
(12, '2015-03-15', '2025-09-24', '10:24:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_membresia`
--

DROP TABLE IF EXISTS `tipo_membresia`;
CREATE TABLE `tipo_membresia` (
  `ID_Tipo_Membresia` int(11) NOT NULL,
  `Nombre_Tipo_Membresia` varchar(50) NOT NULL,
  `Duracion` int(11) NOT NULL,
  `Precio` decimal(10,2) NOT NULL,
  `Descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_membresia`
--

INSERT INTO `tipo_membresia` (`ID_Tipo_Membresia`, `Nombre_Tipo_Membresia`, `Duracion`, `Precio`, `Descripcion`) VALUES
(1, 'Mensual', 30, 10000.00, 'Acceso ilimitado por un mes'),
(2, 'Trimestral', 90, 27000.00, 'Acceso ilimitado por tres meses'),
(3, 'Anual', 365, 95000.00, 'Acceso ilimitado por un año');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tutor`
--

DROP TABLE IF EXISTS `tutor`;
CREATE TABLE `tutor` (
  `ID_Tutor` int(11) NOT NULL,
  `ID_Socio` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Apellido` varchar(100) NOT NULL,
  `DNI` varchar(20) NOT NULL,
  `Telefono` varchar(20) DEFAULT NULL,
  `Relacion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tutor`
--

INSERT INTO `tutor` (`ID_Tutor`, `ID_Socio`, `Nombre`, `Apellido`, `DNI`, `Telefono`, `Relacion`) VALUES
(1, 11, 'Carolina', 'Gómez', '28123456', '1144556677', 'Madre'),
(2, 12, 'Martina', 'Gómez', '50111222', '1160001111', 'Madre');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `ID_Usuario` int(11) NOT NULL,
  `ID_Estado_Usuario` int(11) DEFAULT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Apellido` varchar(50) NOT NULL,
  `Contrasena` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `DNI` varchar(20) DEFAULT NULL,
  `Foto_Perfil` varchar(255) DEFAULT NULL,
  `Telefono` varchar(20) DEFAULT NULL,
  `Fecha_Alta` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`ID_Usuario`, `ID_Estado_Usuario`, `Nombre`, `Apellido`, `Contrasena`, `Email`, `DNI`, `Foto_Perfil`, `Telefono`, `Fecha_Alta`) VALUES
(1, 1, 'Admin', 'General', '1234', 'admin@activus.com', '90000001', NULL, '0001', '2025-09-23'),
(2, 1, 'Recepcion', 'General', '1234', 'recepcion@activus.com', '90000002', NULL, '0002', '2025-09-23'),
(3, 1, 'Profesor', 'General', '1234', 'profe@activus.com', '90000003', NULL, '0003', '2025-09-23'),
(4, 1, 'Socio', 'Demo', '1234', 'socio@activus.com', '90000004', NULL, '0004', '2025-09-23'),
(5, 1, 'Super', 'Usuario', '1234', 'super@activus.com', '90000005', NULL, '0005', '2025-09-23'),
(6, 1, 'Esmilce', 'Mendoza', '1234', 'esmile@example.com', '11111111', NULL, '1111-1111', '2025-09-23'),
(7, 1, 'Miqueas', 'Chavez', '1234', 'miqueas@example.com', '22222222', NULL, '2222-2222', '2025-09-23'),
(8, 1, 'Daniel', 'Vidal', '1234', 'daniel@example.com', '33333333', NULL, '3333-3333', '2025-09-23'),
(9, 1, 'Sasha', 'Medina', '1234', 'sasha@example.com', '44444444', NULL, '4444-4444', '2025-09-23'),
(10, 1, 'Camila', 'Villasboa', '1234', 'camila@example.com', '55555555', NULL, '5555-5555', '2025-09-23'),
(11, 1, 'Martina', 'Gómez', 'pass123', 'martina.gomez@example.com', '50111222', NULL, '1166778899', '2025-09-23'),
(12, NULL, 'Juan', 'Pérez', '', 'juan.perez@example.com', '60111222', NULL, NULL, '2025-09-24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_rol`
--

DROP TABLE IF EXISTS `usuario_rol`;
CREATE TABLE `usuario_rol` (
  `ID_Usuario` int(11) NOT NULL,
  `ID_Rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario_rol`
--

INSERT INTO `usuario_rol` (`ID_Usuario`, `ID_Rol`) VALUES
(1, 1),
(2, 3),
(3, 2),
(4, 4),
(5, 1),
(5, 2),
(5, 3),
(5, 4),
(6, 4),
(7, 4),
(8, 4),
(9, 4),
(10, 4);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD PRIMARY KEY (`ID_Asistencia`),
  ADD KEY `fk_asistencia_clase` (`ID_Clase_Programada`),
  ADD KEY `fk_asistencia_socio` (`ID_Socio`);

--
-- Indices de la tabla `certificado`
--
ALTER TABLE `certificado`
  ADD PRIMARY KEY (`ID_Certificado`),
  ADD KEY `fk_certificado_usuario` (`ID_Usuario`);

--
-- Indices de la tabla `clase`
--
ALTER TABLE `clase`
  ADD PRIMARY KEY (`ID_Clase`);

--
-- Indices de la tabla `clase_programada`
--
ALTER TABLE `clase_programada`
  ADD PRIMARY KEY (`ID_Clase_Programada`),
  ADD KEY `ID_Clase` (`ID_Clase`),
  ADD KEY `ID_Sala` (`ID_Sala`);

--
-- Indices de la tabla `configuracion_gym`
--
ALTER TABLE `configuracion_gym`
  ADD PRIMARY KEY (`ID_Configuracion_Gym`),
  ADD KEY `ID_Usuario` (`ID_Usuario`),
  ADD KEY `fk_config_admin` (`ID_Admin`);

--
-- Indices de la tabla `ejercicio`
--
ALTER TABLE `ejercicio`
  ADD PRIMARY KEY (`ID_Ejercicio`);

--
-- Indices de la tabla `ejercicio_equipo`
--
ALTER TABLE `ejercicio_equipo`
  ADD PRIMARY KEY (`ID_Ejercicio`,`ID_Equipo`),
  ADD KEY `ID_Equipo` (`ID_Equipo`);

--
-- Indices de la tabla `ejercicio_musculo`
--
ALTER TABLE `ejercicio_musculo`
  ADD PRIMARY KEY (`ID_Ejercicio`,`ID_Musculo`),
  ADD KEY `ID_Musculo` (`ID_Musculo`);

--
-- Indices de la tabla `equipo`
--
ALTER TABLE `equipo`
  ADD PRIMARY KEY (`ID_Equipo`);

--
-- Indices de la tabla `estado_membresia_socio`
--
ALTER TABLE `estado_membresia_socio`
  ADD PRIMARY KEY (`ID_Estado_Membresia_Socio`);

--
-- Indices de la tabla `estado_usuario`
--
ALTER TABLE `estado_usuario`
  ADD PRIMARY KEY (`ID_Estado_Usuario`);

--
-- Indices de la tabla `horario_funcionamiento`
--
ALTER TABLE `horario_funcionamiento`
  ADD PRIMARY KEY (`ID_Horario_Funcionamiento`),
  ADD KEY `ID_Configuracion_Gym` (`ID_Configuracion_Gym`);

--
-- Indices de la tabla `membresia_socio`
--
ALTER TABLE `membresia_socio`
  ADD PRIMARY KEY (`ID_Membresia_Socio`),
  ADD KEY `ID_Tipo_Membresia` (`ID_Tipo_Membresia`),
  ADD KEY `ID_Estado_Membresia_Socio` (`ID_Estado_Membresia_Socio`),
  ADD KEY `fk_membresia_socio_usuario` (`ID_Usuario`);

--
-- Indices de la tabla `musculo`
--
ALTER TABLE `musculo`
  ADD PRIMARY KEY (`ID_Musculo`);

--
-- Indices de la tabla `nivel_dificultad`
--
ALTER TABLE `nivel_dificultad`
  ADD PRIMARY KEY (`ID_Nivel_Dificultad`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`ID_Pago`),
  ADD KEY `ID_Membresia_Socio` (`ID_Membresia_Socio`),
  ADD KEY `fk_pago_usuario_registro` (`ID_Usuario_Registro`),
  ADD KEY `fk_pago_usuario` (`ID_Usuario`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`ID_Permiso`);

--
-- Indices de la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`ID_Reserva`),
  ADD KEY `fk_reserva_socio_usuario` (`ID_Socio`),
  ADD KEY `fk_reserva_clase_prog` (`ID_Clase_Programada`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`ID_Rol`);

--
-- Indices de la tabla `rol_permiso`
--
ALTER TABLE `rol_permiso`
  ADD PRIMARY KEY (`ID_Rol`,`ID_Permiso`),
  ADD KEY `ID_Permiso` (`ID_Permiso`);

--
-- Indices de la tabla `rutina`
--
ALTER TABLE `rutina`
  ADD PRIMARY KEY (`ID_Rutina`),
  ADD KEY `ID_Usuario` (`ID_Usuario`),
  ADD KEY `ID_Nivel_Dificultad` (`ID_Nivel_Dificultad`),
  ADD KEY `fk_rutina_profesor` (`ID_Profesor`);

--
-- Indices de la tabla `rutina_ejercicio`
--
ALTER TABLE `rutina_ejercicio`
  ADD PRIMARY KEY (`ID_Rutina`,`ID_Ejercicio`),
  ADD KEY `ID_Ejercicio` (`ID_Ejercicio`);

--
-- Indices de la tabla `sala`
--
ALTER TABLE `sala`
  ADD PRIMARY KEY (`ID_Sala`);

--
-- Indices de la tabla `socio`
--
ALTER TABLE `socio`
  ADD PRIMARY KEY (`ID_Usuario`);

--
-- Indices de la tabla `tipo_membresia`
--
ALTER TABLE `tipo_membresia`
  ADD PRIMARY KEY (`ID_Tipo_Membresia`);

--
-- Indices de la tabla `tutor`
--
ALTER TABLE `tutor`
  ADD PRIMARY KEY (`ID_Tutor`),
  ADD KEY `fk_tutor_socio` (`ID_Socio`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`ID_Usuario`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `DNI` (`DNI`),
  ADD KEY `ID_Estado_Usuario` (`ID_Estado_Usuario`);

--
-- Indices de la tabla `usuario_rol`
--
ALTER TABLE `usuario_rol`
  ADD PRIMARY KEY (`ID_Usuario`,`ID_Rol`),
  ADD KEY `ID_Rol` (`ID_Rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  MODIFY `ID_Asistencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `certificado`
--
ALTER TABLE `certificado`
  MODIFY `ID_Certificado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clase`
--
ALTER TABLE `clase`
  MODIFY `ID_Clase` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `clase_programada`
--
ALTER TABLE `clase_programada`
  MODIFY `ID_Clase_Programada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `configuracion_gym`
--
ALTER TABLE `configuracion_gym`
  MODIFY `ID_Configuracion_Gym` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ejercicio`
--
ALTER TABLE `ejercicio`
  MODIFY `ID_Ejercicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `equipo`
--
ALTER TABLE `equipo`
  MODIFY `ID_Equipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `estado_membresia_socio`
--
ALTER TABLE `estado_membresia_socio`
  MODIFY `ID_Estado_Membresia_Socio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `estado_usuario`
--
ALTER TABLE `estado_usuario`
  MODIFY `ID_Estado_Usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `horario_funcionamiento`
--
ALTER TABLE `horario_funcionamiento`
  MODIFY `ID_Horario_Funcionamiento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `membresia_socio`
--
ALTER TABLE `membresia_socio`
  MODIFY `ID_Membresia_Socio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `musculo`
--
ALTER TABLE `musculo`
  MODIFY `ID_Musculo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `nivel_dificultad`
--
ALTER TABLE `nivel_dificultad`
  MODIFY `ID_Nivel_Dificultad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `ID_Pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `ID_Permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `reserva`
--
ALTER TABLE `reserva`
  MODIFY `ID_Reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `ID_Rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `rutina`
--
ALTER TABLE `rutina`
  MODIFY `ID_Rutina` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sala`
--
ALTER TABLE `sala`
  MODIFY `ID_Sala` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipo_membresia`
--
ALTER TABLE `tipo_membresia`
  MODIFY `ID_Tipo_Membresia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tutor`
--
ALTER TABLE `tutor`
  MODIFY `ID_Tutor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD CONSTRAINT `asistencia_ibfk_1` FOREIGN KEY (`ID_Socio`) REFERENCES `usuario` (`ID_Usuario`),
  ADD CONSTRAINT `fk_asistencia_clase` FOREIGN KEY (`ID_Clase_Programada`) REFERENCES `clase_programada` (`ID_Clase_Programada`),
  ADD CONSTRAINT `fk_asistencia_socio` FOREIGN KEY (`ID_Socio`) REFERENCES `socio` (`ID_Usuario`);

--
-- Filtros para la tabla `certificado`
--
ALTER TABLE `certificado`
  ADD CONSTRAINT `certificado_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuario` (`ID_Usuario`),
  ADD CONSTRAINT `fk_certificado_usuario` FOREIGN KEY (`ID_Usuario`) REFERENCES `socio` (`ID_Usuario`);

--
-- Filtros para la tabla `clase_programada`
--
ALTER TABLE `clase_programada`
  ADD CONSTRAINT `clase_programada_ibfk_1` FOREIGN KEY (`ID_Clase`) REFERENCES `clase` (`ID_Clase`),
  ADD CONSTRAINT `clase_programada_ibfk_2` FOREIGN KEY (`ID_Sala`) REFERENCES `sala` (`ID_Sala`);

--
-- Filtros para la tabla `configuracion_gym`
--
ALTER TABLE `configuracion_gym`
  ADD CONSTRAINT `configuracion_gym_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuario` (`ID_Usuario`),
  ADD CONSTRAINT `fk_config_admin` FOREIGN KEY (`ID_Admin`) REFERENCES `usuario` (`ID_Usuario`);

--
-- Filtros para la tabla `ejercicio_equipo`
--
ALTER TABLE `ejercicio_equipo`
  ADD CONSTRAINT `ejercicio_equipo_ibfk_1` FOREIGN KEY (`ID_Ejercicio`) REFERENCES `ejercicio` (`ID_Ejercicio`),
  ADD CONSTRAINT `ejercicio_equipo_ibfk_2` FOREIGN KEY (`ID_Equipo`) REFERENCES `equipo` (`ID_Equipo`);

--
-- Filtros para la tabla `ejercicio_musculo`
--
ALTER TABLE `ejercicio_musculo`
  ADD CONSTRAINT `ejercicio_musculo_ibfk_1` FOREIGN KEY (`ID_Ejercicio`) REFERENCES `ejercicio` (`ID_Ejercicio`),
  ADD CONSTRAINT `ejercicio_musculo_ibfk_2` FOREIGN KEY (`ID_Musculo`) REFERENCES `musculo` (`ID_Musculo`);

--
-- Filtros para la tabla `horario_funcionamiento`
--
ALTER TABLE `horario_funcionamiento`
  ADD CONSTRAINT `horario_funcionamiento_ibfk_1` FOREIGN KEY (`ID_Configuracion_Gym`) REFERENCES `configuracion_gym` (`ID_Configuracion_Gym`);

--
-- Filtros para la tabla `membresia_socio`
--
ALTER TABLE `membresia_socio`
  ADD CONSTRAINT `fk_membresia_socio_usuario` FOREIGN KEY (`ID_Usuario`) REFERENCES `socio` (`ID_Usuario`),
  ADD CONSTRAINT `membresia_socio_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuario` (`ID_Usuario`),
  ADD CONSTRAINT `membresia_socio_ibfk_2` FOREIGN KEY (`ID_Tipo_Membresia`) REFERENCES `tipo_membresia` (`ID_Tipo_Membresia`),
  ADD CONSTRAINT `membresia_socio_ibfk_3` FOREIGN KEY (`ID_Estado_Membresia_Socio`) REFERENCES `estado_membresia_socio` (`ID_Estado_Membresia_Socio`);

--
-- Filtros para la tabla `pago`
--
ALTER TABLE `pago`
  ADD CONSTRAINT `fk_pago_usuario` FOREIGN KEY (`ID_Usuario`) REFERENCES `socio` (`ID_Usuario`),
  ADD CONSTRAINT `fk_pago_usuario_registro` FOREIGN KEY (`ID_Usuario_Registro`) REFERENCES `usuario` (`ID_Usuario`),
  ADD CONSTRAINT `pago_ibfk_1` FOREIGN KEY (`ID_Membresia_Socio`) REFERENCES `membresia_socio` (`ID_Membresia_Socio`),
  ADD CONSTRAINT `pago_ibfk_2` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuario` (`ID_Usuario`);

--
-- Filtros para la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `fk_reserva_clase_prog` FOREIGN KEY (`ID_Clase_Programada`) REFERENCES `clase_programada` (`ID_Clase_Programada`),
  ADD CONSTRAINT `fk_reserva_socio` FOREIGN KEY (`ID_Socio`) REFERENCES `socio` (`ID_Usuario`),
  ADD CONSTRAINT `fk_reserva_socio_usuario` FOREIGN KEY (`ID_Socio`) REFERENCES `usuario` (`ID_Usuario`),
  ADD CONSTRAINT `reserva_ibfk_1` FOREIGN KEY (`ID_Clase_Programada`) REFERENCES `clase_programada` (`ID_Clase_Programada`),
  ADD CONSTRAINT `reserva_ibfk_2` FOREIGN KEY (`ID_Socio`) REFERENCES `usuario` (`ID_Usuario`);

--
-- Filtros para la tabla `rol_permiso`
--
ALTER TABLE `rol_permiso`
  ADD CONSTRAINT `rol_permiso_ibfk_1` FOREIGN KEY (`ID_Rol`) REFERENCES `rol` (`ID_Rol`),
  ADD CONSTRAINT `rol_permiso_ibfk_2` FOREIGN KEY (`ID_Permiso`) REFERENCES `permiso` (`ID_Permiso`);

--
-- Filtros para la tabla `rutina`
--
ALTER TABLE `rutina`
  ADD CONSTRAINT `fk_rutina_profesor` FOREIGN KEY (`ID_Profesor`) REFERENCES `usuario` (`ID_Usuario`),
  ADD CONSTRAINT `rutina_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuario` (`ID_Usuario`),
  ADD CONSTRAINT `rutina_ibfk_2` FOREIGN KEY (`ID_Nivel_Dificultad`) REFERENCES `nivel_dificultad` (`ID_Nivel_Dificultad`);

--
-- Filtros para la tabla `rutina_ejercicio`
--
ALTER TABLE `rutina_ejercicio`
  ADD CONSTRAINT `rutina_ejercicio_ibfk_1` FOREIGN KEY (`ID_Rutina`) REFERENCES `rutina` (`ID_Rutina`),
  ADD CONSTRAINT `rutina_ejercicio_ibfk_2` FOREIGN KEY (`ID_Ejercicio`) REFERENCES `ejercicio` (`ID_Ejercicio`);

--
-- Filtros para la tabla `socio`
--
ALTER TABLE `socio`
  ADD CONSTRAINT `socio_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuario` (`ID_Usuario`);

--
-- Filtros para la tabla `tutor`
--
ALTER TABLE `tutor`
  ADD CONSTRAINT `fk_tutor_socio` FOREIGN KEY (`ID_Socio`) REFERENCES `socio` (`ID_Usuario`),
  ADD CONSTRAINT `tutor_ibfk_1` FOREIGN KEY (`ID_Socio`) REFERENCES `socio` (`ID_Usuario`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`ID_Estado_Usuario`) REFERENCES `estado_usuario` (`ID_Estado_Usuario`);

--
-- Filtros para la tabla `usuario_rol`
--
ALTER TABLE `usuario_rol`
  ADD CONSTRAINT `usuario_rol_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuario` (`ID_Usuario`),
  ADD CONSTRAINT `usuario_rol_ibfk_2` FOREIGN KEY (`ID_Rol`) REFERENCES `rol` (`ID_Rol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
