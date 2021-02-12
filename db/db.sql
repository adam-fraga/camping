-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Feb 12, 2021 at 10:50 AM
-- Server version: 5.7.32
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `camping`
--

-- --------------------------------------------------------

--
-- Table structure for table `emplacement`
--

CREATE TABLE `emplacement` (
                               `id_emplacement` int(11) NOT NULL,
                               `id_lieu` int(11) NOT NULL,
                               `nom_emplacement` varchar(30) NOT NULL,
                               `taille` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `emplacement`
--

INSERT INTO `emplacement` (`id_emplacement`, `id_lieu`, `nom_emplacement`, `taille`) VALUES
(1, 1, 'A', 1),
(2, 1, 'B', 1),
(3, 1, 'C', 1),
(4, 1, 'D', 1),
(5, 2, 'A', 1),
(6, 2, 'B', 1),
(7, 2, 'C', 1),
(8, 2, 'D', 1),
(9, 3, 'A', 1),
(10, 3, 'B', 1),
(11, 3, 'C', 1),
(12, 3, 'D', 1);

-- --------------------------------------------------------

--
-- Table structure for table `lieux`
--

CREATE TABLE `lieux` (
                         `id_lieu` int(11) NOT NULL,
                         `nom_lieu` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lieux`
--

INSERT INTO `lieux` (`id_lieu`, `nom_lieu`) VALUES
(1, 'La plage'),
(2, 'Les pins'),
(3, 'Le maquis');

-- --------------------------------------------------------

--
-- Table structure for table `prestations`
--

CREATE TABLE `prestations` (
                               `id_prestation` int(11) NOT NULL,
                               `nom_prestation` varchar(30) NOT NULL,
                               `cout_prestation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `prestations`
--

INSERT INTO `prestations` (`id_prestation`, `nom_prestation`, `cout_prestation`) VALUES
(1, 'Emplacement Tente', 10),
(2, 'Borne électrique', 2),
(3, 'Accès au Disco-club', 17),
(4, 'Yoga/Frisbee/Ski-nautique', 30),
(5, 'Emplacement Camping-car', 20);

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
                                `id_reservation` int(11) NOT NULL,
                                `id_client` int(11) NOT NULL,
                                `date_debut` date NOT NULL,
                                `date_fin` date NOT NULL,
                                `id_emplacement` int(11) NOT NULL,
                                `token` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `total`
--

CREATE TABLE `total` (
                         `id_total` int(11) NOT NULL,
                         `id_reservations` int(11) NOT NULL,
                         `id_prestation` int(11) NOT NULL,
                         `cost` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
                                `id_utilisateur` int(11) NOT NULL,
                                `login` varchar(30) NOT NULL,
                                `password` varchar(255) NOT NULL,
                                `staff` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `emplacement`
--
ALTER TABLE `emplacement`
    ADD PRIMARY KEY (`id_emplacement`),
  ADD KEY `id_lieu` (`id_lieu`);

--
-- Indexes for table `lieux`
--
ALTER TABLE `lieux`
    ADD PRIMARY KEY (`id_lieu`);

--
-- Indexes for table `prestations`
--
ALTER TABLE `prestations`
    ADD PRIMARY KEY (`id_prestation`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
    ADD PRIMARY KEY (`id_reservation`),
  ADD KEY `id_client` (`id_client`),
  ADD KEY `id_emplacement` (`id_emplacement`);

--
-- Indexes for table `total`
--
ALTER TABLE `total`
    ADD PRIMARY KEY (`id_total`),
  ADD KEY `id_reservations` (`id_reservations`),
  ADD KEY `id_options` (`id_prestation`);

--
-- Indexes for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
    ADD PRIMARY KEY (`id_utilisateur`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `emplacement`
--
ALTER TABLE `emplacement`
    MODIFY `id_emplacement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `lieux`
--
ALTER TABLE `lieux`
    MODIFY `id_lieu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `prestations`
--
ALTER TABLE `prestations`
    MODIFY `id_prestation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
    MODIFY `id_reservation` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `total`
--
ALTER TABLE `total`
    MODIFY `id_total` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
    MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `emplacement`
--
ALTER TABLE `emplacement`
    ADD CONSTRAINT `emplacement_ibfk_1` FOREIGN KEY (`id_lieu`) REFERENCES `lieux` (`id_lieu`);

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
    ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `utilisateurs` (`id_utilisateur`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`id_emplacement`) REFERENCES `emplacement` (`id_emplacement`);

--
-- Constraints for table `total`
--
ALTER TABLE `total`
    ADD CONSTRAINT `total_ibfk_1` FOREIGN KEY (`id_reservations`) REFERENCES `reservations` (`id_reservation`),
  ADD CONSTRAINT `total_ibfk_2` FOREIGN KEY (`id_prestation`) REFERENCES `prestations` (`id_prestation`);
