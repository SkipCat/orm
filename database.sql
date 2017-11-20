-- phpMyAdmin SQL Dump
-- version 4.7.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le :  lun. 20 nov. 2017 à 23:00
-- Version du serveur :  5.6.35
-- Version de PHP :  7.0.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `orm_project`
--

-- --------------------------------------------------------

--
-- Structure de la table `film`
--

CREATE TABLE `film` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `producer` varchar(255) NOT NULL,
  `releaseDate` date NOT NULL,
  `duration` int(11) NOT NULL,
  `genre` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `film`
--

INSERT INTO `film` (`id`, `title`, `producer`, `releaseDate`, `duration`, `genre`) VALUES
(1, 'Gladiator', 'Ridley Scott', '2000-06-16', 148, 'peplum'),
(2, 'Inception', 'Christopher Nolan', '2010-07-16', 148, 'syfy/thriller'),
(3, 'Gladiator', 'Ridley Scott', '1998-06-23', 178, 'peplum');

-- --------------------------------------------------------

--
-- Structure de la table `showing`
--

CREATE TABLE `showing` (
  `id` int(11) NOT NULL,
  `filmId` int(11) NOT NULL,
  `showtime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `showing`
--

INSERT INTO `showing` (`id`, `filmId`, `showtime`) VALUES
(1, 2, '2017-11-30 17:57:00'),
(2, 2, '2017-11-30 19:30:00'),
(3, 1, '2017-12-25 16:45:00'),
(4, 1, '2017-12-25 20:50:00');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `film`
--
ALTER TABLE `film`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `showing`
--
ALTER TABLE `showing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `film_id` (`filmId`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `film`
--
ALTER TABLE `film`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT pour la table `showing`
--
ALTER TABLE `showing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `showing`
--
ALTER TABLE `showing`
  ADD CONSTRAINT `showing_ibfk_1` FOREIGN KEY (`filmId`) REFERENCES `film` (`id`);
