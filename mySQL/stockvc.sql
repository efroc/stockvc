-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 06 juin 2024 à 09:07
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
(384, '2024-06-05', '10', 'Modification du stock', 'Un ou plusieurs paramètres du cable  ont été modifié dans le stock.'),
(385, '2024-06-05', '10', 'Modification du stock', 'Un ou plusieurs paramètres du cable  ont été modifié dans le stock.'),
(386, '2024-06-05', '10', 'Ajout aux prêts', 'Un cable  a été prêté à Mairie d\'Argentré du Plessis du 2024-06-05 au 2024-06-12.'),
(387, '2024-06-05', '10', 'Ajout aux prêts', 'Un cable  a été prêté à Mairie d\'Argentré du Plessis du 2024-06-05 au 2024-06-12.'),
(388, '2024-06-05', '10', 'Ajout aux prêts', 'Un cable  a été prêté à Mairie d\'Argentré du Plessis du 2024-06-05 au 2024-06-12.'),
(389, '2024-06-05', '10', 'Ajout aux prêts', 'Un cable  a été prêté à Mairie d\'Argentré du Plessis du 2024-06-05 au 2024-06-12.'),
(390, '2024-06-05', '10', 'Ajout aux prêts', 'Un cable  a été prêté à Mairie d\'Argentré du Plessis du 2024-06-05 au 2024-06-12.'),
(391, '2024-06-05', '10', 'Suppression de prêt', 'Le prêt de cable  à Mairie d Argentré du Plessis du 2024-06-05 au 2024-06-12 a été supprimé.'),
(392, '2024-06-05', '10', 'Suppression de prêt', 'Le prêt de cable  à Mairie d Argentré du Plessis du 2024-06-05 au 2024-06-12 a été supprimé.'),
(393, '2024-06-05', '10', 'Suppression de prêt', 'Le prêt de cable  à Mairie d Argentré du Plessis du 2024-06-05 au 2024-06-12 a été supprimé.'),
(394, '2024-06-05', '10', 'Suppression de prêt', 'Le prêt de cable  à Mairie d Argentré du Plessis du 2024-06-05 au 2024-06-12 a été supprimé.'),
(395, '2024-06-05', '10', 'Suppression de prêt', 'Le prêt de cable  à Mairie d Argentré du Plessis du 2024-06-05 au 2024-06-12 a été supprimé.'),
(396, '2024-06-05', '10', 'Ajout aux prêts', '5 cable  a/ont été prêté à Mairie d\'Argentré du Plessis du 2024-06-05 au 2024-06-12.'),
(397, '2024-06-05', '10', 'Suppression de prêt', 'Le prêt de cable  à Mairie d Argentré du Plessis du 2024-06-05 au 2024-06-12 a été supprimé.'),
(398, '2024-06-05', '10', 'Suppression de prêt', 'Le prêt de cable  à Mairie d Argentré du Plessis du 2024-06-05 au 2024-06-12 a été supprimé.'),
(399, '2024-06-05', '10', 'Suppression de prêt', 'Le prêt de cable  à Mairie d Argentré du Plessis du 2024-06-05 au 2024-06-12 a été supprimé.'),
(400, '2024-06-05', '10', 'Suppression de prêt', 'Le prêt de cable  à Mairie d Argentré du Plessis du 2024-06-05 au 2024-06-12 a été supprimé.'),
(401, '2024-06-05', '10', 'Suppression de prêt', 'Le prêt de cable  à Mairie d Argentré du Plessis du 2024-06-05 au 2024-06-12 a été supprimé.'),
(402, '2024-06-05', '10', 'Retrait du stock', 'Un cable  a été retiré du stock.'),
(403, '2024-06-05', '10', 'Retrait du stock', 'Un cable  a été retiré du stock.'),
(404, '2024-06-05', '10', 'Retrait du stock', 'Un cable  a été retiré du stock.'),
(405, '2024-06-05', '10', 'Retrait du stock', 'Un cable  a été retiré du stock.'),
(406, '2024-06-05', '10', 'Retrait du stock', 'Un cable  a été retiré du stock.'),
(407, '2024-06-05', '1-05', 'Ajout au stock', '1 cable ethernet 50cm ont été ajouté au stock.'),
(408, '2024-06-05', '1-1', 'Ajout au stock', '1 cable ethernet 1m ont été ajouté au stock.'),
(409, '2024-06-05', '1-2', 'Ajout au stock', '1 cable ethernet 2m ont été ajouté au stock.'),
(410, '2024-06-05', '1-5', 'Ajout au stock', '1 cable ethernet 5m ont été ajouté au stock.'),
(411, '2024-06-05', '1-10', 'Ajout au stock', '1 cable ethernet 10m ont été ajouté au stock.'),
(412, '2024-06-05', '2-5', 'Ajout au stock', '1 cable vga 5m ont été ajouté au stock.'),
(413, '2024-06-05', '2-10', 'Ajout au stock', '1 cable vga 10m ont été ajouté au stock.'),
(414, '2024-06-05', '3', 'Ajout au stock', '1 cable alim ont été ajouté au stock.'),
(415, '2024-06-05', '3-S', 'Ajout au stock', '1 cable alim special ont été ajouté au stock.'),
(416, '2024-06-05', '111-111-111', 'Retrait du stock', 'Un pc portable a été retiré du stock.'),
(417, '2024-06-05', '222-222-222', 'Retrait du stock', 'Un pc portable a été retiré du stock.'),
(418, '2024-06-05', '4', 'Ajout au stock', '1 cable tripolaire ont été ajouté au stock.'),
(419, '2024-06-05', '333-333-333', 'Retrait du stock', 'Un pc portable  a été retiré du stock.'),
(420, '2024-06-05', '444-444-444', 'Retrait du stock', 'Un pc portable a été retiré du stock.'),
(421, '2024-06-05', '666-666-666', 'Retrait du stock', 'Un pc portable a été retiré du stock.'),
(422, '2024-06-05', '777-777-777', 'Retrait du stock', 'Un pc portable a été retiré du stock.'),
(423, '2024-06-05', '954-365-856', 'Retrait du stock', 'Un tablette a été retiré du stock.'),
(424, '2024-06-05', '999-999-999', 'Ajout au stock', '1 pc portable ont été ajouté au stock.'),
(425, '2024-06-05', '999-999-999', 'Ajout aux prêts', '1 pc portable a/ont été prêté à Mairie de Val D\'Izé du 2024-06-05 au 2024-06-12.'),
(426, '2024-06-05', ' ', 'Ajout au stock', '1 cable ont été ajouté au stock.'),
(427, '2024-06-05', ' ', 'Retrait du stock', 'Un cable a été retiré du stock.'),
(428, '2024-06-05', '999-999-999', 'Suppression de prêt', 'Le prêt de pc portable à Mairie de Val D Izé du 2024-06-05 au 2024-06-12 a été supprimé.'),
(429, '2024-06-05', '999-999-999', 'Ajout aux prêts', '1 pc portable a/ont été prêté à Mairie de Balazé du 2024-06-05 au 2024-06-07.'),
(430, '2024-06-05', '999-999-999', 'Suppression de prêt', 'Le prêt de pc portable à Mairie de Balazé du 2024-06-05 au 2024-06-07 a été supprimé.'),
(431, '2024-06-05', '999-999-999', 'Ajout aux prêts', '1 pc portable a/ont été prêté à Mairie d\'Argentré du Plessis du 2024-06-05 au 2024-06-12.'),
(432, '2024-06-05', '888-888-888', 'Ajout au stock', '1 pc ont été ajouté au stock.'),
(433, '2024-06-05', '888-888-888', 'Ajout aux prêts', '1 pc a/ont été prêté à Mairie d\'Argentré du Plessis du 2024-06-05 au 2024-06-12.'),
(434, '2024-06-05', '000', 'Ajout au stock', '10 exemple ont été ajouté au stock.'),
(435, '2024-06-05', '', 'Retrait du stock', '5  a été retiré du stock.'),
(436, '2024-06-05', '888-888-888', 'Suppression de prêt', 'Le prêt de pc à Mairie d Argentré du Plessis du 2024-06-05 au 2024-06-12 a été supprimé.'),
(437, '2024-06-05', '999-999-999', 'Suppression de prêt', 'Le prêt de pc portable à Mairie d Argentré du Plessis du 2024-06-05 au 2024-06-12 a été supprimé.'),
(438, '2024-06-05', '1-05', 'Ajout au stock', '4 cable ethernet 50cm ont été ajouté au stock.'),
(439, '2024-06-05', '', 'Retrait du stock', '4  a été retiré du stock.'),
(440, '2024-06-05', '000', 'Ajout aux prêts', '1 exemple a/ont été prêté à Mairie d\'Argentré du Plessis du 2024-06-05 au 2024-06-12.'),
(441, '2024-06-05', '000', 'Suppression de prêt', 'Le prêt de exemple à Mairie d Argentré du Plessis du 2024-06-05 au 2024-06-12 a été supprimé.'),
(442, '2024-06-05', '000', 'Ajout au stock', '1 exemple ont été ajouté au stock.'),
(443, '2024-06-05', '', 'Retrait du stock', '1  a été retiré du stock.'),
(444, '2024-06-05', '', 'Retrait du stock', '5  a été retiré du stock.'),
(445, '2024-06-06', '000', 'Ajout au stock', '10 exemple ont été ajouté au stock.'),
(446, '2024-06-06', '000', 'Ajout aux prêts', '10 exemple a/ont été prêté à Mairie d\'Argentré du Plessis du 2024-06-06 au 2024-06-13.'),
(447, '2024-06-06', '000', 'Suppression de prêt', 'Le prêt de exemple à Mairie d Argentré du Plessis du 2024-06-06 au 2024-06-13 a été supprimé.'),
(448, '2024-06-06', '000', 'Suppression de prêt', 'Le prêt de exemple à Mairie d Argentré du Plessis du 2024-06-06 au 2024-06-13 a été supprimé.'),
(449, '2024-06-06', '000', 'Suppression de prêt', 'Le prêt de exemple à Mairie d Argentré du Plessis du 2024-06-06 au 2024-06-13 a été supprimé.'),
(450, '2024-06-06', '000', 'Suppression de prêt', 'Le prêt de exemple à Mairie d Argentré du Plessis du 2024-06-06 au 2024-06-13 a été supprimé.'),
(451, '2024-06-06', '000', 'Suppression de prêt', 'Le prêt de exemple à Mairie d Argentré du Plessis du 2024-06-06 au 2024-06-13 a été supprimé.'),
(452, '2024-06-06', '000', 'Suppression de prêt', 'Le prêt de exemple à Mairie d Argentré du Plessis du 2024-06-06 au 2024-06-13 a été supprimé.'),
(453, '2024-06-06', '000', 'Suppression de prêt', 'Le prêt de exemple à Mairie d Argentré du Plessis du 2024-06-06 au 2024-06-13 a été supprimé.'),
(454, '2024-06-06', '000', 'Suppression de prêt', 'Le prêt de exemple à Mairie d Argentré du Plessis du 2024-06-06 au 2024-06-13 a été supprimé.'),
(455, '2024-06-06', '000', 'Suppression de prêt', 'Le prêt de exemple à Mairie d Argentré du Plessis du 2024-06-06 au 2024-06-13 a été supprimé.'),
(456, '2024-06-06', '000', 'Suppression de prêt', 'Le prêt de exemple à Mairie d Argentré du Plessis du 2024-06-06 au 2024-06-13 a été supprimé.'),
(457, '2024-06-06', '', 'Retrait du stock', '10  a été retiré du stock.'),
(458, '2024-06-06', '', 'Retrait du stock', '1  a été retiré du stock.'),
(459, '2024-06-06', '', 'Retrait du stock', '1  a été retiré du stock.');

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
