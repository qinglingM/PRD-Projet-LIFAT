-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Apr 11, 2020 at 01:08 AM
-- Server version: 5.7.26
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projetlifat1`
--

-- --------------------------------------------------------

--
-- Table structure for table `budgets_annuels`
--

CREATE TABLE `budgets_annuels` (
  `projet_id` int(11) NOT NULL,
  `annee` int(11) NOT NULL,
  `budget` int(9) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `budgets_annuels`
--

INSERT INTO `budgets_annuels` (`projet_id`, `annee`, `budget`) VALUES
(1, 2016, 10000),
(1, 2017, 15000),
(1, 2018, 20000),
(1, 2019, 25000),
(2, 2017, 40000),
(2, 2018, 50000),
(2, 2019, 60000),
(3, 2017, 15000),
(3, 2018, 20000),
(3, 2019, 25000),
(4, 2016, 10000),
(4, 2017, 15000),
(4, 2018, 20000),
(4, 2019, 25000);

-- --------------------------------------------------------

--
-- Table structure for table `dirigeants`
--

CREATE TABLE `dirigeants` (
  `dirigeant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dirigeants`
--

INSERT INTO `dirigeants` (`dirigeant_id`) VALUES
(6),
(21),
(22),
(23);

-- --------------------------------------------------------

--
-- Table structure for table `dirigeants_theses`
--

CREATE TABLE `dirigeants_theses` (
  `dirigeant_id` int(11) NOT NULL,
  `these_id` int(11) NOT NULL,
  `taux` int(3) DEFAULT '100'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dirigeants_theses`
--

INSERT INTO `dirigeants_theses` (`dirigeant_id`, `these_id`, `taux`) VALUES
(6, 1, 27),
(6, 3, 100),
(6, 6, 55);

-- --------------------------------------------------------

--
-- Table structure for table `encadrants`
--

CREATE TABLE `encadrants` (
  `encadrant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `encadrants`
--

INSERT INTO `encadrants` (`encadrant_id`) VALUES
(3),
(4),
(6),
(21),
(22),
(23);

-- --------------------------------------------------------

--
-- Table structure for table `encadrants_theses`
--

CREATE TABLE `encadrants_theses` (
  `encadrant_id` int(11) NOT NULL,
  `these_id` int(11) NOT NULL,
  `taux` int(3) DEFAULT '100'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `encadrants_theses`
--

INSERT INTO `encadrants_theses` (`encadrant_id`, `these_id`, `taux`) VALUES
(3, 1, 54),
(3, 2, 22),
(3, 3, 100),
(4, 1, 46),
(4, 2, 47),
(4, 4, 100),
(4, 5, 25),
(6, 2, 31),
(6, 5, 75),
(6, 6, 100);

-- --------------------------------------------------------

--
-- Table structure for table `equipes`
--

CREATE TABLE `equipes` (
  `id` int(11) NOT NULL,
  `nom_equipe` varchar(25) NOT NULL,
  `responsable_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `equipes`
--

INSERT INTO `equipes` (`id`, `nom_equipe`, `responsable_id`) VALUES
(1, 'equipe1', 2),
(2, 'equipe2', 8),
(3, 'equipe3', 21),
(4, 'equipe4', 16),
(6, 'equipe6', 18),
(7, 'equipe7', 19);

-- --------------------------------------------------------

--
-- Table structure for table `equipes_projets`
--

CREATE TABLE `equipes_projets` (
  `equipe_id` int(11) NOT NULL,
  `projet_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `equipes_projets`
--

INSERT INTO `equipes_projets` (`equipe_id`, `projet_id`) VALUES
(1, 2),
(2, 1),
(3, 2),
(4, 3),
(6, 4),
(7, 3);

-- --------------------------------------------------------

--
-- Table structure for table `equipes_responsables`
--

CREATE TABLE `equipes_responsables` (
  `equipe_id` int(11) NOT NULL,
  `responsable_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `equipes_responsables`
--

INSERT INTO `equipes_responsables` (`equipe_id`, `responsable_id`) VALUES
(1, 2),
(2, 3),
(3, 11),
(4, 2),
(6, 11),
(7, 2);

-- --------------------------------------------------------

--
-- Table structure for table `fichiers`
--

CREATE TABLE `fichiers` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `titre` varchar(100) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `date_upload` datetime DEFAULT CURRENT_TIMESTAMP,
  `membre_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fichiers`
--

INSERT INTO `fichiers` (`id`, `nom`, `titre`, `description`, `date_upload`, `membre_id`) VALUES
(1, 'Analyse de données.pdf', '', '', '2020-02-10 01:36:11', 1);

-- --------------------------------------------------------

--
-- Table structure for table `financements`
--

CREATE TABLE `financements` (
  `id` int(11) NOT NULL,
  `international` tinyint(1) DEFAULT NULL,
  `nationalite_financement` varchar(60) DEFAULT NULL,
  `financement_prive` tinyint(1) DEFAULT NULL,
  `financement` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `financements`
--

INSERT INTO `financements` (`id`, `international`, `nationalite_financement`, `financement_prive`, `financement`) VALUES
(1, 0, 'Français', 0, '50000 euros'),
(2, 1, 'Allemand', 1, '250000 euros'),
(3, 1, 'Espagnol', 1, '275000 euros'),
(4, 0, 'Français', 0, '120000 euros');

-- --------------------------------------------------------

--
-- Table structure for table `lieus`
--

CREATE TABLE `lieus` (
  `id` int(11) NOT NULL,
  `nom_lieu` varchar(60) DEFAULT NULL,
  `est_dans_liste` tinyint(1) DEFAULT NULL,
  `pays` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lieus`
--

INSERT INTO `lieus` (`id`, `nom_lieu`, `est_dans_liste`, `pays`) VALUES
(1, 'Tours', 1, 'France'),
(2, 'Paris', 1, 'France'),
(3, 'Angers', 1, 'France'),
(4, 'Rennes', 1, 'France'),
(5, 'Lille', 1, 'France'),
(6, 'Orleans', 1, 'France'),
(7, 'Bordeaux', 1, 'France'),
(8, 'Londres', 1, 'Royaume-Uni'),
(9, 'Berlin', 1, 'Allemagne'),
(10, 'Barcelone', 1, 'Espagne');

-- --------------------------------------------------------

--
-- Table structure for table `lieu_travails`
--

CREATE TABLE `lieu_travails` (
  `id` int(11) NOT NULL,
  `nom_lieu` varchar(60) NOT NULL,
  `est_dans_liste` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lieu_travails`
--

INSERT INTO `lieu_travails` (`id`, `nom_lieu`, `est_dans_liste`) VALUES
(1, 'Polytech Tours', 1),
(2, 'LIFAT Paris', 1),
(3, 'LIFAT Blois', 1),
(5, 'LIFAT Lille', 1),
(6, 'LIFAT Angers', 1);

-- --------------------------------------------------------

--
-- Table structure for table `membres`
--

CREATE TABLE `membres` (
  `id` int(11) NOT NULL,
  `role` enum('admin','membre','secretaire','chef_equipe') NOT NULL DEFAULT 'membre',
  `nom` varchar(25) DEFAULT NULL,
  `prenom` varchar(25) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `passwd` varchar(100) DEFAULT NULL,
  `adresse_agent_1` varchar(80) DEFAULT NULL,
  `adresse_agent_2` varchar(60) DEFAULT NULL,
  `residence_admin_1` varchar(80) DEFAULT NULL,
  `residence_admin_2` varchar(80) DEFAULT NULL,
  `type_personnel` enum('PU','PE','Do') DEFAULT NULL COMMENT 'Personnel de lUniversité | Personnel Exterieur | Doctorant',
  `intitule` varchar(30) DEFAULT NULL,
  `grade` varchar(30) DEFAULT NULL,
  `im_vehicule` varchar(10) DEFAULT NULL COMMENT 'immatriculation du véhicule principal',
  `pf_vehicule` int(11) DEFAULT NULL COMMENT 'puissance ficale du véhicule principal',
  `signature_name` varchar(255) DEFAULT NULL,
  `login_cas` varchar(60) DEFAULT NULL,
  `carte_sncf` varchar(40) DEFAULT NULL,
  `matricule` int(11) DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `actif` tinyint(1) DEFAULT '1',
  `lieu_travail_id` int(11) DEFAULT NULL,
  `equipe_id` int(11) DEFAULT NULL,
  `nationalite` varchar(20) DEFAULT NULL,
  `est_francais` tinyint(1) DEFAULT '1',
  `genre` char(1) DEFAULT NULL,
  `hdr` int(1) DEFAULT NULL COMMENT 'Certification HDR',
  `permanent` int(1) DEFAULT NULL,
  `est_porteur` int(1) DEFAULT '0',
  `date_creation` datetime DEFAULT NULL,
  `date_sortie` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `membres`
--

INSERT INTO `membres` (`id`, `role`, `nom`, `prenom`, `email`, `passwd`, `adresse_agent_1`, `adresse_agent_2`, `residence_admin_1`, `residence_admin_2`, `type_personnel`, `intitule`, `grade`, `im_vehicule`, `pf_vehicule`, `signature_name`, `login_cas`, `carte_sncf`, `matricule`, `date_naissance`, `actif`, `lieu_travail_id`, `equipe_id`, `nationalite`, `est_francais`, `genre`, `hdr`, `permanent`, `est_porteur`, `date_creation`, `date_sortie`) VALUES
(1, 'admin', 'Admin', 'Admin', 'admin@admin.fr', '$2y$10$PdhHrp/D.d.zH1g3R/h33efyoLlBXM0vWzMglZ.M/I0BySAD3TMUq', '', '', '', '', 'PU', '', '', 'A99', 99, 'signatu.jpg', '', '', NULL, '2019-02-11', 1, 2, 1, '', 1, 'F', 0, 1, 0, '2020-02-12 11:14:46', NULL),
(2, 'chef_equipe', 'nomUser2', 'prenomUser2', 'qingling.meng@etu.univ-tours.fr', '$2y$10$uby0RHIbA4iwiw4S17khMuRD8XTLLGskXZhR/ZT6CUmR8g97Vxbke', 'adresse2', '', 'residence2', '', 'Do', 'intitule2', 'Chef d equipe', 'imatricula', 2, 'lifat.jpg', 'qingling', 'carteSncf2', 101010102, '1997-06-07', 1, 1, 1, 'Français', 1, 'H', 0, 1, 1, '2020-03-07 14:03:00', NULL),
(3, 'membre', 'nomUser2', 'prenomUser3', 'mql951002@gmail.com', '$2y$10$PksbXyiUFxHocqxYr4HmlOJfGGOJqfeWmYwieXQroCL3ChQQr1zEC', 'adress3', '', 'residence3', '', 'PU', 'intitule3', 'Chef d equipe', 'imatricula', 3, '$2y$10$BJtRl3rtGifpFT6rNegn1exCNXM9ba1Ga2rEEfA15e2iaxaOMguIm.jpeg', '', 'carteSncf3', 101010103, '1990-10-20', 1, 2, 2, 'Français', 1, 'H', 0, 1, 0, '2020-02-11 19:57:28', NULL),
(4, 'membre', 'nomUser3', 'prenomUser4', '1339733455@qq.com', '$2y$10$RgCUyp4.Cmv0s0QK5TDpIOcogPJFKLsit80q/IyWML/NFbf/L7jNu', 'adresse4', '', 'residence4', '', 'PU', 'intitule4', 'Chercheur', 'imatricula', 4, 'signatu.jpg', '', 'carteSncf4', 101010104, '1999-12-25', 1, 1, 1, 'Allemand', 0, 'H', NULL, 1, 1, '2020-03-30 23:24:46', NULL),
(5, '', 'nomUser4', 'prenomUser5', 'user5@email.fr', '$2y$10$PksbXyiUFxHocqxYr4HmlOJfGGOJqfeWmYwieXQroCL3ChQQr1zEC', 'adresse5', NULL, 'residence5', NULL, 'PE', 'intitule5', 'Chercheur', 'imatricula', 5, '', NULL, NULL, 101010105, '1987-02-01', 1, 1, 1, 'Americain', 0, 'h', NULL, 1, 0, '2019-05-01 16:15:00', NULL),
(6, '', 'nomUser6', 'prenomUser6', 'user6@email.fr', '$2y$10$PksbXyiUFxHocqxYr4HmlOJfGGOJqfeWmYwieXQroCL3ChQQr1zEC', 'adresse6', NULL, 'residence6', NULL, 'PU', 'intitule6', 'Chercheur', 'imatricula', 6, '', NULL, 'carteSncf6', 101010106, '1986-02-24', 1, 2, 2, 'Allemand', 0, 'f', NULL, 1, 0, '2019-05-01 16:15:00', NULL),
(8, '', 'nomUser8', 'prenomUser8', 'user8@email.fr', '$2y$10$PksbXyiUFxHocqxYr4HmlOJfGGOJqfeWmYwieXQroCL3ChQQr1zEC', 'adresse8', NULL, 'residence8', NULL, 'PE', 'intitule8', 'Chercheur', 'imatricula', 8, '', NULL, NULL, 101010108, '1979-03-18', 1, 2, 2, 'Français', 1, 'h', NULL, 1, 0, '2019-05-01 16:15:00', NULL),
(9, '', 'nomUser9', 'prenomUser9', 'user9@email.fr', '$2y$10$PksbXyiUFxHocqxYr4HmlOJfGGOJqfeWmYwieXQroCL3ChQQr1zEC', 'adresse9', NULL, 'residence9', NULL, 'Do', 'intitule9', 'Chercheur', 'imatricula', 9, '', NULL, 'carteSncf9', 101010109, '1992-07-06', 1, 1, 3, 'Français', 1, 'f', NULL, 0, 0, '2019-05-01 16:15:00', NULL),
(11, '', 'nomUser11', 'prenomUser11', 'user11@email.fr', '$2y$10$PksbXyiUFxHocqxYr4HmlOJfGGOJqfeWmYwieXQroCL3ChQQr1zEC', 'adresse11', NULL, 'residence11', NULL, 'PU', 'intitule11', 'Chercheur', 'imatricula', 11, '', NULL, 'carteSncf11', 101010111, '1993-05-21', 1, 2, 2, 'Français', 1, 'f', NULL, 1, 0, '2019-05-01 16:15:00', NULL),
(12, '', 'nomUser12', 'prenomUser12', 'user12@email.fr', '$2y$10$PksbXyiUFxHocqxYr4HmlOJfGGOJqfeWmYwieXQroCL3ChQQr1zEC', 'adresse12', NULL, 'residence12', NULL, 'Do', 'intitule12', 'Chercheur', 'imatricula', 12, '', NULL, 'carteSncf12', 101010112, '1994-04-16', 1, 1, 1, 'Français', 1, 'h', NULL, 0, 0, '2019-05-01 16:15:00', NULL),
(13, '', 'nomUser13', 'prenomUser13', 'user13@email.fr', '$2y$10$PksbXyiUFxHocqxYr4HmlOJfGGOJqfeWmYwieXQroCL3ChQQr1zEC', 'adresse13', NULL, 'residence13', NULL, 'Do', 'intitule13', 'Chercheur', 'imatricula', 13, '', NULL, 'carteSncf13', 101010113, '1993-07-09', 1, 1, 3, 'Espagnol', 0, 'f', NULL, 1, 0, '2019-05-01 16:15:00', NULL),
(14, '', 'nomUser14', 'prenomUser14', 'user14@email.fr', '$2y$10$PksbXyiUFxHocqxYr4HmlOJfGGOJqfeWmYwieXQroCL3ChQQr1zEC', 'adresse14', NULL, 'residence14', NULL, 'Do', 'intitule14', 'Chercheur', 'imatricula', 14, '', NULL, 'carteSncf14', 101010114, '1995-11-27', 1, 2, 2, 'Français', 1, 'h', NULL, 1, 0, '2019-05-01 16:15:00', NULL),
(15, '', 'nomUser15', 'prenomUser15', 'user15@email.fr', '$2y$10$PksbXyiUFxHocqxYr4HmlOJfGGOJqfeWmYwieXQroCL3ChQQr1zEC', 'adresse15', NULL, 'residence15', NULL, 'Do', 'intitule15', 'Chercheur', 'imatricula', 15, '', NULL, 'carteSncf15', 101010115, '1994-06-13', 1, 1, 3, 'Anglais', 0, 'f', NULL, 0, 0, '2019-05-01 16:15:00', NULL),
(16, '', 'nomUser16', 'prenomUser16', 'user16@email.fr', '$2y$10$PksbXyiUFxHocqxYr4HmlOJfGGOJqfeWmYwieXQroCL3ChQQr1zEC', 'adresse16', NULL, 'residence16', NULL, 'PU', 'intitule16', 'Chef d equipe', 'imatricula', 16, '', NULL, 'carteSncf16', 101010116, '1993-05-21', 1, 3, 4, 'Français', 1, 'h', NULL, 1, 0, '2019-05-01 16:15:00', NULL),
(17, 'secretaire', 'nomUser17', 'prenomUser17', 'user17@email.fr', '$2y$10$PksbXyiUFxHocqxYr4HmlOJfGGOJqfeWmYwieXQroCL3ChQQr1zEC', 'adresse17', NULL, 'residence17', NULL, 'PU', 'intitule17', 'Chef d equipe', 'imatricula', 17, '', NULL, 'carteSncf17', 101010117, '1994-04-16', 1, 2, NULL, 'Français', 1, 'f', NULL, 0, 0, '2019-05-01 16:15:00', NULL),
(18, '', 'nomUser18', 'prenomUser18', 'user18@email.fr', '$2y$10$PksbXyiUFxHocqxYr4HmlOJfGGOJqfeWmYwieXQroCL3ChQQr1zEC', 'adresse18', NULL, 'residence18', NULL, 'PU', 'intitule18', 'Chef d equipe', 'imatricula', 18, '', NULL, 'carteSncf18', 101010118, '1993-07-09', 1, 3, 6, 'Espagnol', 0, 'h', NULL, 1, 0, '2019-05-01 16:15:00', NULL),
(19, '', 'nomUser19', 'prenomUser19', 'user19@email.fr', '$2y$10$PksbXyiUFxHocqxYr4HmlOJfGGOJqfeWmYwieXQroCL3ChQQr1zEC', 'adresse19', NULL, 'residence19', NULL, 'PU', 'intitule19', 'Chef d equipe', 'imatricula', 19, '', NULL, 'carteSncf19', 101010119, '1995-11-27', 1, 3, 7, 'Français', 1, 'f', NULL, 1, 0, '2019-05-01 16:15:00', NULL),
(20, '', 'nomUser20', 'prenomUser20', 'user20@email.fr', '$2y$10$PksbXyiUFxHocqxYr4HmlOJfGGOJqfeWmYwieXQroCL3ChQQr1zEC', 'adresse20', NULL, 'residence20', NULL, 'PU', 'intitule20', 'Chercheur', 'imatricula', 20, '', NULL, 'carteSncf20', 101010120, '1994-06-13', 1, 3, 7, 'Anglais', 0, 'h', NULL, 0, 0, '2019-05-01 16:15:00', NULL),
(21, 'admin', 'chef3', 'chef3', '907286845@qq.com', '$2y$10$qlgixtuYqIVmvFhZV4e58e9tPcWdh0sI40Gk7C64frxk4klkEWZ1.', '', '', '', '', 'PU', '', '', '', NULL, '屏幕快照 2020-02-04 下午1.22.39.png', '', '', NULL, '2019-02-02', 1, 6, 3, '', 1, 'H', 0, 1, 0, '2020-02-12 09:43:28', NULL),
(22, 'membre', '', '', 'user33@user.fr', '$2y$10$uXHXP1.9A9UcU4Kv59KVv.CAO4vZExG2ddtCRVc1.z.5BcXP5XtbO', '', '', '', '', 'PU', '', '', '', NULL, NULL, '', '', NULL, '2016-04-04', 1, 6, NULL, '', 1, 'H', 0, 1, 0, '2020-03-25 12:29:48', NULL),
(23, 'secretaire', '', '', '18813104014@163.com', '$2y$10$U5R6bSEu1KeRpv80Mz0L/.OcmOo4JkYAVGaS0djnAtAc/gzYQSpvi', '', '', '', '', 'PU', '', '', '', NULL, NULL, '', '', NULL, '2019-02-07', 1, 6, NULL, '', 1, 'H', 0, 1, 0, '2020-02-07 17:10:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `missions`
--

CREATE TABLE `missions` (
  `id` int(11) NOT NULL,
  `complement_motif` varchar(40) DEFAULT NULL,
  `date_depart` datetime DEFAULT NULL,
  `date_depart_arrive` datetime DEFAULT NULL,
  `date_retour` datetime DEFAULT NULL,
  `date_retour_arrive` datetime DEFAULT NULL,
  `sans_frais` tinyint(1) DEFAULT NULL,
  `etat` enum('soumis','valide') DEFAULT NULL,
  `nb_nuites` int(11) DEFAULT NULL,
  `nb_repas` int(11) DEFAULT NULL,
  `billet_agence` tinyint(1) DEFAULT NULL,
  `commentaire_transport` text,
  `projet_id` int(11) DEFAULT NULL,
  `lieu_id` int(11) DEFAULT NULL,
  `motif_id` int(11) DEFAULT NULL,
  `responsable_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `missions`
--

INSERT INTO `missions` (`id`, `complement_motif`, `date_depart`, `date_depart_arrive`, `date_retour`, `date_retour_arrive`, `sans_frais`, `etat`, `nb_nuites`, `nb_repas`, `billet_agence`, `commentaire_transport`, `projet_id`, `lieu_id`, `motif_id`, `responsable_id`) VALUES
(1, '', '2021-03-03 02:04:00', '2021-05-02 02:03:00', '2022-04-01 02:01:00', '2022-04-03 01:02:00', 1, 'valide', 393, 788, 1, '', 2, 4, 1, 4),
(2, NULL, '2021-03-03 02:04:00', NULL, '2022-04-01 02:01:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, 1, 3),
(6, 'complement motif', '2020-06-01 02:01:00', '2020-06-01 04:01:00', '2020-06-07 05:01:00', '2020-06-07 11:01:00', 1, 'valide', 6, 12, 1, 'commentaire transport', 1, 5, 3, 4),
(7, NULL, '2020-06-01 02:01:00', NULL, '2020-06-07 05:01:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, 3, 3),
(8, NULL, '2020-06-01 02:01:00', NULL, '2020-06-07 05:01:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, 3, 9);

-- --------------------------------------------------------

--
-- Table structure for table `motifs`
--

CREATE TABLE `motifs` (
  `id` int(11) NOT NULL,
  `nom_motif` varchar(60) DEFAULT NULL,
  `est_dans_liste` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `motifs`
--

INSERT INTO `motifs` (`id`, `nom_motif`, `est_dans_liste`) VALUES
(1, 'motif10', 1),
(2, 'motif2', 1),
(3, 'motif3', 1),
(4, 'motif4', 1),
(5, 'motif5', 1),
(6, 'motif6', 1),
(7, 'motif7', 1),
(8, 'motif8', 1);

-- --------------------------------------------------------

--
-- Table structure for table `projets`
--

CREATE TABLE `projets` (
  `id` int(11) NOT NULL,
  `titre` varchar(20) DEFAULT NULL,
  `description` varchar(80) DEFAULT NULL,
  `type` enum('type1','type2','type3','type4') DEFAULT NULL,
  `budget` int(11) DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `financement_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `projets`
--

INSERT INTO `projets` (`id`, `titre`, `description`, `type`, `budget`, `date_debut`, `date_fin`, `financement_id`) VALUES
(1, 'projet1', 'descriptionProjet1', 'type1', 100000, '2016-04-01', '2021-10-16', 1),
(2, 'projet2', 'descriptionProjet2', 'type3', 300000, '2017-11-03', '2022-10-16', 2),
(3, 'projet3', 'descriptionProjet3', 'type2', 400000, '2017-07-12', '2023-11-21', 3),
(4, 'projet4', 'descriptionProjet4', 'type4', 200000, '2016-05-27', '2022-10-16', 4);

-- --------------------------------------------------------

--
-- Table structure for table `theses`
--

CREATE TABLE `theses` (
  `id` int(11) NOT NULL,
  `sujet` varchar(160) NOT NULL,
  `type` varchar(80) DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `autre_info` varchar(160) DEFAULT NULL,
  `est_hdr` tinyint(1) DEFAULT '0',
  `financement_id` int(11) DEFAULT NULL,
  `auteur_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `theses`
--

INSERT INTO `theses` (`id`, `sujet`, `type`, `date_debut`, `date_fin`, `autre_info`, `est_hdr`, `financement_id`, `auteur_id`) VALUES
(1, 'these1', 'Informatique Robotique', '2019-05-01', '2021-01-23', 'autreInfo1', 0, NULL, 9),
(2, 'these2', 'Taitement d image avance', '2017-02-24', '2018-07-23', 'autreInfo2', 1, 1, 2),
(3, 'these3', 'MicroElectronique avance', '2019-03-24', '2019-11-23', 'autreInfo3', 0, 2, 12),
(4, 'these4', 'Resolution de transfert important de donnees', '2019-06-27', '2020-03-29', 'autreInfo4', 1, 3, 2),
(5, 'these5', 'Medecine et Informatique', '2019-02-24', '2019-09-07', 'autreInfo5', 0, 4, 14),
(6, 'these6', 'Informatique au service de la planete', '2020-06-24', '2021-01-19', 'autreInfo6', 0, NULL, 15);

-- --------------------------------------------------------

--
-- Table structure for table `transports`
--

CREATE TABLE `transports` (
  `id` int(11) NOT NULL,
  `type_transport` enum('train','avion','vehicule_personnel','vehicule_service','autre') DEFAULT NULL,
  `im_vehicule` varchar(10) DEFAULT NULL COMMENT 'immatriculation du véhicule utilisé pour cette mission',
  `pf_vehicule` int(11) DEFAULT NULL COMMENT 'Puissance fiscale du véhicule principal',
  `mission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transports`
--

INSERT INTO `transports` (`id`, `type_transport`, `im_vehicule`, `pf_vehicule`, `mission_id`) VALUES
(1, 'train', NULL, NULL, 1),
(2, 'avion', NULL, NULL, 1),
(6, 'avion', NULL, NULL, 6),
(7, 'vehicule_personnel', '11', 11, 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `budgets_annuels`
--
ALTER TABLE `budgets_annuels`
  ADD PRIMARY KEY (`projet_id`,`annee`),
  ADD KEY `projet_id` (`projet_id`);

--
-- Indexes for table `dirigeants`
--
ALTER TABLE `dirigeants`
  ADD KEY `dirigeant_id` (`dirigeant_id`);

--
-- Indexes for table `dirigeants_theses`
--
ALTER TABLE `dirigeants_theses`
  ADD PRIMARY KEY (`dirigeant_id`,`these_id`),
  ADD KEY `these_key` (`these_id`);

--
-- Indexes for table `encadrants`
--
ALTER TABLE `encadrants`
  ADD KEY `encadrant_id` (`encadrant_id`);

--
-- Indexes for table `encadrants_theses`
--
ALTER TABLE `encadrants_theses`
  ADD PRIMARY KEY (`encadrant_id`,`these_id`),
  ADD KEY `encadrant_id` (`encadrant_id`),
  ADD KEY `these_id` (`these_id`);

--
-- Indexes for table `equipes`
--
ALTER TABLE `equipes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom_equipe` (`nom_equipe`),
  ADD KEY `responsable_id` (`responsable_id`);

--
-- Indexes for table `equipes_projets`
--
ALTER TABLE `equipes_projets`
  ADD PRIMARY KEY (`equipe_id`,`projet_id`),
  ADD KEY `equipe_id` (`equipe_id`),
  ADD KEY `projet_id` (`projet_id`);

--
-- Indexes for table `equipes_responsables`
--
ALTER TABLE `equipes_responsables`
  ADD PRIMARY KEY (`equipe_id`,`responsable_id`),
  ADD KEY `equipe_id` (`equipe_id`),
  ADD KEY `responsable_id` (`responsable_id`);

--
-- Indexes for table `fichiers`
--
ALTER TABLE `fichiers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom` (`nom`),
  ADD KEY `membre_id` (`membre_id`);

--
-- Indexes for table `financements`
--
ALTER TABLE `financements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lieus`
--
ALTER TABLE `lieus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lieu_travails`
--
ALTER TABLE `lieu_travails`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom_lieu` (`nom_lieu`);

--
-- Indexes for table `membres`
--
ALTER TABLE `membres`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `lieu_travail_id` (`lieu_travail_id`),
  ADD KEY `equipe_id` (`equipe_id`);

--
-- Indexes for table `missions`
--
ALTER TABLE `missions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projet_id` (`projet_id`),
  ADD KEY `lieu_id` (`lieu_id`),
  ADD KEY `motif_id` (`motif_id`),
  ADD KEY `responsable_id` (`responsable_id`);

--
-- Indexes for table `motifs`
--
ALTER TABLE `motifs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projets`
--
ALTER TABLE `projets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `financement_id` (`financement_id`);

--
-- Indexes for table `theses`
--
ALTER TABLE `theses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `financement_id` (`financement_id`),
  ADD KEY `auteur_id` (`auteur_id`);

--
-- Indexes for table `transports`
--
ALTER TABLE `transports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `keyy1` (`mission_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `equipes`
--
ALTER TABLE `equipes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `fichiers`
--
ALTER TABLE `fichiers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `financements`
--
ALTER TABLE `financements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `lieus`
--
ALTER TABLE `lieus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `lieu_travails`
--
ALTER TABLE `lieu_travails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `membres`
--
ALTER TABLE `membres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `missions`
--
ALTER TABLE `missions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `motifs`
--
ALTER TABLE `motifs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `projets`
--
ALTER TABLE `projets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `theses`
--
ALTER TABLE `theses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transports`
--
ALTER TABLE `transports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `budgets_annuels`
--
ALTER TABLE `budgets_annuels`
  ADD CONSTRAINT `fk_budgets_annuels_1` FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dirigeants`
--
ALTER TABLE `dirigeants`
  ADD CONSTRAINT `fk_dirigeants_1` FOREIGN KEY (`dirigeant_id`) REFERENCES `membres` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dirigeants_theses`
--
ALTER TABLE `dirigeants_theses`
  ADD CONSTRAINT `dirigeant_key` FOREIGN KEY (`dirigeant_id`) REFERENCES `dirigeants` (`dirigeant_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `these_key` FOREIGN KEY (`these_id`) REFERENCES `theses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `encadrants`
--
ALTER TABLE `encadrants`
  ADD CONSTRAINT `fk_encadrants_1` FOREIGN KEY (`encadrant_id`) REFERENCES `membres` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `encadrants_theses`
--
ALTER TABLE `encadrants_theses`
  ADD CONSTRAINT `fk_encadrants_theses_1` FOREIGN KEY (`encadrant_id`) REFERENCES `encadrants` (`encadrant_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_encadrants_theses_2` FOREIGN KEY (`these_id`) REFERENCES `theses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `equipes`
--
ALTER TABLE `equipes`
  ADD CONSTRAINT `fk_equipes_1` FOREIGN KEY (`responsable_id`) REFERENCES `membres` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `equipes_projets`
--
ALTER TABLE `equipes_projets`
  ADD CONSTRAINT `fk_equipes_projets_1` FOREIGN KEY (`equipe_id`) REFERENCES `equipes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_equipes_projets_2` FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `equipes_responsables`
--
ALTER TABLE `equipes_responsables`
  ADD CONSTRAINT `fk_equipes_responsables_1` FOREIGN KEY (`responsable_id`) REFERENCES `membres` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_equipes_responsables_2` FOREIGN KEY (`equipe_id`) REFERENCES `equipes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fichiers`
--
ALTER TABLE `fichiers`
  ADD CONSTRAINT `fk_fichiers_1` FOREIGN KEY (`membre_id`) REFERENCES `membres` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `membres`
--
ALTER TABLE `membres`
  ADD CONSTRAINT `fk_membre_1` FOREIGN KEY (`lieu_travail_id`) REFERENCES `lieu_travails` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_membre_2` FOREIGN KEY (`equipe_id`) REFERENCES `equipes` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `missions`
--
ALTER TABLE `missions`
  ADD CONSTRAINT `missions_ibfk_1` FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `missions_ibfk_2` FOREIGN KEY (`lieu_id`) REFERENCES `lieus` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `missions_ibfk_3` FOREIGN KEY (`motif_id`) REFERENCES `motifs` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `missions_ibfk_4` FOREIGN KEY (`responsable_id`) REFERENCES `membres` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `projets`
--
ALTER TABLE `projets`
  ADD CONSTRAINT `projets_ibfk_1` FOREIGN KEY (`financement_id`) REFERENCES `financements` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `theses`
--
ALTER TABLE `theses`
  ADD CONSTRAINT `fk_theses_1` FOREIGN KEY (`auteur_id`) REFERENCES `membres` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_theses_2` FOREIGN KEY (`financement_id`) REFERENCES `financements` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `transports`
--
ALTER TABLE `transports`
  ADD CONSTRAINT `keyy1` FOREIGN KEY (`mission_id`) REFERENCES `missions` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
