-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 05, 2023 at 06:00 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tpweb2db`
--

-- --------------------------------------------------------

--
-- Table structure for table `director`
--

CREATE TABLE `director` (
  `director_id` int(11) NOT NULL,
  `Nombre` varchar(45) NOT NULL,
  `Apellido` varchar(45) NOT NULL,
  `Nacionalidad` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `director`
--

INSERT INTO `director` (`director_id`, `Nombre`, `Apellido`, `Nacionalidad`) VALUES
(1, 'Kevin', 'Greutert', 'Estados Unidos'),
(2, 'Alexandr', 'Reshetnikov', 'Rusia');

-- --------------------------------------------------------

--
-- Table structure for table `peliculas`
--

CREATE TABLE `peliculas` (
  `pelicula_id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `genero` varchar(45) NOT NULL,
  `fecha de lanzamiento` date NOT NULL,
  `premios` varchar(45) NOT NULL,
  `duracion en min` int(11) NOT NULL,
  `clasificacion por edades` varchar(45) NOT NULL,
  `presupuesto` int(11) NOT NULL,
  `estudio de produccion` varchar(45) NOT NULL,
  `director_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `peliculas`
--

INSERT INTO `peliculas` (`pelicula_id`, `nombre`, `genero`, `fecha de lanzamiento`, `premios`, `duracion en min`, `clasificacion por edades`, `presupuesto`, `estudio de produccion`, `director_id`) VALUES
(1, 'Saw 10', 'Thriller,Terror,Crimen,Gore', '2023-09-28', '0', 118, 'R', 13000000, 'Twisted Pictures', 1),
(2, 'The Collection', 'Terror', '2012-09-19', '0', 82, 'R', 10000000, 'LD Entertainment', 1),
(3, 'September 7th', 'Terror', '2023-09-05', '0', 185, 'R', 13000000, 'Emika Games', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `director`
--
ALTER TABLE `director`
  ADD PRIMARY KEY (`director_id`);

--
-- Indexes for table `peliculas`
--
ALTER TABLE `peliculas`
  ADD PRIMARY KEY (`pelicula_id`),
  ADD KEY `director_id_idx` (`director_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `director`
--
ALTER TABLE `director`
  MODIFY `director_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `peliculas`
--
ALTER TABLE `peliculas`
  MODIFY `pelicula_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `peliculas`
--
ALTER TABLE `peliculas`
  ADD CONSTRAINT `director_id` FOREIGN KEY (`director_id`) REFERENCES `director` (`director_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;