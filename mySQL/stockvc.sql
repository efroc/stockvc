-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 06 juin 2024 à 09:09
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `stockvc`
--

-- --------------------------------------------------------

--
-- Structure de la table `historique`
--

CREATE TABLE `historique` (
  `id` int(10) NOT NULL,
  `date` date NOT NULL,
  `reference` varchar(30) NOT NULL,
  `action` varchar(40) NOT NULL,
  `message` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `pret`
--

CREATE TABLE `pret` (
  `ident` int(10) NOT NULL,
  `reference` varchar(30) NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `client` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `stock`
--

CREATE TABLE `stock` (
  `ident` int(10) NOT NULL,
  `reference` varchar(30) NOT NULL,
  `materiel` varchar(30) NOT NULL,
  `marque` varchar(30) NOT NULL,
  `etat` varchar(20) NOT NULL,
  `note` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `stock`
--

INSERT INTO `stock` (`ident`, `reference`, `materiel`, `marque`, `etat`, `note`) VALUES
(185, '1-1', 'cable ethernet 1m', '', 'disponible', ''),
(186, '1-2', 'cable ethernet 2m', '', 'disponible', ''),
(187, '1-5', 'cable ethernet 5m', '', 'disponible', ''),
(188, '1-10', 'cable ethernet 10m', '', 'disponible', ''),
(189, '2-5', 'cable vga 5m', '', 'disponible', ''),
(190, '2-10', 'cable vga 10m', '', 'disponible', ''),
(191, '3', 'cable alim', '', 'disponible', ''),
(192, '3-S', 'cable alim special', '', 'disponible', ''),
(193, '4', 'cable tripolaire', '', 'disponible', ''),
(210, '1-05', 'cable ethernet 50cm', '', 'disponible', '');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `historique`
--
ALTER TABLE `historique`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pret`
--
ALTER TABLE `pret`
  ADD PRIMARY KEY (`ident`);

--
-- Index pour la table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`ident`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `historique`
--
ALTER TABLE `historique`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=460;

--
-- AUTO_INCREMENT pour la table `stock`
--
ALTER TABLE `stock`
  MODIFY `ident` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=222;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
