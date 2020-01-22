-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mer. 22 mai 2019 à 14:08
-- Version du serveur :  10.1.38-MariaDB
-- Version de PHP :  7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `lifat_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `budgets_annuels`
--

CREATE TABLE `budgets_annuels` (
  `projet_id` int(11) NOT NULL,
  `annee` int(11) NOT NULL,
  `budget` int(9) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `dirigeants`
--

CREATE TABLE `dirigeants` (
  `dirigeant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `dirigeants_theses`
--

CREATE TABLE `dirigeants_theses` (
  `dirigeant_id` int(11) NOT NULL,
  `these_id` int(11) NOT NULL,
  `taux` int(3) DEFAULT '100'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `encadrants`
--

CREATE TABLE `encadrants` (
  `encadrant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `encadrants_theses`
--

CREATE TABLE `encadrants_theses` (
  `encadrant_id` int(11) NOT NULL,
  `these_id` int(11) NOT NULL,
  `taux` int(3) DEFAULT '100'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `equipes`
--

CREATE TABLE `equipes` (
  `id` int(11) NOT NULL,
  `nom_equipe` varchar(25) NOT NULL,
  `responsable_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `equipes_projets`
--

CREATE TABLE `equipes_projets` (
  `equipe_id` int(11) NOT NULL,
  `projet_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `equipes_responsables`
--

CREATE TABLE `equipes_responsables` (
  `equipe_id` int(11) NOT NULL,
  `responsable_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `financements`
--

CREATE TABLE `financements` (
  `id` int(11) NOT NULL,
  `international` tinyint(1) DEFAULT NULL,
  `nationalite_financement` varchar(60) DEFAULT NULL,
  `financement_prive` tinyint(1) DEFAULT NULL,
  `financement` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `lieus`
--

CREATE TABLE `lieus` (
  `id` int(11) NOT NULL,
  `nom_lieu` varchar(60) DEFAULT NULL,
  `est_dans_liste` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `lieu_travails`
--

CREATE TABLE `lieu_travails` (
  `id` int(11) NOT NULL,
  `nom_lieu` varchar(60) NOT NULL,
  `est_dans_liste` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Structure de la table `membres`
--

CREATE TABLE `membres` (
  `id` int(11) NOT NULL,
  `role` enum('admin','membre') NOT NULL DEFAULT 'membre',
  `nom` varchar(25) DEFAULT NULL,
  `prenom` varchar(25) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `passwd` varchar(100) DEFAULT NULL,
  `adresse_agent_1` varchar(80) DEFAULT NULL,
  `adresse_agent_2` varchar(60) DEFAULT NULL,
  `residence_admin_1` varchar(80) DEFAULT NULL,
  `residence_admin_2` varchar(80) DEFAULT NULL,
  `type_personnel` enum('PU','PE','Do') DEFAULT NULL,
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
  `hdr` tinyint(1) DEFAULT NULL COMMENT 'Certification HDR',
  `permanent` tinyint(1) DEFAULT '1',
  `est_porteur` tinyint(1) DEFAULT '0',
  `date_creation` datetime DEFAULT NULL,
  `date_sortie` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `fichiers`
--

CREATE TABLE `fichiers` (
	`id` int(11) NOT NULL,
    `nom` varchar(100) NOT NULL,
    `titre` varchar(100) DEFAULT NULL,
    `description` varchar(500) DEFAULT NULL,
    `date_upload` datetime DEFAULT CURRENT_TIMESTAMP,
    `membre_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Structure de la table `missions`
--

CREATE TABLE `missions` (
  `id` int(11) NOT NULL,
  `complement_motif` varchar(40) DEFAULT NULL,
  `date_depart` datetime DEFAULT NULL,
  `date_retour` datetime DEFAULT NULL,
  `sans_frais` tinyint(1) DEFAULT NULL,
  `etat` enum('soumis','vaide') DEFAULT NULL,
  `nb_nuites` int(11) DEFAULT NULL,
  `nb_repas` int(11) DEFAULT NULL,
  `billet_agence` tinyint(1) DEFAULT NULL,
  `commentaire_transport` text,
  `projet_id` int(11) DEFAULT NULL,
  `lieu_id` int(11) DEFAULT NULL,
  `motif_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `missions_transports`
--

CREATE TABLE `missions_transports` (
  `mission_id` int(11) NOT NULL,
  `transport_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `motifs`
--

CREATE TABLE `motifs` (
  `id` int(11) NOT NULL,
  `nom_motif` varchar(60) DEFAULT NULL,
  `est_dans_liste` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `projets`
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

-- --------------------------------------------------------

--
-- Structure de la table `theses`
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

-- --------------------------------------------------------

--
-- Structure de la table `transports`
--

CREATE TABLE `transports` (
  `id` int(11) NOT NULL,
  `type_transport` enum('train','avion','vehicule_personnel','vehicule_service') DEFAULT NULL,
  `im_vehicule` varchar(10) DEFAULT NULL,
  `pf_vehicule` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `budgets_annuels`
--
ALTER TABLE `budgets_annuels`
  ADD PRIMARY KEY (`projet_id`,`annee`),
  ADD KEY `projet_id` (`projet_id`);

--
-- Index pour la table `dirigeants`
--
ALTER TABLE `dirigeants`
  ADD KEY `dirigeant_id` (`dirigeant_id`);

--
-- Index pour la table `dirigeants_theses`
--
ALTER TABLE `dirigeants_theses`
  ADD PRIMARY KEY (`dirigeant_id`,`these_id`),
  ADD KEY `these_key` (`these_id`);

--
-- Index pour la table `encadrants`
--
ALTER TABLE `encadrants`
  ADD KEY `encadrant_id` (`encadrant_id`);

--
-- Index pour la table `encadrants_theses`
--
ALTER TABLE `encadrants_theses`
  ADD PRIMARY KEY (`encadrant_id`,`these_id`),
  ADD KEY `encadrant_id` (`encadrant_id`),
  ADD KEY `these_id` (`these_id`);

--
-- Index pour la table `equipes`
--
ALTER TABLE `equipes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom_equipe` (`nom_equipe`),
  ADD KEY `responsable_id` (`responsable_id`);

--
-- Index pour la table `equipes_projets`
--
ALTER TABLE `equipes_projets`
  ADD PRIMARY KEY (`equipe_id`,`projet_id`),
  ADD KEY `equipe_id` (`equipe_id`),
  ADD KEY `projet_id` (`projet_id`);

--
-- Index pour la table `equipes_responsables`
--
ALTER TABLE `equipes_responsables`
  ADD PRIMARY KEY (`equipe_id`,`responsable_id`),
  ADD KEY `equipe_id` (`equipe_id`),
  ADD KEY `responsable_id` (`responsable_id`);

--
-- Index pour la table `financements`
--
ALTER TABLE `financements`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `lieus`
--
ALTER TABLE `lieus`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `lieu_travails`
--
ALTER TABLE `lieu_travails`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom_lieu` (`nom_lieu`);

--
-- Index pour la table `membres`
--
ALTER TABLE `membres`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `lieu_travail_id` (`lieu_travail_id`),
  ADD KEY `equipe_id` (`equipe_id`);
  
--
-- Index pour la table `membres`
--
ALTER TABLE `fichiers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom` (`nom`),
  ADD KEY `membre_id` (`membre_id`);

--
-- Index pour la table `missions`
--
ALTER TABLE `missions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projet_id` (`projet_id`),
  ADD KEY `lieu_id` (`lieu_id`),
  ADD KEY `motif_id` (`motif_id`);

--
-- Index pour la table `missions_transports`
--
ALTER TABLE `missions_transports`
  ADD PRIMARY KEY (`mission_id`,`transport_id`),
  ADD KEY `transport_id` (`transport_id`);

--
-- Index pour la table `motifs`
--
ALTER TABLE `motifs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `projets`
--
ALTER TABLE `projets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `financement_id` (`financement_id`);

--
-- Index pour la table `theses`
--
ALTER TABLE `theses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `financement_id` (`financement_id`),
  ADD KEY `auteur_id` (`auteur_id`);

--
-- Index pour la table `transports`
--
ALTER TABLE `transports`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `equipes`
--
ALTER TABLE `equipes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `financements`
--
ALTER TABLE `financements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `lieus`
--
ALTER TABLE `lieus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `lieu_travails`
--
ALTER TABLE `lieu_travails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `membres`
--
ALTER TABLE `membres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
  
--
-- AUTO_INCREMENT pour la table `fichiers`
--
ALTER TABLE `fichiers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `missions`
--
ALTER TABLE `missions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `motifs`
--
ALTER TABLE `motifs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `projets`
--
ALTER TABLE `projets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `theses`
--
ALTER TABLE `theses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `transports`
--
ALTER TABLE `transports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `budgets_annuels`
--
ALTER TABLE `budgets_annuels`
  ADD CONSTRAINT `fk_budgets_annuels_1` FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `dirigeants`
--
ALTER TABLE `dirigeants`
  ADD CONSTRAINT `fk_dirigeants_1` FOREIGN KEY (`dirigeant_id`) REFERENCES `membres` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `dirigeants_theses`
--
ALTER TABLE `dirigeants_theses`
  ADD CONSTRAINT `dirigeant_key` FOREIGN KEY (`dirigeant_id`) REFERENCES `dirigeants` (`dirigeant_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `these_key` FOREIGN KEY (`these_id`) REFERENCES `theses` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `encadrants`
--
ALTER TABLE `encadrants`
  ADD CONSTRAINT `fk_encadrants_1` FOREIGN KEY (`encadrant_id`) REFERENCES `membres` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `encadrants_theses`
--
ALTER TABLE `encadrants_theses`
  ADD CONSTRAINT `fk_encadrants_theses_1` FOREIGN KEY (`encadrant_id`) REFERENCES `encadrants` (`encadrant_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_encadrants_theses_2` FOREIGN KEY (`these_id`) REFERENCES `theses` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `equipes`
--
ALTER TABLE `equipes`
  ADD CONSTRAINT `fk_equipes_1` FOREIGN KEY (`responsable_id`) REFERENCES `membres` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `equipes_projets`
--
ALTER TABLE `equipes_projets`
  ADD CONSTRAINT `fk_equipes_projets_1` FOREIGN KEY (`equipe_id`) REFERENCES `equipes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_equipes_projets_2` FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `equipes_responsables`
--
ALTER TABLE `equipes_responsables`
  ADD CONSTRAINT `fk_equipes_responsables_1` FOREIGN KEY (`responsable_id`) REFERENCES `membres` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_equipes_responsables_2` FOREIGN KEY (`equipe_id`) REFERENCES `equipes` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `membres`
--
ALTER TABLE `membres`
  ADD CONSTRAINT `fk_membre_1` FOREIGN KEY (`lieu_travail_id`) REFERENCES `lieu_travails` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_membre_2` FOREIGN KEY (`equipe_id`) REFERENCES `equipes` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `fichiers`
--
ALTER TABLE `fichiers`
  ADD CONSTRAINT `fk_fichiers_1` FOREIGN KEY (`membre_id`) REFERENCES `membres` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `missions`
--
ALTER TABLE `missions`
  ADD CONSTRAINT `missions_ibfk_1` FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `missions_ibfk_2` FOREIGN KEY (`lieu_id`) REFERENCES `lieus` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `missions_ibfk_3` FOREIGN KEY (`motif_id`) REFERENCES `motifs` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `missions_transports`
--
ALTER TABLE `missions_transports`
  ADD CONSTRAINT `missions_transports_ibfk_1` FOREIGN KEY (`mission_id`) REFERENCES `missions` (`id`) ,
  ADD CONSTRAINT `missions_transports_ibfk_2` FOREIGN KEY (`transport_id`) REFERENCES `transports` (`id`) ;

--
-- Contraintes pour la table `projets`
--
ALTER TABLE `projets`
  ADD CONSTRAINT `projets_ibfk_1` FOREIGN KEY (`financement_id`) REFERENCES `financements` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `theses`
--
ALTER TABLE `theses`
  ADD CONSTRAINT `fk_theses_1` FOREIGN KEY (`auteur_id`) REFERENCES `membres` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_theses_2` FOREIGN KEY (`financement_id`) REFERENCES `financements` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
