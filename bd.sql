-- phpMyAdmin SQL Dump
-- version 5.2.1-1.el8.remi
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : dim. 06 août 2023 à 21:08
-- Version du serveur : 8.0.30
-- Version de PHP : 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `Q220251`
--

-- --------------------------------------------------------

--
-- Structure de la table `participer`
--

CREATE TABLE `participer` (
  `uid` int DEFAULT NULL,
  `tid` int DEFAULT NULL,
  `dateParticipation` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `participer`
--

INSERT INTO `participer` (`uid`, `tid`, `dateParticipation`) VALUES
(26, 10, '2023-04-13'),
(26, 8, '2023-04-15'),
(26, 24, '2023-04-15'),
(26, 8, '2023-04-15'),
(26, 26, '2023-04-15'),
(26, 26, '2023-04-15'),
(26, 27, '2023-04-15'),
(26, 27, '2023-04-15'),
(26, 24, '2023-04-15'),
(26, 6, '2023-04-15'),
(23, 2, '2023-04-16'),
(26, 36, '2023-04-17'),
(26, 31, '2023-07-21'),
(26, 34, '2023-07-21'),
(25, 6, '2023-07-21'),
(31, 7, '2023-07-23'),
(42, 6, '2023-07-24'),
(49, 31, '2023-07-24'),
(40, 6, '2023-07-25'),
(25, 5, '2023-07-25'),
(25, 2, '2023-07-25'),
(31, 47, '2023-07-26'),
(31, 44, '2023-07-26'),
(31, 46, '2023-07-26'),
(31, 43, '2023-07-26'),
(31, 23, '2023-07-26'),
(55, 44, '2023-07-27'),
(55, 47, '2023-07-27'),
(55, 42, '2023-07-27'),
(NULL, 42, '2023-07-27'),
(NULL, 41, '2023-07-27'),
(NULL, 45, '2023-07-27'),
(NULL, 41, '2023-07-27'),
(NULL, 48, '2023-07-27'),
(NULL, 48, '2023-07-27'),
(NULL, 47, '2023-07-27'),
(NULL, 47, '2023-07-27'),
(NULL, 44, '2023-07-27'),
(NULL, 43, '2023-07-27'),
(NULL, 45, '2023-07-27'),
(NULL, 44, '2023-07-27'),
(NULL, 48, '2023-07-27'),
(NULL, 23, '2023-07-27'),
(NULL, 36, '2023-07-27'),
(NULL, 36, '2023-07-27'),
(NULL, 45, '2023-07-27'),
(NULL, 6, '2023-07-27'),
(58, 46, '2023-07-27'),
(57, 49, '2023-07-27'),
(31, 48, '2023-07-28'),
(23, 48, '2023-07-28'),
(61, 6, '2023-07-28'),
(31, 43, '2023-07-30'),
(42, 51, '2023-07-30'),
(46, 51, '2023-07-30'),
(31, 48, '2023-07-31'),
(31, 49, '2023-08-01'),
(31, 49, '2023-08-01'),
(31, 50, '2023-08-01'),
(31, 38, '2023-08-01'),
(25, 50, '2023-08-01'),
(25, 38, '2023-08-01'),
(25, 45, '2023-08-01'),
(25, 40, '2023-08-01'),
(25, 40, '2023-08-01'),
(31, 28, '2023-08-01'),
(31, 37, '2023-08-01'),
(25, 37, '2023-08-01'),
(25, 37, '2023-08-01'),
(31, 35, '2023-08-01'),
(25, 35, '2023-08-01'),
(25, 35, '2023-08-01'),
(31, 23, '2023-08-01'),
(25, 52, '2023-08-01'),
(25, 52, '2023-08-01'),
(31, 3, '2023-08-01'),
(31, 3, '2023-08-01'),
(71, 26, '2023-08-01'),
(75, 24, '2023-08-02'),
(31, 51, '2023-08-02'),
(76, 2, '2023-08-03'),
(79, 62, '2023-08-04'),
(79, 7, '2023-08-04'),
(79, 2, '2023-08-04'),
(79, 30, '2023-08-04'),
(79, 6, '2023-08-04'),
(82, 51, '2023-08-04'),
(70, 30, '2023-08-05'),
(70, 7, '2023-08-05'),
(70, 63, '2023-08-05'),
(70, 62, '2023-08-05'),
(31, 68, '2023-08-06'),
(70, 68, '2023-08-06'),
(70, 67, '2023-08-06'),
(70, 51, '2023-08-06'),
(70, 66, '2023-08-06'),
(31, 67, '2023-08-06'),
(70, 23, '2023-08-06'),
(31, 77, '2023-08-06'),
(82, 23, '2023-08-06'),
(31, 85, '2023-08-06'),
(82, 85, '2023-08-06'),
(82, 78, '2023-08-06'),
(31, 86, '2023-08-06'),
(82, 86, '2023-08-06'),
(70, 86, '2023-08-06'),
(72, 86, '2023-08-06');

-- --------------------------------------------------------

--
-- Structure de la table `rencontre`
--

CREATE TABLE `rencontre` (
  `rid` int NOT NULL,
  `tid` int DEFAULT NULL,
  `joueur1` int DEFAULT NULL,
  `joueur2` int DEFAULT NULL,
  `scoreJ1` int DEFAULT NULL,
  `scoreJ2` int DEFAULT NULL,
  `id_vainqueur` int DEFAULT NULL,
  `rid_suivant` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `rencontre`
--

INSERT INTO `rencontre` (`rid`, `tid`, `joueur1`, `joueur2`, `scoreJ1`, `scoreJ2`, `id_vainqueur`, `rid_suivant`) VALUES
(23, 51, 42, 46, NULL, NULL, NULL, NULL),
(24, 51, 31, 82, NULL, NULL, NULL, NULL),
(25, 51, 42, 46, NULL, NULL, NULL, NULL),
(26, 51, 31, 82, NULL, NULL, NULL, NULL),
(27, 51, 42, 46, NULL, NULL, NULL, NULL),
(28, 51, 31, 82, NULL, NULL, NULL, NULL),
(29, 51, 42, 46, NULL, NULL, NULL, NULL),
(30, 51, 31, 82, NULL, NULL, NULL, NULL),
(31, 85, 31, 82, NULL, NULL, NULL, NULL),
(32, 85, 31, 82, NULL, NULL, NULL, NULL),
(33, 85, 31, 82, NULL, NULL, NULL, NULL),
(34, 85, 31, 82, NULL, NULL, NULL, NULL),
(35, 85, 31, 82, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `sport`
--

CREATE TABLE `sport` (
  `sid` int NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `sport`
--

INSERT INTO `sport` (`sid`, `nom`) VALUES
(1, 'Echec'),
(2, 'Fifa'),
(3, 'Belotte'),
(4, 'Tennis'),
(5, 'Ping-Pong');

-- --------------------------------------------------------

--
-- Structure de la table `statut`
--

CREATE TABLE `statut` (
  `id_statut` int NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `statut`
--

INSERT INTO `statut` (`id_statut`, `nom`) VALUES
(1, 'Ouvert'),
(2, 'Fermer'),
(3, 'Terminé'),
(4, 'En cours'),
(5, 'Généré'),
(6, 'Cloturé');

-- --------------------------------------------------------

--
-- Structure de la table `token`
--

CREATE TABLE `token` (
  `id_token` int NOT NULL,
  `courriel` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `cle` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `token`
--

INSERT INTO `token` (`id_token`, `courriel`, `cle`) VALUES
(2, 'b.bouzia@student.helmo.be', 'z3sOkm4XR45a551TnOFtsVqC1AP2IkDh'),
(3, 'b.bouzia@student.helmo.be', 'D4RbxNcB7t6r3eYEvHTTgagtcuoCZtaC'),
(6, 'a.mohammad@student.helmo.be', '3zwDAcrOiyWIyC3QefNJTkNW8yTU3Zq6'),
(7, 'a.mohammad@student.helmo.be', 'D8Fd5JApcYwAHzwhKlXgJaQcyS6Rv3z8'),
(8, 'sd@gmail.com', 'I6NWs5OxRjr0whXCDHJbFYDaa1zMPLby'),
(9, 'yassine.bouzia@gmail.com', 'bRrJbDe1EpDtkx7UIqbw9FFjHPbP62Li'),
(10, 'yassine.bouzia@gmail.com', 'A8vow6dj5lDgSHYs7r1VscEVRWxUGnAg'),
(11, 'oussamachour@hotmail.fr', 'aSDhDSmolyLeMpiYqgGbw5W6iQL5QMd0'),
(13, 'steambadr09@gmail.com', 'BOTBCefPo6izNTW2gO9hfUjRi8l1Lvun'),
(15, 'steambadr09@gmail.com', 'itjmDbQVImwpRCvefNhVWxHH5ZJSpj2I');

-- --------------------------------------------------------

--
-- Structure de la table `tournoi`
--

CREATE TABLE `tournoi` (
  `tid` int NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sid` int DEFAULT NULL,
  `placesDisponibles` int DEFAULT NULL,
  `id_statut` int DEFAULT NULL,
  `dateTournois` date DEFAULT NULL,
  `dateFininscription` date DEFAULT NULL,
  `estActif` tinyint(1) DEFAULT NULL,
  `id_organisateur` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tournoi`
--

INSERT INTO `tournoi` (`tid`, `nom`, `sid`, `placesDisponibles`, `id_statut`, `dateTournois`, `dateFininscription`, `estActif`, `id_organisateur`) VALUES
(2, 'MagnusCarlsen', 1, 0, 1, '2023-04-05', '2023-04-20', 0, 25),
(3, 'FutChampion', 2, 6, 1, '2023-04-05', '2023-04-20', 0, 25),
(4, 'BelotteChamp', 3, 8, 1, '2023-04-05', '2023-04-20', 0, 25),
(5, 'RollandGarros', 4, 8, 1, '2023-04-05', '2023-04-20', 0, 25),
(6, 'Ping-Pong T', 5, 3, 6, '2023-04-05', '2023-04-20', 1, 25),
(7, 'Psycho17', 2, 6, 6, '2023-04-05', '2023-04-20', 1, 25),
(8, 'Sardoche', 1, 6, 1, '2023-04-08', '2023-04-20', 0, 25),
(9, 'Belotte Party', 3, 16, 1, '2023-04-05', '2023-04-28', 0, 25),
(10, 'FifaCup', 2, 16, 4, '2023-04-05', '2023-04-20', 0, 25),
(11, 'Saiken', 1, 16, 2, '2023-04-05', '2023-04-20', 0, 25),
(12, 'Quel Echec', 5, 8, 2, '2023-04-05', '2023-04-20', 0, 25),
(23, 'fifa', 2, 4, 6, '2023-04-14', '2023-04-27', 1, 1),
(24, 'Echec', 1, 7, 1, '2023-04-14', '2023-04-21', 0, 1),
(26, 'magnus', 1, 4, 1, '2023-04-14', '2023-04-17', 0, 1),
(27, 'ffiacup', 2, 4, 1, '2023-04-15', '2023-04-17', 0, 1),
(28, 'ffiacup', 2, 5, 1, '2023-04-15', '2023-04-17', 0, 1),
(29, 'sndviviefiv', 4, 3, 4, '2023-04-14', '2023-04-15', 0, 1),
(30, 'fifaFermer', 2, 14, 2, '2023-04-05', '2023-04-30', 0, 25),
(31, 'gg', 4, 4, 1, '2023-04-23', '2023-04-30', 0, 1),
(32, 'zzzz', 2, 2, 1, '2023-04-16', '2023-04-17', 0, 1),
(33, 'mn', 4, 4, 1, '2023-05-04', '2023-05-07', 0, 1),
(34, 'mn', 4, 4, 1, '2023-05-04', '2023-05-07', 0, 1),
(35, 'abuzer', 3, 1, 2, '2023-04-23', '2023-04-24', 0, 1),
(36, 'rub', 3, 1, 2, '2023-04-18', '2023-04-23', 0, 1),
(37, 'gg', 2, 3, 1, '2023-07-22', '2023-07-29', 0, 1),
(38, 'jjk', 2, 8, 3, '2023-07-25', '2023-07-27', 0, 1),
(39, 'SDM', 5, 5, 1, '2023-07-26', '2023-07-29', 0, 1),
(40, 'SDM', 5, 4, 1, '2023-07-26', '2023-07-29', 0, 1),
(41, 'ON PEUT OU????', 2, 0, 1, '2023-07-27', '2023-07-29', 0, 1),
(42, 'BV', 3, 0, 1, '2023-07-27', '2023-07-29', 0, 1),
(43, 'BANKAI', 3, 0, 2, '2023-07-27', '2023-08-05', 0, 1),
(44, 'DBZ', 5, 0, 1, '2023-07-27', '2023-07-29', 0, 1),
(45, 'RS8', 1, 6, 1, '2023-07-27', '2023-07-29', 0, 1),
(46, 'ICHI', 4, 11, 1, '2023-07-29', '2023-07-27', 0, 1),
(47, 'EMEUTE', 3, 0, 1, '2023-07-27', '2023-07-29', 0, 1),
(48, 'Satoru', 1, 4, 1, '2023-07-27', '2023-07-29', 0, 1),
(49, 'League of ', 1, 4, 1, '2023-07-28', '2023-07-30', 0, 1),
(50, 'bb', 3, 4, 1, '2023-08-06', '2023-09-07', 0, 1),
(51, 'ULG', 4, 11, 6, '2023-07-28', '2023-07-30', 1, 1),
(52, 'senkaimon', 4, 11, 1, '2023-07-20', '2023-07-28', 0, 1),
(53, 'new balance', 3, 11, 1, '2023-08-19', '2023-08-27', 0, 1),
(54, 'az', 3, 2, 1, '2023-08-26', '2023-08-28', 0, 1),
(55, 'Gojo vs sukuna', 1, 8, 1, '2023-08-02', '2023-08-03', 0, 1),
(56, 'lg2', 2, 10, 1, '2023-08-02', '2023-07-31', 0, 1),
(57, 'GENIN', 5, 2, 1, '2023-08-02', '2023-08-01', 0, 1),
(58, 'Benimaru', 1, 12, 1, '2023-08-05', '2023-08-02', 0, 1),
(59, 'baakaaaaaa', 1, 12, 1, '2023-08-19', '2023-08-09', 0, 1),
(60, 'fardin', 4, 5, 1, '2023-08-17', '2023-08-09', 0, 1),
(61, 'dreyfus', 4, 32, 1, '2023-08-12', '2023-08-09', 0, 1),
(62, 'ML1', 5, 18, 1, '2023-08-06', '2023-08-02', 0, 1),
(63, 'amaterasu', 3, 9, 1, '2023-08-06', '2023-08-04', 0, 1),
(64, 'test', 3, 10, 1, '2023-08-03', '2023-08-01', 0, 1),
(65, 'test', 3, 10, 1, '2023-08-01', '2023-07-31', 0, 1),
(66, 'f10', 4, 9, 6, '2023-08-05', '2023-08-04', 0, 1),
(67, 'kenshin', 1, 8, 6, '2023-08-06', '2023-08-03', 0, 1),
(68, 'kj', 3, 0, 2, '2023-08-08', '2023-08-07', 0, 1),
(69, 'fermer', 4, 14, 6, '2023-08-13', '2023-08-05', 0, 1),
(70, 'op', 3, 10, 1, '2023-08-20', '2023-08-10', 0, 1),
(71, 'bv', 2, 12, 1, '2023-08-13', '2023-08-11', 0, 1),
(72, 'terminaod', 5, 8, 1, '2023-08-13', '2023-08-11', 0, 1),
(73, 'pppp', 3, 10, 1, '2023-08-13', '2023-08-09', 0, 1),
(74, 'hj', 3, 10, 1, '2023-08-13', '2023-08-10', 0, 1),
(75, 'nv', 4, 10, 1, '2023-08-20', '2023-08-19', 0, 1),
(76, 'testo', 3, 20, 3, '2023-08-20', '2023-08-19', 0, 1),
(77, 'az', 4, 4, 1, '2023-09-03', '2023-08-30', 1, 1),
(78, 'pourquoi', 2, 2, 1, '2023-08-10', '2023-08-09', 1, 1),
(79, 'hh', 4, 10, 3, '2023-08-20', '2023-08-19', 0, 1),
(80, 'tera', 1, 10, 3, '2023-08-27', '2023-08-03', 0, 1),
(81, 'sql', 4, 11, 1, '2023-08-18', '2023-08-11', 1, 1),
(82, 'jkrowling', 2, 10, 3, '2023-09-10', '2023-09-01', 0, 1),
(83, 'xmen', 2, 10, 6, '2023-08-02', '2023-08-01', 1, 1),
(84, 'svg', 4, 10, 3, '2023-09-10', '2023-09-06', 0, 1),
(85, 'sq9', 3, 0, 5, '2023-09-10', '2023-08-26', 1, 1),
(86, 'party', 2, 1, 1, '2023-08-13', '2023-08-10', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `uid` int NOT NULL,
  `courriel` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pseudo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mdp` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estActif` tinyint(1) DEFAULT NULL,
  `estOrganisateur` tinyint(1) DEFAULT NULL,
  `urlPhoto` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`uid`, `courriel`, `pseudo`, `nom`, `prenom`, `mdp`, `estActif`, `estOrganisateur`, `urlPhoto`) VALUES
(23, 'a@gmail.com', 'a', 'art', 'bouzia', '$2y$10$JydVmZ53eHBNtbYRk3CgJ.qZRSiviCXf27KLO.D3uEwAB7gaxJDJS', 1, 0, 'téléchargement (1).jpg'),
(24, 'w@gmail.com', 'W8', 'W8', 'W8', '$2y$10$jU/dZpJt5tLqUvILe6BMkOKNQATHh.W8h2vM745AnVz7AKFlERT96', 1, 0, 'uploads/page19diagrammeEtat.png'),
(25, 'admin@gmail.com', 'admin', 'compte', 'admin', '$2y$10$HDxbciTj3LLWT2pKhsBvO.99HmfW/0HvOtnRLEer5kCqBbLFXZ0RO', 1, 1, '52dae37cdd8241b264efb8468868ba99.jpg'),
(26, 'erenjeager@gmail.com', 'jotaro40', 'badr', 'bouzia', '$2y$10$Q4K/2WJw0CZTdHJmw9ldcOxVe2B1Yd3NkrnTwBFe3i/FLx4Sapk5i', 0, 0, 'b053c978fd22a97a65b8bb3fee3651ab.jpg'),
(27, 'badrbouzia@gmail.com', 'jotaro40', 'bouzia', 'badr', '$2y$10$44RUAIGTmylB8gIXfjHp8.mKAt4VDBbqwUrYPjfNRlakymg6pJBvG', 1, 0, 'uploads/QUZCD0R7UwGWGn51YWCCatVAH4Y.jpg'),
(29, 'ikramul@gmail.com', 'ikramul', 'nurul', 'ikra', '$2y$10$pzna0eG2Z183TLJYXRrIduOV5XxK13dlpJDGw2tk2WQZ6m4PI2Yg.', 1, 0, 'b053c978fd22a97a65b8bb3fee3651ab.jpg'),
(30, 'ruben@gmail.com', 'ruben', 'trafalgar', 'ruben', '$2y$10$z52xzsOs6mn7PKaoKpgjZeCVxyDJWnV3QaaZ5Ge16vdlIbq7MoxTW', 0, 0, 'QUZCD0R7UwGWGn51YWCCatVAH4Y.jpg'),
(31, 'isagi@gmail.com', 'jotaro', 'bouzia', 'badr', '$2y$10$KRoueVR9ciBz7HOcin4H6O.lAY8NyDIgpgpQ69vnk1BqqwW9xp4M6', 1, 0, 'image7.jpeg'),
(34, 'kaka@gmail.com', 'kaka', 'kaka', 'kaka', '$2y$10$4.HWWKeO0g7o1M72LmK8guCnLV6argL0GdWuARaWGjr7z2Q5qscri', 1, 0, 'deja-vu--toji-fushiguro-22595335-051020210958.jpg'),
(35, 'gojo@gmail.com', 'gojo', 'gojo', 'gojo', '$2y$10$M5R6jhwxZy/8NOp3qvVIG.S52qNdGKmF9UmaBGcAyASC9hK7XQc1W', 0, 0, 'gojo-satoru-8sz62hlsg1epni6l.jpg'),
(36, 'yojo@gmail.com', 'yojo', 'yojo', 'yojo', '$2y$10$BtYmvG9WdzfSr0l4i7Yzge81LZaIRtRVqTDBNic4KuSijTb211heu', 0, 0, 'gojo-satoru-8sz62hlsg1epni6l.jpg'),
(37, 'yasuo@gmail.com', 'yasuo', 'yasuo', 'yasuo', '$2y$10$io4.TOpP9r2Djk/yjSdkUOAGWz5IUOnsRLk6Eh2BVKQ3VaD3pkukK', 1, 0, '../uploads/7488v48312m81.jpg'),
(38, 'test@gmail.com', 'test', 'test', 'test', '$2y$10$x.03SxM9hB6UZY1qhXPJ9eKGRJCDxpIYJt1ideqnusPanfqUUq19S', 0, 0, 'uploads/6291845.jpg'),
(39, 'lo@gmail.com', 'lo', 'lo', 'lo', '$2y$10$zWVgjvlxn5cG461VBnJageyi6FxVCZ0I8uVAYrQqzCJzEUM8kFSIu', 1, 0, 'uploads/18aec7edee841f7dd0b75bb48f799d81.jpg'),
(40, 'toji@gmail.com', 'tojiF', 'tojiF', 'toji', '$2y$10$DqyVPLPcAqlgIeJAhsk9LeV79BjFH16xu.JnBKwVeAjNQaQ91YHVK', 1, 0, 'deja-vu--toji-fushiguro-22595335-051020210958.jpg'),
(41, 'satoru@gmail.com', 'satoru', 'satoru', 'gojo', '$2y$10$sQCDbJutiu/Ubb4yCWs8pe0B/XKodqilep1ZlnMN9ThXr19X7exWe', 1, 0, '../uploads/gojo-satoru-8sz62hlsg1epni6l.jpg'),
(42, 'bak@gmail.com', 'baki', 'baki', 'hanma', '$2y$10$8Vem69XG0FCtIIxDlPOa.ehMI1ht.hlHkWFVAIek3vQf5YwAMAisO', 1, 0, 'image7.jpeg'),
(43, 'q@gmail.com', 'qzet', 'qwerty', 'Q8', '$2y$10$wMgwTuP0NgHnjuubXr80/OwfLpKlSqdVm.inZrZPhu0C85NWh8Z1K', 1, 0, '52dae37cdd8241b264efb8468868ba99.jpg'),
(45, 'nb@gmail.com', 'nb', 'nb', 'nb', '$2y$10$.tR0UU.6SZJ8yzOQtxK0Uuj0T/oG4fQjv/iqeLudhxQFfxZ3kB6AW', 1, 0, '7488v48312m81.jpg'),
(46, 'hf@gmail.com', 'hf', 'hf', 'hf', '$2y$10$5BXoxubXyFcXGPRtIk6fFuAM9TwOqc7DxBdHMbo0MLtERawixfdTm', 1, 0, '848cf6ed73e1a61386a665ac57be6610.jpg'),
(47, 'lm@gmail.com', 'lm', 'lm', 'lm', '$2y$10$TRngCc4Z1tA0M9k4SgikD.Cdo8I.wCa2wIyZWx83i.stvDDpQAFKu', 1, 0, '/home/q220251/public_html/EVAL_V4_MODIF/uploads/yo.jpg'),
(48, 'c@gmail.com', 'c', 'c', 'c', '$2y$10$EMUCVMNqOo1icruuoFRGnuU53ZbGjLjipRlUU05HoiRPyA6q323Qy', 1, 0, '7488v48312m81.jpg'),
(49, 'wx@gmail.com', 'wx', 'wx', 'wx', '$2y$10$vXSnSEk34rEluAL2olGv4uBz03cBrIr9cZQgpn7w1jqKgsU9TwfvW', 1, 0, '107-1070259_cute-ghost-png-cute-ghost-pixel-art-transparent.png'),
(50, 'ous@gmail.com', 'oussamaAchour', 'oussama', 'Achour', '$2y$10$igr26J/9Wc1C6rPBVFZuoOGvYIz9LeW8h9lqegXgstArfS40nV6zW', 1, 0, 'E32OvJUXwAclmIk.jpg'),
(51, 'fg@gmail.com', 'fg', 'fg', 'fg', '$2y$10$kATb8xxMLUOW7fKZuy9JzemDKw8lCwH4Zk5Ss1DLcp/DuiC9Qh8J6', 1, 0, 'uploads/gojo-satoru-8sz62hlsg1epni6l.jpg'),
(52, 'azerty@gmail.com', 'azerty', 'azerty', 'azerty', '$2y$10$5JQvLnkVq1/nPm0dOTK7bO9JoPopoJfdU85pASbG1.mgiUwAn66pO', 1, 0, 'uploads/7488v48312m81.jpg'),
(53, 'toji@gmail.com', 'toji', 'toji', 'fushigoro', '$2y$10$aD1cfi7gDUr8AzCSW5ru3eTLuxxKcqd7PXxqUGVbaABPDDnGbg2vq', 1, 0, 'deja-vu--toji-fushiguro-22595335-051020210958.jpg'),
(54, 'yassine@gmail.com', 'ybza', 'yassine', 'bza', '$2y$10$MA9m.Wzn2GTznlWWrqNUK.RuKergMkWEhTckj0pX8Kpg0dDohH8yG', 1, 0, '52dae37cdd8241b264efb8468868ba99.jpg'),
(55, 'byrozhdgaming@gmail.com', 'B.MHWK', 'Badr', 'Mihawk', '$2y$10$FYrp5FpvG0pQIF.5jTRqDuD3Nqt3XlmkyKNYwmmVx3UJxoFcO5cte', 1, 0, '52dae37cdd8241b264efb8468868ba99.jpg'),
(56, 'faiyaz002@hotmail.com', 'phyzer', 'faiyaz', 'Rahman', '$2y$10$SWBvv63Iz1frTV5yj73.x.TzdG4zDInEvsD9CsCjq6pG58m0PKMfC', 1, 0, 'E32OvJUXwAclmIk.jpg'),
(57, 'ruben500@hotmail.fr', 'R9', 'ruben', 'yildiz', '$2y$10$fQolKj9hspSxbjP0DO3Ev.Ti83pshtL8nxwkGvb7KVbxEUn9i3o9O', 1, 0, 'uploads/3772483a4a222b5033c884704ab12c76.jpg'),
(58, 'fushi@gmail.com', 'fishi', 'fushi', 'isagi', '$2y$10$lf7dLfip4jqGoUMomttueuwqPGxGizW8jsv4DmC0pUVSNwleviLmK', 1, 0, 'uploads/848cf6ed73e1a61386a665ac57be6610.jpg'),
(59, 'mahfoudhirayene23@gmail.com', 'Karune23', 'Mahfoudhi', 'Rayene', '$2y$10$50Egt3xJGcGDjGlBi20Q7ugBBEgzOps5LC0p70Av2RYeykwPk9US6', 1, 0, '5z6qv3.jpg'),
(60, 'ramon.boti7@gmail.com', 'R7', 'Ramon', 'Boti', '$2y$10$s5jl9R1srUEf1BRPqBVoeehalcu57g7SzsiBLlkHjpGJzldqedD0q', 1, 0, 'a21638fc2c023b6b53f15904e828cd3c.jpg'),
(61, 'soyturk001@gmail.com', 'Soyturk58', 'soyturk', 'philippe', '$2y$10$THulTCpaOV4fAF0Pjz.VvemyCUUNxJQAVKgTnKvtL0tVe57PA88x2', 1, 0, 'téléchargement.jpg'),
(62, 'sad@gmail.com', 'sadd', 'sad', 'sadness', '$2y$10$o/Or2J3gwo/oA36Rkw4MOewVNC4g0N4rYdsdJsgD/HPi7CZvieFdG', 1, 0, 'uploads/c687c90799004174e41fb94a6c92f9fa--artsy-adidas-running.jpg'),
(63, 'i.chikhi@student.helmo.be', 'Seydin', 'Chikhi', 'Ibrahim', '$2y$10$mf/Zzj5lYIednm2w7wMNo.A2m.C/Kn5PMJE2lZs3IfDpbvo/Cz20e', 1, 0, 'uploads/Capture d\'écran_20230110_220458.png'),
(65, 'artbadr09@gmail.com', 'bzzz', 'art', 'badr', '$2y$10$EZbE8KsUbatCv8TMlhHjSelKYhRD3JOkbIfn2DnVZYkeFqiBLFYhq', 0, 0, 'uploads/107-1070259_cute-ghost-png-cute-ghost-pixel-art-transparent.png'),
(68, 'rubenyildiz5@gmail.com', 'rubenyildiz5', 'rubenyildiz5', 'rubenyildiz5', '$2y$10$XI2./GXJrcWJf//jlidDueiuWpJMXXw2OMD9qw4yPTbzUFuxPMGuW', 0, 0, 'uploads/'),
(69, 'steambadr09@gmail.com', 'steambadr09', 'steambadr09', 'steambadr09', '$2y$10$LYx7KNn/V13XYE1AGrrrdu7ABYdQcri0KIgV3ZCzyPmQeCLwQwCm6', 1, 0, 'uploads/52dae37cdd8241b264efb8468868ba99.jpg'),
(70, 'b.bouzia@student.helmo.be', 'b.bouzia', 'b.bouzia', 'b.bouzia', '$2y$10$u22rwM403c.JBq4zxTJer.7YW6nwnUGjVxbylwKz04X97tzTb4Tdi', 1, 0, '52dae37cdd8241b264efb8468868ba99.jpg'),
(71, 'Faiyazrahman020@gmail.com', 'Yallow', 'Faiyaz', 'zizou', '$2y$10$a2EC9Udhg2.Um45.ROZ9.OL0h2YOfb0z6JIj3Cx3t.1cS1SGbh/we', 1, 0, 'image.png'),
(72, 'terre@gmail.com', 'terre', 'terre', 'terre', '$2y$10$B.KHWH3ycVNZH/zNrkCPuOAyUSdiDoYVRXOLj2p.4ggMnAP0xXGZu', 1, 0, '7488v48312m81.jpg'),
(73, 'tan@gmail.com', 'tanjiro', 'tan', 'tan', '$2y$10$QnsP//PQiIm1d1lmqFiXDOimZruTofvyUr0mGswCC2iyWrMi.HDbG', 1, 0, 'uploads/dark-anime-glowing-eyes-pfp-1.jpg'),
(74, 'kokoshibo@gmail.com', 'kokoshibo', 'kokoshibo', 'kokoshibo', '$2y$10$X154V83xubknllqioduQSuraULMRuIip1Cxzt/luZqFDSDgcQ64DG', 1, 0, 'cool-anime-pfp-02.jpg'),
(75, 'maitreyi@gmail.com', 'maitreyi', 'maitreyi', 'SS', '$2y$10$F4suzuo/hYzLXIxaDMxt.ufOikMLn6uIVAJPDxtQlCnd1y42XCYVW', 1, 0, 'uaKsnKg.jpg'),
(76, 'yuta@gmail.com', 'YutaOK', 'yuta', 'okkutsu', '$2y$10$MPFBZxd7KkBalzcBgb225OV36zgF8N0edKBMp8dzyLyt4aD2KvK1S', 1, 0, 'uploads/E32OvJUXwAclmIk.jpg'),
(79, 'hamza@gmail.com', 'zamzam', 'amk', 'hamza', '$2y$10$Ycb2kkMZZZDkZwFnyho1YesuRU.qMW.RH1NH1A4PWLacOzRjZPGUG', 1, 0, '9c10bc726ccdc0322b3ffaf62060ae74.jpg'),
(80, 'sd@gmail.com', 'sd', 'sd', 'sd', '$2y$10$9MXEQIhymByuv1ztN91yFe1IAAXuO4T2m/bWd3bRg/a1QWFG6cUOq', 0, 0, 'uploads/8bf42d2160b39e735434523da38be25c.jpg'),
(81, 'yassine.bouzia@gmail.com', 'yass', 'yass', 'encore', '$2y$10$p21edDl6QfZYr96L/gHDhO6HnnZtN.7aEOxiZyhuYchIMrvVL0lge', 0, 0, 'uploads/uaKsnKg.jpg'),
(82, 'oussamachour@hotmail.fr', 'oussama la dette', 'oussama', 'achour', '$2y$10$11neZkrR8DgmJuvOfkNyX.OmXJPa9tXAW8aO8YQQDcbIcscLVdnfG', 1, 0, 'cool-anime-pfp-02.jpg'),
(83, 'fey.akcay@gmail.com', 'nur34', 'Akcay2', 'Feyza', '$2y$10$qWlisPxrDa9ltW7DghHNR.GnZwsScszZvvL535sFfRlENqIo1tt1u', 1, 0, 'uploads/imagenotfind.png');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `participer`
--
ALTER TABLE `participer`
  ADD KEY `uid` (`uid`),
  ADD KEY `tid` (`tid`);

--
-- Index pour la table `rencontre`
--
ALTER TABLE `rencontre`
  ADD PRIMARY KEY (`rid`),
  ADD KEY `tid` (`tid`),
  ADD KEY `joueur1` (`joueur1`),
  ADD KEY `joueur2` (`joueur2`),
  ADD KEY `id_vainqueur` (`id_vainqueur`),
  ADD KEY `rid_suivant` (`rid_suivant`);

--
-- Index pour la table `sport`
--
ALTER TABLE `sport`
  ADD PRIMARY KEY (`sid`);

--
-- Index pour la table `statut`
--
ALTER TABLE `statut`
  ADD PRIMARY KEY (`id_statut`);

--
-- Index pour la table `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`id_token`),
  ADD UNIQUE KEY `1` (`cle`);

--
-- Index pour la table `tournoi`
--
ALTER TABLE `tournoi`
  ADD PRIMARY KEY (`tid`),
  ADD KEY `sid` (`sid`),
  ADD KEY `id_statut` (`id_statut`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `rencontre`
--
ALTER TABLE `rencontre`
  MODIFY `rid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT pour la table `sport`
--
ALTER TABLE `sport`
  MODIFY `sid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `statut`
--
ALTER TABLE `statut`
  MODIFY `id_statut` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `token`
--
ALTER TABLE `token`
  MODIFY `id_token` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `tournoi`
--
ALTER TABLE `tournoi`
  MODIFY `tid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `uid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `participer`
--
ALTER TABLE `participer`
  ADD CONSTRAINT `participer_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `utilisateur` (`uid`),
  ADD CONSTRAINT `participer_ibfk_2` FOREIGN KEY (`tid`) REFERENCES `tournoi` (`tid`);

--
-- Contraintes pour la table `rencontre`
--
ALTER TABLE `rencontre`
  ADD CONSTRAINT `rencontre_ibfk_1` FOREIGN KEY (`tid`) REFERENCES `tournoi` (`tid`),
  ADD CONSTRAINT `rencontre_ibfk_2` FOREIGN KEY (`joueur1`) REFERENCES `utilisateur` (`uid`),
  ADD CONSTRAINT `rencontre_ibfk_3` FOREIGN KEY (`joueur2`) REFERENCES `utilisateur` (`uid`),
  ADD CONSTRAINT `rencontre_ibfk_4` FOREIGN KEY (`id_vainqueur`) REFERENCES `utilisateur` (`uid`),
  ADD CONSTRAINT `rencontre_ibfk_5` FOREIGN KEY (`rid_suivant`) REFERENCES `rencontre` (`rid`);

--
-- Contraintes pour la table `tournoi`
--
ALTER TABLE `tournoi`
  ADD CONSTRAINT `tournoi_ibfk_1` FOREIGN KEY (`sid`) REFERENCES `sport` (`sid`),
  ADD CONSTRAINT `tournoi_ibfk_2` FOREIGN KEY (`id_statut`) REFERENCES `statut` (`id_statut`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
