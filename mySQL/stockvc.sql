-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 06 juin 2024 à 09:17
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

--
-- Déchargement des données de la table `historique`
--

INSERT INTO `historique` (`id`, `date`, `reference`, `action`, `message`) VALUES
(1, '2024-06-06', '1-1', 'Ajout au stock', '1 cable ethernet 1m ont été ajouté au stock.'),
(2, '2024-06-06', '1-2', 'Ajout au stock', '1 cable ethernet 2m ont été ajouté au stock.'),
(3, '2024-06-06', '1-5 ', 'Ajout au stock', '1 cable ethernet 5m ont été ajouté au stock.'),
(4, '2024-06-06', '1-10', 'Ajout au stock', '1 cable ethernet 10m ont été ajouté au stock.'),
(5, '2024-06-06', '2-5', 'Ajout au stock', '1 cable vga 5m ont été ajouté au stock.'),
(6, '2024-06-06', '2-10', 'Ajout au stock', '1 cable vga 10m ont été ajouté au stock.'),
(7, '2024-06-06', '3', 'Ajout au stock', '1 cable alim ont été ajouté au stock.'),
(8, '2024-06-06', '3-S', 'Ajout au stock', '1 cable alim special ont été ajouté au stock.'),
(9, '2024-06-06', '4', 'Ajout au stock', '1 cable tripolaire ont été ajouté au stock.'),
(10, '2024-06-06', '1-05', 'Ajout au stock', '1 cable ethernet 0.5m ont été ajouté au stock.');

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
(1, '1-1', 'cable ethernet 1m', '', 'disponible', ''),
(2, '1-2', 'cable ethernet 2m', '', 'disponible', ''),
(3, '1-5 ', 'cable ethernet 5m', '', 'disponible', ''),
(4, '1-10', 'cable ethernet 10m', '', 'disponible', ''),
(5, '2-5', 'cable vga 5m', '', 'disponible', ''),
(6, '2-10', 'cable vga 10m', '', 'disponible', ''),
(7, '3', 'cable alim', '', 'disponible', ''),
(8, '3-S', 'cable alim special', '', 'disponible', ''),
(9, '4', 'cable tripolaire', '', 'disponible', ''),
(10, '1-05', 'cable ethernet 0.5m', '', 'disponible', '');

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
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `stock`
--
ALTER TABLE `stock`
  MODIFY `ident` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
