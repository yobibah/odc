-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 26 juin 2025 à 15:10
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `odc_`
--

-- --------------------------------------------------------

--
-- Structure de la table `hospitale`
--

DROP TABLE IF EXISTS `hospitale`;
CREATE TABLE IF NOT EXISTS `hospitale` (
  `id_hos` int NOT NULL,
  `nom` varchar(255) NOT NULL,
  `numero` varchar(14) NOT NULL,
  `longitute` varchar(255) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `ville` varchar(255) NOT NULL,
  `quartier` text NOT NULL,
  `rue` text NOT NULL,
  `id_serv` int NOT NULL,
  `lieux_proch` text NOT NULL,
  KEY `id_serv` (`id_serv`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 ;

--
-- Déchargement des données de la table `hospitale`
--

INSERT INTO `hospitale` (`id_hos`, `nom`, `numero`, `longitute`, `latitude`, `ville`, `quartier`, `rue`, `id_serv`, `lieux_proch`) VALUES
(1, 'CHU Yalgado Ouédraogo', '+22625311655', '-1.506458', '12.383561', 'Ouagadougou', 'Secteur 4', 'Avenue Capitaine Thomas Sankara', 1, 'Université'),
(2, 'CHU Tengadogo (Bogodogo)', '+22625311600', '-1.516000', '12.370000', 'Ouagadougou', 'Bogodogo', '', 1, 'District hospital'),
(3, 'Centre hospitalier nationale Blaise Compaoré', '+22625390000', '-1.530000', '12.362000', 'Ouagadougou', 'Centre-ville', '', 1, 'Hôpital national'),
(4, 'Centre Médical International (ex. French Clinic)', '+22650306607', '-1.526000', '12.364000', 'Ouagadougou', 'Centre-ville', 'Rue Nazi Boni', 2, 'Privée'),
(5, 'Clinique El Fateh‑Suka', '+22650430600', '-1.533000', '12.365000', 'Ouagadougou', 'Pissy', '', 2, 'Privée'),
(6, 'Clinique Les Genêts', '+22650374380', '-1.532000', '12.365500', 'Ouagadougou', '', '', 2, 'Privée'),
(7, 'Polyclinique Internationale', '+2262543528', '-1.532500', '12.365300', 'Ouagadougou', 'Ouaga 2000 Secteur 15', '', 2, 'Privée multiservice'),
(8, 'Polyclinique Notre Dame de la Paix', '+22625356153', '-1.534000', '12.366000', 'Ouagadougou', 'Somgandin Secteur 24', '', 2, 'Privée multiservice'),
(9, 'Clinique Philadelphie', '+22625332871', '-1.532200', '12.364800', 'Ouagadougou', 'Centre-ville', '404 Rue Maurice Yameogo', 2, 'Privée multiservice'),
(10, 'Clinique Les Flamboyants', '+22625307600', '-1.529000', '12.362500', 'Ouagadougou', 'Gounghin', '', 2, 'Privée multiservice'),
(11, 'Clinique La Lumière (ophtalmo)', '+22625335074', '-1.533500', '12.365200', 'Ouagadougou', '', '', 2, 'Spécialisée ophtalmo');

-- --------------------------------------------------------

--
-- Structure de la table `hospital_services`
--

DROP TABLE IF EXISTS `hospital_services`;
CREATE TABLE IF NOT EXISTS `hospital_services` (
  `id_hos` int DEFAULT NULL,
  `id_serv` int DEFAULT NULL,
  KEY `id_hos` (`id_hos`),
  KEY `id_serv` (`id_serv`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 ;

-- --------------------------------------------------------

--
-- Structure de la table `medicament`
--

DROP TABLE IF EXISTS `medicament`;
CREATE TABLE IF NOT EXISTS `medicament` (
  `id_medoc` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  `heur_prise` time NOT NULL,
  `users_id` int NOT NULL,
  PRIMARY KEY (`id_medoc`),
  KEY `users_id` (`users_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 ;

--
-- Déchargement des données de la table `medicament`
--

INSERT INTO `medicament` (`id_medoc`, `libelle`, `heur_prise`, `users_id`) VALUES
(2, 'Amoxicilline 1g', '13:00:00', 1),
(3, 'Paracétamol 500 mg', '08:00:00', 1);

-- --------------------------------------------------------

--
-- Structure de la table `rdv`
--

DROP TABLE IF EXISTS `rdv`;
CREATE TABLE IF NOT EXISTS `rdv` (
  `id_rdv` int NOT NULL AUTO_INCREMENT,
  `heure_rdv` time NOT NULL,
  `hopitale_rdv` varchar(255) NOT NULL,
  `date_rdv` date NOT NULL,
  `users_id` int NOT NULL,
  PRIMARY KEY (`id_rdv`),
  KEY `users_id` (`users_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ;

--
-- Déchargement des données de la table `rdv`
--

INSERT INTO `rdv` (`id_rdv`, `heure_rdv`, `hopitale_rdv`, `date_rdv`, `users_id`) VALUES
(1, '07:00:00', 'Centre Médical Ouaga 2000', '2025-06-19', 1);

-- --------------------------------------------------------

--
-- Structure de la table `service`
--

DROP TABLE IF EXISTS `service`;
CREATE TABLE IF NOT EXISTS `service` (
  `id_serv` int NOT NULL AUTO_INCREMENT,
  `libelle_serv` varchar(255) NOT NULL,
  PRIMARY KEY (`id_serv`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 ;

--
-- Déchargement des données de la table `service`
--

INSERT INTO `service` (`id_serv`, `libelle_serv`) VALUES
(1, 'Médecine générale'),
(2, 'Chirurgie générale'),
(3, 'Gynécologie / Obstétrique'),
(4, 'Pédiatrie'),
(5, 'Cardiologie'),
(6, 'Ophtalmologie'),
(7, 'Radiologie / Imagerie médicale'),
(8, 'Urgences médicales'),
(9, 'Urgences chirurgicales'),
(10, 'Laboratoire / Analyses médicales'),
(11, 'Pharmacie'),
(12, 'Néphrologie / Dialyse'),
(13, 'Orthopédie / Traumatologie'),
(14, 'Néonatalogie'),
(15, 'Maternité'),
(16, 'Dentisterie'),
(17, 'Psychiatrie'),
(18, 'ORL'),
(19, 'Anesthésie / Réanimation'),
(20, 'Hygiène hospitalière / Stérilisation');

-- --------------------------------------------------------

--
-- Structure de la table `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `id_serv` int NOT NULL AUTO_INCREMENT,
  `nom_serv` varchar(255) NOT NULL,
  PRIMARY KEY (`id_serv`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 ;

--
-- Déchargement des données de la table `services`
--

INSERT INTO `services` (`id_serv`, `nom_serv`) VALUES
(1, 'Médecine générale'),
(2, 'Chirurgie générale'),
(3, 'Gynécologie / Obstétrique'),
(4, 'Pédiatrie'),
(5, 'Cardiologie'),
(6, 'Ophtalmologie'),
(7, 'Radiologie / Imagerie médicale'),
(8, 'Urgences médicales'),
(9, 'Urgences chirurgicales'),
(10, 'Laboratoire / Analyses médicales'),
(11, 'Pharmacie'),
(12, 'Néphrologie / Dialyse'),
(13, 'Orthopédie / Traumatologie'),
(14, 'Néonatalogie'),
(15, 'Maternité'),
(16, 'Dentisterie'),
(17, 'Psychiatrie'),
(18, 'ORL'),
(19, 'Anesthésie / Réanimation'),
(20, 'Hygiène hospitalière / Stérilisation');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `users_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `telephone` varchar(25) NOT NULL,
  `num_pav` varchar(25) NOT NULL,
  `auth_token` varchar(255) NOT NULL,
  PRIMARY KEY (`users_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 ;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`users_id`, `username`, `mdp`, `telephone`, `num_pav`, `auth_token`) VALUES
(1, 'utilisateur12', 'pass1234', '70112233', '78980987', ''),
(2, 'utilisateurs34', '12341234', '54805050', '76890054', 'ab6f4ccc08adda52967cd88ad1794905e31751e147ce9279c26f5fc0b4d60c0f');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
