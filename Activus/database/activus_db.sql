-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-11-2025 a las 19:44:32
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia`
--

CREATE TABLE `asistencia` (
  `ID_Asistencia` int(11) NOT NULL,
  `ID_Usuario` int(11) DEFAULT NULL,
  `Fecha` date NOT NULL DEFAULT curdate(),
  `Hora` time NOT NULL DEFAULT curtime(),
  `Resultado` enum('Exitoso','Denegado') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `asistencia`
--

INSERT INTO `asistencia` (`ID_Asistencia`, `ID_Usuario`, `Fecha`, `Hora`, `Resultado`) VALUES
(10, 2, '2025-11-20', '21:37:48', 'Exitoso'),
(11, 4, '2025-11-20', '21:38:17', 'Exitoso'),
(12, 4, '2025-11-24', '14:58:19', 'Exitoso'),
(13, 4, '2025-11-24', '18:54:28', 'Exitoso');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-configuracion_activa', 'O:27:\"App\\Models\\ConfiguracionGym\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:17:\"configuracion_gym\";s:13:\"\0*\0primaryKey\";s:20:\"ID_Configuracion_Gym\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:7:{s:20:\"ID_Configuracion_Gym\";i:22;s:8:\"ID_Admin\";i:1;s:10:\"Nombre_Gym\";s:11:\"Activus Gym\";s:9:\"Ubicacion\";s:54:\"Alfonsina Storni 41, Ezeiza, Provincia de Buenos Aires\";s:8:\"Logo_PNG\";s:50:\"logos/crr7MzcASl0MRWWlzSgdTNllua45UCeEqfTUPBRw.png\";s:14:\"ID_Color_Fondo\";i:1;s:14:\"Color_Elemento\";s:7:\"#ff00ae\";}s:11:\"\0*\0original\";a:7:{s:20:\"ID_Configuracion_Gym\";i:22;s:8:\"ID_Admin\";i:1;s:10:\"Nombre_Gym\";s:11:\"Activus Gym\";s:9:\"Ubicacion\";s:54:\"Alfonsina Storni 41, Ezeiza, Provincia de Buenos Aires\";s:8:\"Logo_PNG\";s:50:\"logos/crr7MzcASl0MRWWlzSgdTNllua45UCeEqfTUPBRw.png\";s:14:\"ID_Color_Fondo\";i:1;s:14:\"Color_Elemento\";s:7:\"#ff00ae\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:10:\"colorFondo\";O:21:\"App\\Models\\ColorFondo\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:13:\"colores_fondo\";s:13:\"\0*\0primaryKey\";s:14:\"ID_Color_Fondo\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:3:{s:14:\"ID_Color_Fondo\";i:1;s:12:\"Nombre_Color\";s:11:\"Azul Oscuro\";s:10:\"Codigo_Hex\";s:7:\"#020817\";}s:11:\"\0*\0original\";a:3:{s:14:\"ID_Color_Fondo\";i:1;s:12:\"Nombre_Color\";s:11:\"Azul Oscuro\";s:10:\"Codigo_Hex\";s:7:\"#020817\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:0;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:2:{i:0;s:12:\"Nombre_Color\";i:1;s:10:\"Codigo_Hex\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:0;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:8:\"ID_Admin\";i:1;s:10:\"Nombre_Gym\";i:2;s:9:\"Ubicacion\";i:3;s:8:\"Logo_PNG\";i:4;s:14:\"ID_Color_Fondo\";i:5;s:14:\"Color_Elemento\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}', 2079540658);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `certificado`
--

CREATE TABLE `certificado` (
  `ID_Certificado` int(11) NOT NULL,
  `ID_Usuario_Socio` int(11) NOT NULL,
  `Imagen_Certificado` varchar(255) DEFAULT NULL,
  `Aprobado` tinyint(1) DEFAULT 0,
  `Fecha_Emision` date DEFAULT NULL,
  `Fecha_Vencimiento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `certificado`
--

INSERT INTO `certificado` (`ID_Certificado`, `ID_Usuario_Socio`, `Imagen_Certificado`, `Aprobado`, `Fecha_Emision`, `Fecha_Vencimiento`) VALUES
(4, 63, 'certificados/jbT8liU1rGWk5btHzvaMyF71qbU4NATb0ToHHfyh.png', 1, '2025-11-25', '2026-11-25'),
(5, 4, 'certificados/Kl1y47d7cn7spkygFDUT0vIuOOHQxgi576q5pM5E.jpg', 1, '2025-11-26', '2026-11-26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clase`
--

CREATE TABLE `clase` (
  `ID_Clase` int(11) NOT NULL,
  `ID_Profesor` int(11) NOT NULL,
  `Nombre_Clase` varchar(100) DEFAULT NULL,
  `Capacidad_Maxima` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `clase`
--

INSERT INTO `clase` (`ID_Clase`, `ID_Profesor`, `Nombre_Clase`, `Capacidad_Maxima`) VALUES
(19, 3, 'funcional complex', 15),
(25, 3, 'funcional  teens', 24),
(30, 5, 'yoga', 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clase_programada`
--

CREATE TABLE `clase_programada` (
  `ID_Clase_Programada` int(11) NOT NULL,
  `ID_Clase` int(11) NOT NULL,
  `ID_Sala` int(11) DEFAULT NULL,
  `Fecha` date DEFAULT NULL,
  `Hora_Inicio` time DEFAULT NULL,
  `Hora_Fin` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `clase_programada`
--

INSERT INTO `clase_programada` (`ID_Clase_Programada`, `ID_Clase`, `ID_Sala`, `Fecha`, `Hora_Inicio`, `Hora_Fin`) VALUES
(15, 19, 10, '2025-11-12', '10:20:00', '15:00:00'),
(16, 25, 11, '2025-11-14', '09:00:00', '10:00:00'),
(19, 19, 10, '2025-11-20', '22:00:00', '23:00:00'),
(22, 19, 10, '2025-11-24', '06:00:00', '07:00:00'),
(23, 30, 11, '2025-11-24', '17:00:00', '19:00:00'),
(24, 25, 10, '2025-11-26', '12:00:00', '14:00:00'),
(25, 30, 11, '2025-11-27', '12:00:00', '14:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colores_fondo`
--

CREATE TABLE `colores_fondo` (
  `ID_Color_Fondo` int(11) NOT NULL,
  `Nombre_Color` varchar(50) NOT NULL,
  `Codigo_Hex` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `colores_fondo`
--

INSERT INTO `colores_fondo` (`ID_Color_Fondo`, `Nombre_Color`, `Codigo_Hex`) VALUES
(1, 'Azul Oscuro', '#020817'),
(2, 'Intermedio', '#B1BCC8'),
(3, 'Claro', '#E2E8F0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion_gym`
--

CREATE TABLE `configuracion_gym` (
  `ID_Configuracion_Gym` int(11) NOT NULL,
  `ID_Admin` int(11) NOT NULL,
  `Nombre_Gym` varchar(100) DEFAULT NULL,
  `Ubicacion` varchar(255) DEFAULT NULL,
  `Logo_PNG` varchar(255) DEFAULT NULL,
  `ID_Color_Fondo` int(11) DEFAULT NULL,
  `Color_Elemento` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `configuracion_gym`
--

INSERT INTO `configuracion_gym` (`ID_Configuracion_Gym`, `ID_Admin`, `Nombre_Gym`, `Ubicacion`, `Logo_PNG`, `ID_Color_Fondo`, `Color_Elemento`) VALUES
(22, 1, 'Activus Gym', 'Alfonsina Storni 41, Ezeiza, Provincia de Buenos Aires', 'logos/crr7MzcASl0MRWWlzSgdTNllua45UCeEqfTUPBRw.png', 1, '#ff00ae');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejercicio`
--

CREATE TABLE `ejercicio` (
  `ID_Ejercicio` int(11) NOT NULL,
  `Nombre_Ejercicio` varchar(100) NOT NULL,
  `Descripcion` text DEFAULT NULL,
  `Tips` text DEFAULT NULL,
  `Instrucciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ejercicio`
--

INSERT INTO `ejercicio` (`ID_Ejercicio`, `Nombre_Ejercicio`, `Descripcion`, `Tips`, `Instrucciones`) VALUES
(1, 'Sentadillas', 'La sentadilla es un ejercicio de fuerza fundamental que trabaja principalmente los músculos de las piernas y glúteos, incluyendo los cuádriceps, isquiotibiales y glúteos mayores.', 'Rodillas alineadas con los pies.\r\n\r\nMira al frente y activa el core.\r\n\r\nNo rebotes; sube y baja controlado.', 'Pies al ancho de hombros, espalda recta.\r\n\r\nBaja controlando hasta que los muslos queden paralelos al suelo.\r\n\r\nEmpuja con los talones al subir.'),
(2, 'Sentadilla con Cajón', 'Baja lentamente hasta tocar un cajón con los glúteos y vuelve a subir manteniendo la espalda recta y el core activo.', 'Mantén la espalda recta y el core activo.\r\n\r\nRodillas alineadas con los pies.\r\n\r\nControla el movimiento; no te “sientes” bruscamente.\r\n\r\nAjusta la altura del cajón según tu flexibilidad.', 'Coloca un cajón detrás tuyo, pies al ancho de hombros.\r\nBaja lentamente hasta tocar el cajón con los glúteos.\r\nEmpuja con los talones para subir.'),
(3, 'Flexiones', 'Empuje clásico del tren superior.', 'Activá el abdomen; no hundas la cadera.', 'Manos bajo hombros, cuerpo recto, bajar controlado, subir extendiendo brazos.'),
(4, 'Plancha', 'Isometría para resistencia y control del core.', 'No aguantes con la espalda arqueada; respira profundo; empieza por 20–30s y aumenta progresivamente.', 'Apoyar antebrazos y puntas de pies, cuerpo recto desde cabeza a talones, mantener tiempo.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejercicio_equipo`
--

CREATE TABLE `ejercicio_equipo` (
  `ID_Ejercicio` int(11) NOT NULL,
  `ID_Equipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ejercicio_equipo`
--

INSERT INTO `ejercicio_equipo` (`ID_Ejercicio`, `ID_Equipo`) VALUES
(2, 4),
(4, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejercicio_musculo`
--

CREATE TABLE `ejercicio_musculo` (
  `ID_Ejercicio` int(11) NOT NULL,
  `ID_Musculo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ejercicio_musculo`
--

INSERT INTO `ejercicio_musculo` (`ID_Ejercicio`, `ID_Musculo`) VALUES
(1, 4),
(1, 5),
(2, 4),
(2, 5),
(3, 2),
(3, 6),
(4, 5),
(4, 8),
(4, 12),
(4, 13);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo`
--

CREATE TABLE `equipo` (
  `ID_Equipo` int(11) NOT NULL,
  `Nombre_Equipo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `equipo`
--

INSERT INTO `equipo` (`ID_Equipo`, `Nombre_Equipo`) VALUES
(1, 'Banco'),
(2, 'Pesa'),
(3, 'Mancuerna Circular'),
(4, 'Cajón'),
(5, 'Mancuerna Hexagonal'),
(6, 'Barra'),
(7, 'Colchoneta'),
(8, 'Mancuerna');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_membresia_socio`
--

CREATE TABLE `estado_membresia_socio` (
  `ID_Estado_Membresia_Socio` int(11) NOT NULL,
  `Nombre_Estado_Membresia_Socio` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

CREATE TABLE `estado_usuario` (
  `ID_Estado_Usuario` int(11) NOT NULL,
  `Nombre_Estado_Usuario` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `estado_usuario`
--

INSERT INTO `estado_usuario` (`ID_Estado_Usuario`, `Nombre_Estado_Usuario`) VALUES
(1, 'Activo'),
(2, 'Inactivo'),
(3, 'Pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario_funcionamiento`
--

CREATE TABLE `horario_funcionamiento` (
  `ID_Horario_Funcionamiento` int(11) NOT NULL,
  `ID_Configuracion_Gym` int(11) NOT NULL,
  `Dia_Semana` varchar(20) DEFAULT NULL,
  `Hora_Apertura` time DEFAULT NULL,
  `Hora_Cierre` time DEFAULT NULL,
  `Habilitacion` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `horario_funcionamiento`
--

INSERT INTO `horario_funcionamiento` (`ID_Horario_Funcionamiento`, `ID_Configuracion_Gym`, `Dia_Semana`, `Hora_Apertura`, `Hora_Cierre`, `Habilitacion`) VALUES
(134, 22, 'Lunes', '07:00:00', '22:00:00', 1),
(135, 22, 'Martes', '07:00:00', '22:00:00', 1),
(136, 22, 'Miércoles', '07:00:00', '22:00:00', 1),
(137, 22, 'Jueves', '07:00:00', '22:00:00', 1),
(138, 22, 'Viernes', '07:00:00', '22:00:00', 1),
(139, 22, 'Sábado', '07:00:00', '20:00:00', 1),
(140, 22, 'Domingo', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `membresia_socio`
--

CREATE TABLE `membresia_socio` (
  `ID_Membresia_Socio` int(11) NOT NULL,
  `ID_Usuario_Socio` int(11) NOT NULL,
  `ID_Tipo_Membresia` int(11) DEFAULT NULL,
  `ID_Estado_Membresia_Socio` int(11) DEFAULT NULL,
  `Fecha_Inicio` date DEFAULT NULL,
  `Fecha_Fin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `membresia_socio`
--

INSERT INTO `membresia_socio` (`ID_Membresia_Socio`, `ID_Usuario_Socio`, `ID_Tipo_Membresia`, `ID_Estado_Membresia_Socio`, `Fecha_Inicio`, `Fecha_Fin`) VALUES
(14, 62, 5, 1, '2025-11-22', '2025-12-22'),
(16, 4, 6, 2, '2025-11-25', '2025-12-10'),
(17, 4, 5, 1, '2025-11-25', '2025-12-25'),
(18, 63, 6, 3, NULL, NULL),
(19, 66, NULL, NULL, NULL, NULL),
(20, 63, 6, 1, '2025-11-25', '2025-12-10'),
(21, 67, 5, 1, '2025-11-25', '2025-12-25');

--
-- Disparadores `membresia_socio`
--
DELIMITER $$
CREATE TRIGGER `trg_calc_vencimiento_membresia` BEFORE INSERT ON `membresia_socio` FOR EACH ROW BEGIN
    DECLARE dur INT;
    DECLARE unidad VARCHAR(20);

    SELECT Duracion, Unidad_Duracion 
        INTO dur, unidad
    FROM tipo_membresia
    WHERE ID_Tipo_Membresia = NEW.ID_Tipo_Membresia;

    IF unidad = 'dias' THEN
        SET NEW.Fecha_Fin = DATE_ADD(NEW.Fecha_Inicio, INTERVAL dur DAY);
    ELSEIF unidad = 'semanas' THEN
        SET NEW.Fecha_Fin = DATE_ADD(NEW.Fecha_Inicio, INTERVAL dur WEEK);
    ELSEIF unidad = 'meses' THEN
        SET NEW.Fecha_Fin = DATE_ADD(NEW.Fecha_Inicio, INTERVAL dur MONTH);
    ELSEIF unidad = 'años' THEN
        SET NEW.Fecha_Fin = DATE_ADD(NEW.Fecha_Inicio, INTERVAL dur YEAR);
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_update_vencimiento_membresia` BEFORE UPDATE ON `membresia_socio` FOR EACH ROW BEGIN
    DECLARE dur INT;
    DECLARE unidad VARCHAR(20);

    -- Solo recalcular si cambia la fecha de inicio
    IF NEW.Fecha_Inicio <> OLD.Fecha_Inicio THEN

        SELECT Duracion, Unidad_Duracion 
            INTO dur, unidad
        FROM tipo_membresia
        WHERE ID_Tipo_Membresia = NEW.ID_Tipo_Membresia;

        IF unidad = 'dias' THEN
            SET NEW.Fecha_Fin = DATE_ADD(NEW.Fecha_Inicio, INTERVAL dur DAY);
        ELSEIF unidad = 'semanas' THEN
            SET NEW.Fecha_Fin = DATE_ADD(NEW.Fecha_Inicio, INTERVAL dur WEEK);
        ELSEIF unidad = 'meses' THEN
            SET NEW.Fecha_Fin = DATE_ADD(NEW.Fecha_Inicio, INTERVAL dur MONTH);
        ELSEIF unidad = 'años' THEN
            SET NEW.Fecha_Fin = DATE_ADD(NEW.Fecha_Inicio, INTERVAL dur YEAR);
        END IF;

    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `musculo`
--

CREATE TABLE `musculo` (
  `ID_Musculo` int(11) NOT NULL,
  `Nombre_Musculo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `musculo`
--

INSERT INTO `musculo` (`ID_Musculo`, `Nombre_Musculo`) VALUES
(1, 'Espalda'),
(2, 'Pecho'),
(3, 'Biceps'),
(4, 'Cuádripces'),
(5, 'Glúteos'),
(6, 'Triceps'),
(7, 'Dorsal'),
(8, 'Hombros'),
(9, 'Core'),
(10, 'Isquios'),
(11, 'Recto Abdominal'),
(12, 'Abdominales'),
(13, 'Lumbares'),
(14, 'Trapecios'),
(15, 'Deltoides Laterales');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nivel_dificultad`
--

CREATE TABLE `nivel_dificultad` (
  `ID_Nivel_Dificultad` int(11) NOT NULL,
  `Nombre_Nivel_Dificultad` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `nivel_dificultad`
--

INSERT INTO `nivel_dificultad` (`ID_Nivel_Dificultad`, `Nombre_Nivel_Dificultad`) VALUES
(1, 'Principiante'),
(2, 'Normal'),
(3, 'Avanzado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `ID_Pago` int(11) NOT NULL,
  `ID_Membresia_Socio` int(11) NOT NULL,
  `ID_Usuario_Socio` int(11) NOT NULL,
  `ID_Usuario_Registro` int(11) NOT NULL,
  `Monto` decimal(10,2) NOT NULL,
  `Metodo_Pago` enum('Efectivo','Transferencia','Tarjeta','Otro') DEFAULT 'Efectivo',
  `Fecha_Pago` date NOT NULL DEFAULT curdate(),
  `Fecha_Vencimiento` date DEFAULT NULL,
  `Hora_Pago` time NOT NULL DEFAULT curtime(),
  `Observacion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pago`
--

INSERT INTO `pago` (`ID_Pago`, `ID_Membresia_Socio`, `ID_Usuario_Socio`, `ID_Usuario_Registro`, `Monto`, `Metodo_Pago`, `Fecha_Pago`, `Fecha_Vencimiento`, `Hora_Pago`, `Observacion`) VALUES
(9, 14, 62, 2, 30000.00, 'Efectivo', '2025-11-22', '2025-12-22', '02:11:09', NULL),
(11, 16, 4, 2, 25000.00, 'Efectivo', '2025-11-24', '2025-12-09', '16:01:19', NULL),
(12, 16, 4, 2, 30000.00, 'Efectivo', '2025-11-25', '2025-12-25', '14:16:31', NULL),
(13, 16, 4, 2, 25000.00, 'Efectivo', '2025-11-25', '2025-12-10', '14:18:16', NULL),
(14, 17, 4, 2, 30000.00, 'Efectivo', '2025-11-25', '2025-12-25', '14:27:09', NULL),
(15, 20, 63, 2, 25000.00, 'Efectivo', '2025-11-25', '2025-12-10', '15:06:57', NULL),
(16, 21, 67, 2, 30000.00, 'Efectivo', '2025-11-25', '2025-12-25', '15:11:11', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `ID_Permiso` int(11) NOT NULL,
  `Nombre_Permiso` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `permiso`
--

INSERT INTO `permiso` (`ID_Permiso`, `Nombre_Permiso`) VALUES
(1, 'Gestionar Usuarios'),
(2, 'Gestionar Socios'),
(3, 'Ingresar Inicio'),
(4, 'Asistencias'),
(5, 'Configuracion'),
(6, 'Ver Perfil Socio'),
(7, 'Ver Perfil'),
(8, 'Ver Perfil Usuario'),
(9, 'Membresias'),
(10, 'Clases'),
(11, 'Rutinas'),
(12, 'Ejercicios'),
(13, 'Profesores'),
(14, 'Donde Entrenar'),
(15, 'Gestionar Salas'),
(16, 'Pagos'),
(17, 'Gestion Profesores'),
(18, 'Gestionar Membresias'),
(19, 'Gestionar Clases'),
(20, 'Gestionar Ejercicios'),
(21, 'Gestionar Rutinas'),
(22, 'Impartir Clases'),
(23, 'Pagos Socio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserva`
--

CREATE TABLE `reserva` (
  `ID_Reserva` int(11) NOT NULL,
  `ID_Clase_Programada` int(11) NOT NULL,
  `ID_Socio` int(11) NOT NULL,
  `Fecha_Reserva` date NOT NULL DEFAULT curdate(),
  `Estado_Reserva` enum('Confirmada','Cancelada') NOT NULL DEFAULT 'Confirmada'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `reserva`
--

INSERT INTO `reserva` (`ID_Reserva`, `ID_Clase_Programada`, `ID_Socio`, `Fecha_Reserva`, `Estado_Reserva`) VALUES
(2, 15, 4, '2025-11-12', 'Confirmada'),
(3, 16, 4, '2025-11-20', 'Confirmada'),
(4, 19, 4, '2025-11-20', 'Confirmada'),
(7, 22, 4, '2025-11-24', 'Confirmada'),
(8, 24, 4, '2025-11-25', 'Confirmada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `ID_Rol` int(11) NOT NULL,
  `Nombre_Rol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

CREATE TABLE `rol_permiso` (
  `ID_Rol` int(11) NOT NULL,
  `ID_Permiso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rol_permiso`
--

INSERT INTO `rol_permiso` (`ID_Rol`, `ID_Permiso`) VALUES
(1, 1),
(1, 3),
(1, 4),
(1, 5),
(1, 7),
(1, 8),
(2, 3),
(2, 7),
(2, 11),
(2, 12),
(2, 20),
(2, 21),
(2, 22),
(3, 2),
(3, 3),
(3, 6),
(3, 7),
(3, 15),
(3, 16),
(3, 17),
(3, 18),
(3, 19),
(4, 3),
(4, 7),
(4, 9),
(4, 10),
(4, 11),
(4, 12),
(4, 13),
(4, 14),
(4, 23);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rutina`
--

CREATE TABLE `rutina` (
  `ID_Rutina` int(11) NOT NULL,
  `ID_Profesor` int(11) NOT NULL,
  `ID_Nivel_Dificultad` int(11) DEFAULT NULL,
  `Nombre_Rutina` varchar(100) DEFAULT NULL,
  `Duracion_Aprox` int(11) DEFAULT NULL,
  `Cant_Dias_Semana` int(11) DEFAULT NULL,
  `Descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rutina`
--

INSERT INTO `rutina` (`ID_Rutina`, `ID_Profesor`, `ID_Nivel_Dificultad`, `Nombre_Rutina`, `Duracion_Aprox`, `Cant_Dias_Semana`, `Descripcion`) VALUES
(1, 1, 1, 'Semana de Sentadillas', 30, 3, 'Una semana de pura sentadillas para fortalecer glúteos y piernas'),
(2, 1, 2, 'Abdominales', 60, 2, 'Día de Abdominales');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rutina_ejercicio`
--

CREATE TABLE `rutina_ejercicio` (
  `ID_Rutina` int(11) NOT NULL,
  `ID_Ejercicio` int(11) NOT NULL,
  `Series` int(11) DEFAULT NULL,
  `Repeticiones` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rutina_ejercicio`
--

INSERT INTO `rutina_ejercicio` (`ID_Rutina`, `ID_Ejercicio`, `Series`, `Repeticiones`) VALUES
(1, 1, 20, 4),
(2, 4, 2, 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sala`
--

CREATE TABLE `sala` (
  `ID_Sala` int(11) NOT NULL,
  `Nombre_Sala` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sala`
--

INSERT INTO `sala` (`ID_Sala`, `Nombre_Sala`) VALUES
(10, 'Sala Abierta'),
(11, 'Sala Principal'),
(14, 'Sala Aeróbic');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('9hCe1btSpuAkIEHW18AIXr3mzFRIj07FO70OG9ih', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ1lyTUJUZ1lZTDFGdnBVUEpraFhGWUNkTjRDRVRNeFhOWkF3ZFUwSCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC91c3VhcmlvcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1762748360);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `socio`
--

CREATE TABLE `socio` (
  `ID_Usuario` int(11) NOT NULL,
  `Fecha_Nacimiento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `socio`
--

INSERT INTO `socio` (`ID_Usuario`, `Fecha_Nacimiento`) VALUES
(4, '2001-01-01'),
(62, '2003-02-02'),
(63, '2000-09-12'),
(64, '2000-09-06'),
(65, '2000-02-20'),
(66, '2000-03-12'),
(67, '2000-02-09'),
(68, '2000-07-05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_membresia`
--

CREATE TABLE `tipo_membresia` (
  `ID_Tipo_Membresia` int(11) NOT NULL,
  `Nombre_Tipo_Membresia` varchar(100) NOT NULL,
  `Duracion` int(11) NOT NULL,
  `Unidad_Duracion` enum('días','semanas','meses','años') DEFAULT 'meses',
  `Precio` decimal(10,2) NOT NULL,
  `Descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipo_membresia`
--

INSERT INTO `tipo_membresia` (`ID_Tipo_Membresia`, `Nombre_Tipo_Membresia`, `Duracion`, `Unidad_Duracion`, `Precio`, `Descripcion`) VALUES
(5, 'Premium', 30, 'días', 30000.00, 'Disfrutá 30 días de acceso total al gym, con más tiempo para alcanzar tus objetivos y aprovechar todos nuestros servicios.'),
(6, 'Básica', 15, 'días', 16000.00, 'Acceso completo al gimnasio por 15 días para entrenar cuando quieras y probar todas nuestras instalaciones.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

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
(1, 1, 'Admin', 'General', '$2y$12$aI6TeVPdwfM3l7OwcPkcCua2.URduVVeEMjJxKRN1kbB6n8ZeKsWa', 'administrador@gym.com', '90000001', 'fotos_perfil/OQ5x3P7YDgm001w9jEPtJzcd0su09KIzA5fLoICB.png', '1111111111', '2025-09-23'),
(2, 1, 'Recepcion', 'General', '$2y$12$aI6TeVPdwfM3l7OwcPkcCua2.URduVVeEMjJxKRN1kbB6n8ZeKsWa', 'administrativo@gym.com', '90000002', 'fotos_perfil/4koWise3lhe78Gyf5IGJOXwp28M16eMKwBU7gs8S.png', '0002', '2025-09-23'),
(3, 1, 'Profe', 'General', '$2y$12$aI6TeVPdwfM3l7OwcPkcCua2.URduVVeEMjJxKRN1kbB6n8ZeKsWa', 'profesor@gym.com', '90123456', 'fotos_perfil/JY1xKlT7Cpo5xFsUaCO8LmxGs9q7uLvfOqLlcyvC.png', '0003', '2025-09-23'),
(4, 1, 'Socio', 'Demo', '$2y$12$aI6TeVPdwfM3l7OwcPkcCua2.URduVVeEMjJxKRN1kbB6n8ZeKsWa', 'socio@gym.com', '90000004', 'fotos_perfil/r7mbeAm1qiXE0ZbqdxSGBt99v3nWnCI8lPmF95C9.png', '1100000000', '2025-09-23'),
(5, 1, 'Super', 'Usuario', '$2y$12$aI6TeVPdwfM3l7OwcPkcCua2.URduVVeEMjJxKRN1kbB6n8ZeKsWa', 'super@gym.com', '90000005', NULL, '0005', '2025-09-23'),
(59, 2, 'Cami', 'Profe', '12345', 'camanaluz.15@gmail.com', '11111111', NULL, '1111341111', '0000-00-00'),
(62, 1, 'Camila', 'Villasboa', '$2y$12$v5VmfBiPHOlyvsUEmuOQwe5JN5b/cbi3.mmMYxCE4G70AWyO4IfMu', 'camvillasboa.ikigai@gmail.com', '45498495', NULL, '1157619627', '2025-11-22'),
(63, 1, 'Ana', 'Martinez', '$2y$12$24acaT0yyVwngVmKQGy6iO0ELcrQu6Y.PH.ICB2g8EeUxbmQR1pES', 'ana@gmail.com', '22332323', NULL, '1100222003', '2025-11-25'),
(64, 1, 'Braian', 'Romero', '$2y$12$2Jz2qJXPrmKhhmIKt3o5YujmdN9gDURfpi.mIRBEVEbY411d43IJK', 'romero@gmail.com', '60000003', NULL, '1173737333', '2025-11-25'),
(65, 1, 'Laura', 'Palacios', '$2y$12$AkabE/FynDC9AF.LGhk3mOGcMQLsw.Y4Q019gQaK3wjDxbLXbu/D.', 'laurita@gmail.com', '33333345', NULL, '1122222233', '2025-11-25'),
(66, 1, 'Esteban', 'Laz', '$2y$12$dCcQW7BUfZ3dATY7qvVChuUQKFvDCBu414JBIflMDgOp1puLzPj9u', 'el@gmail.com', '29999999', NULL, '1100484848', '2025-11-25'),
(67, 1, 'Marta', 'Lezcano', '$2y$12$.jNpu.Wm.ef5F2kYAj4QTeWfFHJyDcC3Cn1.btQgo0XW5qIJAVccK', 'marlez@gmail.com', '36666661', NULL, '1194477338', '2025-11-25'),
(68, 1, 'Lucas', 'Mauricio', '$2y$12$di0Jv2nhSXT7IaXx/yQgH.R0pk80BmGogilyPLoI0uS75qYJacny.', 'lumau@gmail.com', '36363636', NULL, '1146582933', '2025-11-25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_rol`
--

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
(59, 2),
(62, 4),
(63, 4),
(66, 4),
(67, 4),
(68, 4);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD PRIMARY KEY (`ID_Asistencia`),
  ADD KEY `ID_Socio` (`ID_Usuario`);

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `certificado`
--
ALTER TABLE `certificado`
  ADD PRIMARY KEY (`ID_Certificado`),
  ADD KEY `ID_Usuario_Socio` (`ID_Usuario_Socio`);

--
-- Indices de la tabla `clase`
--
ALTER TABLE `clase`
  ADD PRIMARY KEY (`ID_Clase`),
  ADD KEY `ID_Profesor` (`ID_Profesor`);

--
-- Indices de la tabla `clase_programada`
--
ALTER TABLE `clase_programada`
  ADD PRIMARY KEY (`ID_Clase_Programada`),
  ADD KEY `ID_Clase` (`ID_Clase`),
  ADD KEY `ID_Sala` (`ID_Sala`);

--
-- Indices de la tabla `colores_fondo`
--
ALTER TABLE `colores_fondo`
  ADD PRIMARY KEY (`ID_Color_Fondo`);

--
-- Indices de la tabla `configuracion_gym`
--
ALTER TABLE `configuracion_gym`
  ADD PRIMARY KEY (`ID_Configuracion_Gym`),
  ADD KEY `ID_Admin` (`ID_Admin`),
  ADD KEY `fk_color_fondo` (`ID_Color_Fondo`);

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
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `horario_funcionamiento`
--
ALTER TABLE `horario_funcionamiento`
  ADD PRIMARY KEY (`ID_Horario_Funcionamiento`),
  ADD KEY `ID_Configuracion_Gym` (`ID_Configuracion_Gym`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `membresia_socio`
--
ALTER TABLE `membresia_socio`
  ADD PRIMARY KEY (`ID_Membresia_Socio`),
  ADD KEY `ID_Usuario_Socio` (`ID_Usuario_Socio`),
  ADD KEY `ID_Tipo_Membresia` (`ID_Tipo_Membresia`),
  ADD KEY `ID_Estado_Membresia_Socio` (`ID_Estado_Membresia_Socio`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `ID_Usuario_Socio` (`ID_Usuario_Socio`),
  ADD KEY `ID_Usuario_Registro` (`ID_Usuario_Registro`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

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
  ADD KEY `ID_Clase_Programada` (`ID_Clase_Programada`),
  ADD KEY `ID_Socio` (`ID_Socio`);

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
  ADD KEY `rol_permiso_ibfk_2` (`ID_Permiso`);

--
-- Indices de la tabla `rutina`
--
ALTER TABLE `rutina`
  ADD PRIMARY KEY (`ID_Rutina`),
  ADD KEY `ID_Profesor` (`ID_Profesor`),
  ADD KEY `ID_Nivel_Dificultad` (`ID_Nivel_Dificultad`);

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
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

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
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

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
  MODIFY `ID_Asistencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `certificado`
--
ALTER TABLE `certificado`
  MODIFY `ID_Certificado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `clase`
--
ALTER TABLE `clase`
  MODIFY `ID_Clase` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `clase_programada`
--
ALTER TABLE `clase_programada`
  MODIFY `ID_Clase_Programada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `colores_fondo`
--
ALTER TABLE `colores_fondo`
  MODIFY `ID_Color_Fondo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `configuracion_gym`
--
ALTER TABLE `configuracion_gym`
  MODIFY `ID_Configuracion_Gym` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `ejercicio`
--
ALTER TABLE `ejercicio`
  MODIFY `ID_Ejercicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `equipo`
--
ALTER TABLE `equipo`
  MODIFY `ID_Equipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `horario_funcionamiento`
--
ALTER TABLE `horario_funcionamiento`
  MODIFY `ID_Horario_Funcionamiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `membresia_socio`
--
ALTER TABLE `membresia_socio`
  MODIFY `ID_Membresia_Socio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `musculo`
--
ALTER TABLE `musculo`
  MODIFY `ID_Musculo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `nivel_dificultad`
--
ALTER TABLE `nivel_dificultad`
  MODIFY `ID_Nivel_Dificultad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `ID_Pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `ID_Permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `reserva`
--
ALTER TABLE `reserva`
  MODIFY `ID_Reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `ID_Rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `rutina`
--
ALTER TABLE `rutina`
  MODIFY `ID_Rutina` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `sala`
--
ALTER TABLE `sala`
  MODIFY `ID_Sala` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `tipo_membresia`
--
ALTER TABLE `tipo_membresia`
  MODIFY `ID_Tipo_Membresia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `ID_Usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD CONSTRAINT `asistencia_usuario_fk` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuario` (`ID_Usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `certificado`
--
ALTER TABLE `certificado`
  ADD CONSTRAINT `certificado_ibfk_1` FOREIGN KEY (`ID_Usuario_Socio`) REFERENCES `socio` (`ID_Usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `clase`
--
ALTER TABLE `clase`
  ADD CONSTRAINT `clase_ibfk_1` FOREIGN KEY (`ID_Profesor`) REFERENCES `usuario` (`ID_Usuario`);

--
-- Filtros para la tabla `clase_programada`
--
ALTER TABLE `clase_programada`
  ADD CONSTRAINT `clase_programada_ibfk_1` FOREIGN KEY (`ID_Clase`) REFERENCES `clase` (`ID_Clase`) ON DELETE CASCADE,
  ADD CONSTRAINT `clase_programada_ibfk_2` FOREIGN KEY (`ID_Sala`) REFERENCES `sala` (`ID_Sala`);

--
-- Filtros para la tabla `configuracion_gym`
--
ALTER TABLE `configuracion_gym`
  ADD CONSTRAINT `configuracion_gym_ibfk_1` FOREIGN KEY (`ID_Admin`) REFERENCES `usuario` (`ID_Usuario`),
  ADD CONSTRAINT `fk_color_fondo` FOREIGN KEY (`ID_Color_Fondo`) REFERENCES `colores_fondo` (`ID_Color_Fondo`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `ejercicio_equipo`
--
ALTER TABLE `ejercicio_equipo`
  ADD CONSTRAINT `ejercicio_equipo_ibfk_1` FOREIGN KEY (`ID_Ejercicio`) REFERENCES `ejercicio` (`ID_Ejercicio`) ON DELETE CASCADE,
  ADD CONSTRAINT `ejercicio_equipo_ibfk_2` FOREIGN KEY (`ID_Equipo`) REFERENCES `equipo` (`ID_Equipo`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ejercicio_musculo`
--
ALTER TABLE `ejercicio_musculo`
  ADD CONSTRAINT `ejercicio_musculo_ibfk_1` FOREIGN KEY (`ID_Ejercicio`) REFERENCES `ejercicio` (`ID_Ejercicio`) ON DELETE CASCADE,
  ADD CONSTRAINT `ejercicio_musculo_ibfk_2` FOREIGN KEY (`ID_Musculo`) REFERENCES `musculo` (`ID_Musculo`) ON DELETE CASCADE;

--
-- Filtros para la tabla `horario_funcionamiento`
--
ALTER TABLE `horario_funcionamiento`
  ADD CONSTRAINT `horario_funcionamiento_ibfk_1` FOREIGN KEY (`ID_Configuracion_Gym`) REFERENCES `configuracion_gym` (`ID_Configuracion_Gym`) ON DELETE CASCADE;

--
-- Filtros para la tabla `membresia_socio`
--
ALTER TABLE `membresia_socio`
  ADD CONSTRAINT `membresia_socio_ibfk_1` FOREIGN KEY (`ID_Usuario_Socio`) REFERENCES `socio` (`ID_Usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `membresia_socio_ibfk_2` FOREIGN KEY (`ID_Tipo_Membresia`) REFERENCES `tipo_membresia` (`ID_Tipo_Membresia`),
  ADD CONSTRAINT `membresia_socio_ibfk_3` FOREIGN KEY (`ID_Estado_Membresia_Socio`) REFERENCES `estado_membresia_socio` (`ID_Estado_Membresia_Socio`);

--
-- Filtros para la tabla `pago`
--
ALTER TABLE `pago`
  ADD CONSTRAINT `pago_ibfk_1` FOREIGN KEY (`ID_Membresia_Socio`) REFERENCES `membresia_socio` (`ID_Membresia_Socio`) ON DELETE CASCADE,
  ADD CONSTRAINT `pago_ibfk_2` FOREIGN KEY (`ID_Usuario_Socio`) REFERENCES `socio` (`ID_Usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `pago_ibfk_3` FOREIGN KEY (`ID_Usuario_Registro`) REFERENCES `usuario` (`ID_Usuario`);

--
-- Filtros para la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `reserva_ibfk_1` FOREIGN KEY (`ID_Clase_Programada`) REFERENCES `clase_programada` (`ID_Clase_Programada`) ON DELETE CASCADE,
  ADD CONSTRAINT `reserva_ibfk_2` FOREIGN KEY (`ID_Socio`) REFERENCES `socio` (`ID_Usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `rol_permiso`
--
ALTER TABLE `rol_permiso`
  ADD CONSTRAINT `rol_permiso_ibfk_1` FOREIGN KEY (`ID_Rol`) REFERENCES `rol` (`ID_Rol`) ON DELETE CASCADE,
  ADD CONSTRAINT `rol_permiso_ibfk_2` FOREIGN KEY (`ID_Permiso`) REFERENCES `permiso` (`ID_Permiso`) ON DELETE CASCADE;

--
-- Filtros para la tabla `rutina`
--
ALTER TABLE `rutina`
  ADD CONSTRAINT `rutina_ibfk_1` FOREIGN KEY (`ID_Profesor`) REFERENCES `usuario` (`ID_Usuario`),
  ADD CONSTRAINT `rutina_ibfk_2` FOREIGN KEY (`ID_Nivel_Dificultad`) REFERENCES `nivel_dificultad` (`ID_Nivel_Dificultad`);

--
-- Filtros para la tabla `rutina_ejercicio`
--
ALTER TABLE `rutina_ejercicio`
  ADD CONSTRAINT `rutina_ejercicio_ibfk_1` FOREIGN KEY (`ID_Rutina`) REFERENCES `rutina` (`ID_Rutina`) ON DELETE CASCADE,
  ADD CONSTRAINT `rutina_ejercicio_ibfk_2` FOREIGN KEY (`ID_Ejercicio`) REFERENCES `ejercicio` (`ID_Ejercicio`) ON DELETE CASCADE;

--
-- Filtros para la tabla `socio`
--
ALTER TABLE `socio`
  ADD CONSTRAINT `socio_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuario` (`ID_Usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuario_rol`
--
ALTER TABLE `usuario_rol`
  ADD CONSTRAINT `usuario_rol_ibfk_1` FOREIGN KEY (`ID_Rol`) REFERENCES `rol` (`ID_Rol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
