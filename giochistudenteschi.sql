-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2025 at 06:51 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `giochistudenteschi`
--

-- --------------------------------------------------------

--
-- Table structure for table `iscrizioni`
--

CREATE TABLE `iscrizioni` (
  `codiceStud` int(11) NOT NULL,
  `codiceManif` int(11) NOT NULL,
  `dataIscrizione` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `istituti`
--

CREATE TABLE `istituti` (
  `codiceIstituto` varchar(10) NOT NULL,
  `denominazione` varchar(30) NOT NULL,
  `indirizzo` varchar(250) DEFAULT NULL,
  `telefono` varchar(13) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `manifestazioni`
--

CREATE TABLE `manifestazioni` (
  `codiceManif` int(11) NOT NULL,
  `titoloManif` varchar(150) NOT NULL,
  `descrizione` varchar(250) NOT NULL,
  `luogo` varchar(100) DEFAULT NULL,
  `dataInizio` date DEFAULT NULL,
  `codProf` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `professori`
--

CREATE TABLE `professori` (
  `codiceProf` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `cognome` varchar(20) NOT NULL,
  `codIstituto` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `studenti`
--

CREATE TABLE `studenti` (
  `codiceStud` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `cognome` varchar(20) NOT NULL,
  `data_nascita` date DEFAULT NULL,
  `Classe` varchar(2) DEFAULT NULL,
  `codIstituto` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `utenti`
--

CREATE TABLE `utenti` (
  `ID` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `codProf` int(11) DEFAULT NULL,
  `codStud` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `iscrizioni`
--
ALTER TABLE `iscrizioni`
  ADD PRIMARY KEY (`codiceStud`,`codiceManif`),
  ADD KEY `fk_manif` (`codiceManif`),
  ADD KEY `fk_stud` (`codiceStud`);

--
-- Indexes for table `istituti`
--
ALTER TABLE `istituti`
  ADD PRIMARY KEY (`codiceIstituto`),
  ADD UNIQUE KEY `telefono` (`telefono`);

--
-- Indexes for table `manifestazioni`
--
ALTER TABLE `manifestazioni`
  ADD PRIMARY KEY (`codiceManif`),
  ADD KEY `fk_profes` (`codProf`);

--
-- Indexes for table `professori`
--
ALTER TABLE `professori`
  ADD PRIMARY KEY (`codiceProf`),
  ADD KEY `dk_istituto` (`codIstituto`);

--
-- Indexes for table `studenti`
--
ALTER TABLE `studenti`
  ADD PRIMARY KEY (`codiceStud`),
  ADD KEY `fk_istituto` (`codIstituto`);

--
-- Indexes for table `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_studente` (`codStud`),
  ADD KEY `fk_prof` (`codProf`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `manifestazioni`
--
ALTER TABLE `manifestazioni`
  MODIFY `codiceManif` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `professori`
--
ALTER TABLE `professori`
  MODIFY `codiceProf` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `studenti`
--
ALTER TABLE `studenti`
  MODIFY `codiceStud` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `utenti`
--
ALTER TABLE `utenti`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `iscrizioni`
--
ALTER TABLE `iscrizioni`
  ADD CONSTRAINT `fk_manif` FOREIGN KEY (`codiceManif`) REFERENCES `manifestazioni` (`codiceManif`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_stud` FOREIGN KEY (`codiceStud`) REFERENCES `studenti` (`codiceStud`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `manifestazioni`
--
ALTER TABLE `manifestazioni`
  ADD CONSTRAINT `fk_profes` FOREIGN KEY (`codProf`) REFERENCES `professori` (`codiceProf`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `professori`
--
ALTER TABLE `professori`
  ADD CONSTRAINT `dk_istituto` FOREIGN KEY (`codIstituto`) REFERENCES `istituti` (`codiceIstituto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `studenti`
--
ALTER TABLE `studenti`
  ADD CONSTRAINT `fk_istituto` FOREIGN KEY (`codIstituto`) REFERENCES `istituti` (`codiceIstituto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `utenti`
--
ALTER TABLE `utenti`
  ADD CONSTRAINT `fk_prof` FOREIGN KEY (`codProf`) REFERENCES `professori` (`codiceProf`),
  ADD CONSTRAINT `fk_studente` FOREIGN KEY (`codStud`) REFERENCES `studenti` (`codiceStud`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
