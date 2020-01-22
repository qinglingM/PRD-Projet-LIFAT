SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Creations de Lieux de Travail
--
INSERT INTO `lieu_travails` (`id`, `nom_lieu`, `est_dans_liste`) VALUES ('1', 'Polytech Tours', '1');
INSERT INTO `lieu_travails` (`id`, `nom_lieu`, `est_dans_liste`) VALUES ('2', 'LIFAT Paris', '1');
INSERT INTO `lieu_travails` (`id`, `nom_lieu`, `est_dans_liste`) VALUES ('3', 'LIFAT Blois', '1');
INSERT INTO `lieu_travails` (`id`, `nom_lieu`, `est_dans_liste`) VALUES ('5', 'LIFAT Lille', '1');
INSERT INTO `lieu_travails` (`id`, `nom_lieu`, `est_dans_liste`) VALUES ('6', 'LIFAT Angers', '1');

--
-- Creations des equipes vides
--
INSERT INTO `equipes` (`id`, `nom_equipe`, `responsable_id`) VALUES (1, 'equipe1', NULL);
INSERT INTO `equipes` (`id`, `nom_equipe`, `responsable_id`) VALUES (2, 'equipe2', NULL);
INSERT INTO `equipes` (`id`, `nom_equipe`, `responsable_id`) VALUES (3, 'equipe3', NULL);
INSERT INTO `equipes` (`id`, `nom_equipe`, `responsable_id`) VALUES (4, 'equipe4', NULL);
INSERT INTO `equipes` (`id`, `nom_equipe`, `responsable_id`) VALUES (5, 'equipe5', NULL);
INSERT INTO `equipes` (`id`, `nom_equipe`, `responsable_id`) VALUES (6, 'equipe6', NULL);
INSERT INTO `equipes` (`id`, `nom_equipe`, `responsable_id`) VALUES (7, 'equipe7', NULL);

--
-- Creations de Membres
--
INSERT INTO `membres` (`id`, `role`, `nom`, `prenom`, `email`, `passwd`, `adresse_agent_1`, `adresse_agent_2`, `residence_admin_1`, `residence_admin_2`, `type_personnel`, `intitule`, `grade`, `im_vehicule`, `pf_vehicule`, `signature_name`, `login_cas`, `carte_sncf`, `matricule`, `date_naissance`, `actif`, `lieu_travail_id`, `equipe_id`, `nationalite`, `est_francais`, `genre`, `hdr`, `permanent`, `est_porteur`, `date_creation`, `date_sortie`) VALUES
(1, 'admin', 'Admin', 'Admin', 'admin@admin.fr', '$2y$10$bzSGIbfxvGYjAh6H2f6rAuMKaAEAdYUrhrpNq/SoOmHKPnQdX58jG', '', '', '', '', '', '', '', 'AB123DC', 7, '', '', '', NULL, NULL, 1, 2, 1, '', 1, 'F', 0, 1, 0, NULL, NULL);
INSERT INTO `membres` (`id`, `role`, `nom`, `prenom`, `email`, `passwd`, `adresse_agent_1`, `adresse_agent_2`, `residence_admin_1`, `residence_admin_2`, `type_personnel`, `intitule`, `grade`, `im_vehicule`, `pf_vehicule`, `signature_name`, `login_cas`, `carte_sncf`, `matricule`, `date_naissance`, `actif`, `lieu_travail_id`, `equipe_id`, `nationalite`, `est_francais`, `genre`, `hdr`, `permanent`, `est_porteur`, `date_creation`, `date_sortie`) VALUES
(2, 'user', 'nomUser2', 'prenomUser2', 'user2@email.fr', '$2y$10$PksbXyiUFxHocqxYr4HmlOJfGGOJqfeWmYwieXQroCL3ChQQr1zEC', 'adresse2', NULL, 'residence2', NULL, 'DO', 'intitule2', 'Chef d equipe', 'imatriculation2', '2', '', NULL, 'carteSncf2', '0101010102', '1997-06-07 00:15:00', '1', 1, 1, 'Français', '1', 'f', NULL, '1', '1', '2019-05-01 16:15:00', NULL);
INSERT INTO `membres` (`id`, `role`, `nom`, `prenom`, `email`, `passwd`, `adresse_agent_1`, `adresse_agent_2`, `residence_admin_1`, `residence_admin_2`, `type_personnel`, `intitule`, `grade`, `im_vehicule`, `pf_vehicule`, `signature_name`, `login_cas`, `carte_sncf`, `matricule`, `date_naissance`, `actif`, `lieu_travail_id`, `equipe_id`, `nationalite`, `est_francais`, `genre`, `hdr`, `permanent`, `est_porteur`, `date_creation`, `date_sortie`) VALUES
(3, 'user', 'nomUser2', 'prenomUser3', 'user3@email.fr', '$2y$10$PksbXyiUFxHocqxYr4HmlOJfGGOJqfeWmYwieXQroCL3ChQQr1zEC', 'adress3', NULL, 'residence3', NULL, 'PU', 'intitule3', 'Chef d equipe', 'imatriculation3', '3', '', NULL, 'carteSncf3', '0101010103', '1990-10-20 13:47:00', '1', 2, 2, 'Français', '1', 'h', NULL, '1', '0', '2019-05-01 16:15:00', NULL);
INSERT INTO `membres` (`id`, `role`, `nom`, `prenom`, `email`, `passwd`, `adresse_agent_1`, `adresse_agent_2`, `residence_admin_1`, `residence_admin_2`, `type_personnel`, `intitule`, `grade`, `im_vehicule`, `pf_vehicule`, `signature_name`, `login_cas`, `carte_sncf`, `matricule`, `date_naissance`, `actif`, `lieu_travail_id`, `equipe_id`, `nationalite`, `est_francais`, `genre`, `hdr`, `permanent`, `est_porteur`, `date_creation`, `date_sortie`) VALUES
(4, 'user', 'nomUser3', 'prenomUser4', 'user4@email.fr', '$2y$10$PksbXyiUFxHocqxYr4HmlOJfGGOJqfeWmYwieXQroCL3ChQQr1zEC', 'adresse4', NULL, 'residence4', NULL, 'PU', 'intitule4', 'Chercheur', 'imatriculation4', '4', '', NULL, 'carteSncf4', '0101010104', '1999-12-25 16:15:54', '1', 1, 1, 'Allemand', '0', 'h', NULL, '0', '0', '2019-05-01 16:15:00', NULL);
INSERT INTO `membres` (`id`, `role`, `nom`, `prenom`, `email`, `passwd`, `adresse_agent_1`, `adresse_agent_2`, `residence_admin_1`, `residence_admin_2`, `type_personnel`, `intitule`, `grade`, `im_vehicule`, `pf_vehicule`, `signature_name`, `login_cas`, `carte_sncf`, `matricule`, `date_naissance`, `actif`, `lieu_travail_id`, `equipe_id`, `nationalite`, `est_francais`, `genre`, `hdr`, `permanent`, `est_porteur`, `date_creation`, `date_sortie`) VALUES
(5, 'user', 'nomUser4', 'prenomUser5', 'user5@email.fr', '$2y$10$PksbXyiUFxHocqxYr4HmlOJfGGOJqfeWmYwieXQroCL3ChQQr1zEC', 'adresse5', NULL, 'residence5', NULL, 'PE', 'intitule5', 'Chercheur', 'imatriculation5', '5', '', NULL, NULL, '0101010105', '1987-02-01 21:37:20', '1', 1, 1, 'Americain', '0', 'h', NULL, '1', '0', '2019-05-01 16:15:00', NULL);
INSERT INTO `membres` (`id`, `role`, `nom`, `prenom`, `email`, `passwd`, `adresse_agent_1`, `adresse_agent_2`, `residence_admin_1`, `residence_admin_2`, `type_personnel`, `intitule`, `grade`, `im_vehicule`, `pf_vehicule`, `signature_name`, `login_cas`, `carte_sncf`, `matricule`, `date_naissance`, `actif`, `lieu_travail_id`, `equipe_id`, `nationalite`, `est_francais`, `genre`, `hdr`, `permanent`, `est_porteur`, `date_creation`, `date_sortie`) VALUES
(6, 'user', 'nomUser6', 'prenomUser6', 'user6@email.fr', '$2y$10$PksbXyiUFxHocqxYr4HmlOJfGGOJqfeWmYwieXQroCL3ChQQr1zEC', 'adresse6', NULL, 'residence6', NULL, 'PU', 'intitule6', 'Chercheur', 'imatriculation6', '6', '', NULL, 'carteSncf6', '0101010106', '1986-02-24 15:00:12', '1', 2, 2, 'Allemand', '0', 'f', NULL, '1', '0', '2019-05-01 16:15:00', NULL);
INSERT INTO `membres` (`id`, `role`, `nom`, `prenom`, `email`, `passwd`, `adresse_agent_1`, `adresse_agent_2`, `residence_admin_1`, `residence_admin_2`, `type_personnel`, `intitule`, `grade`, `im_vehicule`, `pf_vehicule`, `signature_name`, `login_cas`, `carte_sncf`, `matricule`, `date_naissance`, `actif`, `lieu_travail_id`, `equipe_id`, `nationalite`, `est_francais`, `genre`, `hdr`, `permanent`, `est_porteur`, `date_creation`, `date_sortie`) VALUES
(7, 'user', 'nomUser7', 'prenomUser7', 'user7@email.fr', '$2y$10$PksbXyiUFxHocqxYr4HmlOJfGGOJqfeWmYwieXQroCL3ChQQr1zEC', 'adresse7', NULL, 'residence7', NULL, 'PE', 'intitule7', 'Chercheur', 'imatriculation7', '7', '', NULL, NULL, '0101010107', '1986-07-01 20:54:01', '1', 2, 2, 'Americain', '0', 'h', NULL, '1', '0', '2019-05-01 16:15:00', NULL);
INSERT INTO `membres` (`id`, `role`, `nom`, `prenom`, `email`, `passwd`, `adresse_agent_1`, `adresse_agent_2`, `residence_admin_1`, `residence_admin_2`, `type_personnel`, `intitule`, `grade`, `im_vehicule`, `pf_vehicule`, `signature_name`, `login_cas`, `carte_sncf`, `matricule`, `date_naissance`, `actif`, `lieu_travail_id`, `equipe_id`, `nationalite`, `est_francais`, `genre`, `hdr`, `permanent`, `est_porteur`, `date_creation`, `date_sortie`) VALUES
(8, 'user', 'nomUser8', 'prenomUser8', 'user8@email.fr', '$2y$10$PksbXyiUFxHocqxYr4HmlOJfGGOJqfeWmYwieXQroCL3ChQQr1zEC', 'adresse8', NULL, 'residence8', NULL, 'PE', 'intitule8', 'Chercheur', 'imatriculation8', '8', '', NULL, NULL, '0101010108', '1979-03-18 15:26:08', '1', 2, 2, 'Français', '1', 'h', NULL, '1', '0', '2019-05-01 16:15:00', NULL);
INSERT INTO `membres` (`id`, `role`, `nom`, `prenom`, `email`, `passwd`, `adresse_agent_1`, `adresse_agent_2`, `residence_admin_1`, `residence_admin_2`, `type_personnel`, `intitule`, `grade`, `im_vehicule`, `pf_vehicule`, `signature_name`, `login_cas`, `carte_sncf`, `matricule`, `date_naissance`, `actif`, `lieu_travail_id`, `equipe_id`, `nationalite`, `est_francais`, `genre`, `hdr`, `permanent`, `est_porteur`, `date_creation`, `date_sortie`) VALUES
(9, 'user', 'nomUser9', 'prenomUser9', 'user9@email.fr', '$2y$10$PksbXyiUFxHocqxYr4HmlOJfGGOJqfeWmYwieXQroCL3ChQQr1zEC', 'adresse9', NULL, 'residence9', NULL, 'DO', 'intitule9', 'Chercheur', 'imatriculation9', '9', '', NULL, 'carteSncf9', '0101010109', '1992-07-06 12:16:41', '1', 1, 3, 'Français', '1', 'f', NULL, '0', '0', '2019-05-01 16:15:00', NULL);
INSERT INTO `membres` (`id`, `role`, `nom`, `prenom`, `email`, `passwd`, `adresse_agent_1`, `adresse_agent_2`, `residence_admin_1`, `residence_admin_2`, `type_personnel`, `intitule`, `grade`, `im_vehicule`, `pf_vehicule`, `signature_name`, `login_cas`, `carte_sncf`, `matricule`, `date_naissance`, `actif`, `lieu_travail_id`, `equipe_id`, `nationalite`, `est_francais`, `genre`, `hdr`, `permanent`, `est_porteur`, `date_creation`, `date_sortie`) VALUES
(10, 'user', 'nomUser10', 'prenomUser10', 'user10@email.fr', '$2y$10$PksbXyiUFxHocqxYr4HmlOJfGGOJqfeWmYwieXQroCL3ChQQr1zEC', 'adresse10', NULL, 'residence10', NULL, 'PU', 'intitule10', 'Chercheur', 'imatriculation10', '10', '', NULL, 'carteSncf10', '0101010110', '1992-11-24 19:57:12', '1', 1, 3, 'Anglais', '0', 'h', NULL, '1', '0', '2019-05-01 16:15:00', NULL);
INSERT INTO `membres` (`id`, `role`, `nom`, `prenom`, `email`, `passwd`, `adresse_agent_1`, `adresse_agent_2`, `residence_admin_1`, `residence_admin_2`, `type_personnel`, `intitule`, `grade`, `im_vehicule`, `pf_vehicule`, `signature_name`, `login_cas`, `carte_sncf`, `matricule`, `date_naissance`, `actif`, `lieu_travail_id`, `equipe_id`, `nationalite`, `est_francais`, `genre`, `hdr`, `permanent`, `est_porteur`, `date_creation`, `date_sortie`) VALUES
(11, 'user', 'nomUser11', 'prenomUser11', 'user11@email.fr', '$2y$10$PksbXyiUFxHocqxYr4HmlOJfGGOJqfeWmYwieXQroCL3ChQQr1zEC', 'adresse11', NULL, 'residence11', NULL, 'PU', 'intitule11', 'Chercheur', 'imatriculation11', '11', '', NULL, 'carteSncf11', '0101010111', '1993-05-21 03:31:01', '1', 2, 2, 'Français', '1', 'f', NULL, '1', '0', '2019-05-01 16:15:00', NULL);
INSERT INTO `membres` (`id`, `role`, `nom`, `prenom`, `email`, `passwd`, `adresse_agent_1`, `adresse_agent_2`, `residence_admin_1`, `residence_admin_2`, `type_personnel`, `intitule`, `grade`, `im_vehicule`, `pf_vehicule`, `signature_name`, `login_cas`, `carte_sncf`, `matricule`, `date_naissance`, `actif`, `lieu_travail_id`, `equipe_id`, `nationalite`, `est_francais`, `genre`, `hdr`, `permanent`, `est_porteur`, `date_creation`, `date_sortie`) VALUES
(12, 'user', 'nomUser12', 'prenomUser12', 'user12@email.fr', '$2y$10$PksbXyiUFxHocqxYr4HmlOJfGGOJqfeWmYwieXQroCL3ChQQr1zEC', 'adresse12', NULL, 'residence12', NULL, 'DO', 'intitule12', 'Chercheur', 'imatriculation12', '12', '', NULL, 'carteSncf12', '0101010112', '1994-04-16 04:45:37', '1', 1, 1, 'Français', '1', 'h', NULL, '0', '0', '2019-05-01 16:15:00', NULL);
INSERT INTO `membres` (`id`, `role`, `nom`, `prenom`, `email`, `passwd`, `adresse_agent_1`, `adresse_agent_2`, `residence_admin_1`, `residence_admin_2`, `type_personnel`, `intitule`, `grade`, `im_vehicule`, `pf_vehicule`, `signature_name`, `login_cas`, `carte_sncf`, `matricule`, `date_naissance`, `actif`, `lieu_travail_id`, `equipe_id`, `nationalite`, `est_francais`, `genre`, `hdr`, `permanent`, `est_porteur`, `date_creation`, `date_sortie`) VALUES
(13, 'user', 'nomUser13', 'prenomUser13', 'user13@email.fr', '$2y$10$PksbXyiUFxHocqxYr4HmlOJfGGOJqfeWmYwieXQroCL3ChQQr1zEC', 'adresse13', NULL, 'residence13', NULL, 'DO', 'intitule13', 'Chercheur', 'imatriculation13', '13', '', NULL, 'carteSncf13', '0101010113', '1993-07-09 19:36:49', '1', 1, 3, 'Espagnol', '0', 'f', NULL, '1', '0', '2019-05-01 16:15:00', NULL);
INSERT INTO `membres` (`id`, `role`, `nom`, `prenom`, `email`, `passwd`, `adresse_agent_1`, `adresse_agent_2`, `residence_admin_1`, `residence_admin_2`, `type_personnel`, `intitule`, `grade`, `im_vehicule`, `pf_vehicule`, `signature_name`, `login_cas`, `carte_sncf`, `matricule`, `date_naissance`, `actif`, `lieu_travail_id`, `equipe_id`, `nationalite`, `est_francais`, `genre`, `hdr`, `permanent`, `est_porteur`, `date_creation`, `date_sortie`) VALUES
(14, 'user', 'nomUser14', 'prenomUser14', 'user14@email.fr', '$2y$10$PksbXyiUFxHocqxYr4HmlOJfGGOJqfeWmYwieXQroCL3ChQQr1zEC', 'adresse14', NULL, 'residence14', NULL, 'DO', 'intitule14', 'Chercheur', 'imatriculation14', '14', '', NULL, 'carteSncf14', '0101010114', '1995-11-27 18:21:14', '1', 2, 2, 'Français', '1', 'h', NULL, '1', '0', '2019-05-01 16:15:00', NULL);
INSERT INTO `membres` (`id`, `role`, `nom`, `prenom`, `email`, `passwd`, `adresse_agent_1`, `adresse_agent_2`, `residence_admin_1`, `residence_admin_2`, `type_personnel`, `intitule`, `grade`, `im_vehicule`, `pf_vehicule`, `signature_name`, `login_cas`, `carte_sncf`, `matricule`, `date_naissance`, `actif`, `lieu_travail_id`, `equipe_id`, `nationalite`, `est_francais`, `genre`, `hdr`, `permanent`, `est_porteur`, `date_creation`, `date_sortie`) VALUES
(15, 'user', 'nomUser15', 'prenomUser15', 'user15@email.fr', '$2y$10$PksbXyiUFxHocqxYr4HmlOJfGGOJqfeWmYwieXQroCL3ChQQr1zEC', 'adresse15', NULL, 'residence15', NULL, 'DO', 'intitule15', 'Chercheur', 'imatriculation15', '15', '', NULL, 'carteSncf15', '0101010115', '1994-06-13 12:06:11', '1', 1, 3, 'Anglais', '0', 'f', NULL, '0', '0', '2019-05-01 16:15:00', NULL);
INSERT INTO `membres` (`id`, `role`, `nom`, `prenom`, `email`, `passwd`, `adresse_agent_1`, `adresse_agent_2`, `residence_admin_1`, `residence_admin_2`, `type_personnel`, `intitule`, `grade`, `im_vehicule`, `pf_vehicule`, `signature_name`, `login_cas`, `carte_sncf`, `matricule`, `date_naissance`, `actif`, `lieu_travail_id`, `equipe_id`, `nationalite`, `est_francais`, `genre`, `hdr`, `permanent`, `est_porteur`, `date_creation`, `date_sortie`) VALUES
(16, 'user', 'nomUser16', 'prenomUser16', 'user16@email.fr', '$2y$10$PksbXyiUFxHocqxYr4HmlOJfGGOJqfeWmYwieXQroCL3ChQQr1zEC', 'adresse16', NULL, 'residence16', NULL, 'PU', 'intitule16', 'Chef d equipe', 'imatriculation16', '16', '', NULL, 'carteSncf16', '0101010116', '1993-05-21 03:31:01', '1', 3, 4, 'Français', '1', 'h', NULL, '1', '0', '2019-05-01 16:15:00', NULL);
INSERT INTO `membres` (`id`, `role`, `nom`, `prenom`, `email`, `passwd`, `adresse_agent_1`, `adresse_agent_2`, `residence_admin_1`, `residence_admin_2`, `type_personnel`, `intitule`, `grade`, `im_vehicule`, `pf_vehicule`, `signature_name`, `login_cas`, `carte_sncf`, `matricule`, `date_naissance`, `actif`, `lieu_travail_id`, `equipe_id`, `nationalite`, `est_francais`, `genre`, `hdr`, `permanent`, `est_porteur`, `date_creation`, `date_sortie`) VALUES
(17, 'user', 'nomUser17', 'prenomUser17', 'user17@email.fr', '$2y$10$PksbXyiUFxHocqxYr4HmlOJfGGOJqfeWmYwieXQroCL3ChQQr1zEC', 'adresse17', NULL, 'residence17', NULL, 'PU', 'intitule17', 'Chef d equipe', 'imatriculation17', '17', '', NULL, 'carteSncf17', '0101010117', '1994-04-16 04:45:37', '1', 2, 5, 'Français', '1', 'f', NULL, '0', '0', '2019-05-01 16:15:00', NULL);
INSERT INTO `membres` (`id`, `role`, `nom`, `prenom`, `email`, `passwd`, `adresse_agent_1`, `adresse_agent_2`, `residence_admin_1`, `residence_admin_2`, `type_personnel`, `intitule`, `grade`, `im_vehicule`, `pf_vehicule`, `signature_name`, `login_cas`, `carte_sncf`, `matricule`, `date_naissance`, `actif`, `lieu_travail_id`, `equipe_id`, `nationalite`, `est_francais`, `genre`, `hdr`, `permanent`, `est_porteur`, `date_creation`, `date_sortie`) VALUES
(18, 'user', 'nomUser18', 'prenomUser18', 'user18@email.fr', '$2y$10$PksbXyiUFxHocqxYr4HmlOJfGGOJqfeWmYwieXQroCL3ChQQr1zEC', 'adresse18', NULL, 'residence18', NULL, 'PU', 'intitule18', 'Chef d equipe', 'imatriculation18', '18', '', NULL, 'carteSncf18', '0101010118', '1993-07-09 19:36:49', '1', 3, 6, 'Espagnol', '0', 'h', NULL, '1', '0', '2019-05-01 16:15:00', NULL);
INSERT INTO `membres` (`id`, `role`, `nom`, `prenom`, `email`, `passwd`, `adresse_agent_1`, `adresse_agent_2`, `residence_admin_1`, `residence_admin_2`, `type_personnel`, `intitule`, `grade`, `im_vehicule`, `pf_vehicule`, `signature_name`, `login_cas`, `carte_sncf`, `matricule`, `date_naissance`, `actif`, `lieu_travail_id`, `equipe_id`, `nationalite`, `est_francais`, `genre`, `hdr`, `permanent`, `est_porteur`, `date_creation`, `date_sortie`) VALUES
(19, 'user', 'nomUser19', 'prenomUser19', 'user19@email.fr', '$2y$10$PksbXyiUFxHocqxYr4HmlOJfGGOJqfeWmYwieXQroCL3ChQQr1zEC', 'adresse19', NULL, 'residence19', NULL, 'PU', 'intitule19', 'Chef d equipe', 'imatriculation19', '19', '', NULL, 'carteSncf19', '0101010119', '1995-11-27 18:21:14', '1', 3, 7, 'Français', '1', 'f', NULL, '1', '0', '2019-05-01 16:15:00', NULL);
INSERT INTO `membres` (`id`, `role`, `nom`, `prenom`, `email`, `passwd`, `adresse_agent_1`, `adresse_agent_2`, `residence_admin_1`, `residence_admin_2`, `type_personnel`, `intitule`, `grade`, `im_vehicule`, `pf_vehicule`, `signature_name`, `login_cas`, `carte_sncf`, `matricule`, `date_naissance`, `actif`, `lieu_travail_id`, `equipe_id`, `nationalite`, `est_francais`, `genre`, `hdr`, `permanent`, `est_porteur`, `date_creation`, `date_sortie`) VALUES
(20, 'user', 'nomUser20', 'prenomUser20', 'user20@email.fr', '$2y$10$PksbXyiUFxHocqxYr4HmlOJfGGOJqfeWmYwieXQroCL3ChQQr1zEC', 'adresse20', NULL, 'residence20', NULL, 'PU', 'intitule20', 'Chercheur', 'imatriculation20', '20', '', NULL, 'carteSncf20', '0101010120', '1994-06-13 12:06:11', '1', 3, 7, 'Anglais', '0', 'h', NULL, '0', '0', '2019-05-01 16:15:00', NULL);

--
-- Creations des encadrants
--
INSERT INTO `encadrants` (`encadrant_id`) VALUES ('3');
INSERT INTO `encadrants` (`encadrant_id`) VALUES ('4');
INSERT INTO `encadrants` (`encadrant_id`) VALUES ('6');

--
-- Creations des dirigeants
--
INSERT INTO `dirigeants` (`dirigeant_id`) VALUES ('6');
INSERT INTO `dirigeants` (`dirigeant_id`) VALUES ('10');

--
-- Mise à jour des responsables des equipes dans la table equipe
--
UPDATE `equipes` SET  `responsable_id` = '2' WHERE `id` = 1;
UPDATE `equipes` SET  `responsable_id` = '3' WHERE `id` = 2;
UPDATE `equipes` SET  `responsable_id` = '11' WHERE `id` = 3;
UPDATE `equipes` SET  `responsable_id` = '16' WHERE `id` = 4;
UPDATE `equipes` SET  `responsable_id` = '17' WHERE `id` = 5;
UPDATE `equipes` SET  `responsable_id` = '18' WHERE `id` = 6;
UPDATE `equipes` SET  `responsable_id` = '19' WHERE `id` = 7;

--
-- Creations des financements
--
INSERT INTO `financements` (`id`, `international`, `nationalite_financement`, `financement_prive`, `financement`) VALUES ('1', '0', 'Français', '0', '50000 euros');
INSERT INTO `financements` (`id`, `international`, `nationalite_financement`, `financement_prive`, `financement`) VALUES ('2', '1', 'Allemand', '1', '250000 euros');
INSERT INTO `financements` (`id`, `international`, `nationalite_financement`, `financement_prive`, `financement`) VALUES ('3', '1', 'Espagnol', '1', '275000 euros');
INSERT INTO `financements` (`id`, `international`, `nationalite_financement`, `financement_prive`, `financement`) VALUES ('4', '0', 'Français', '0', '120000 euros');

--
-- Creations des theses
--
INSERT INTO `theses` (`id`, `sujet`, `type`, `date_debut`, `date_fin`, `autre_info`, `est_hdr`,  `financement_id`, `auteur_id`) VALUES (1, 'these1', 'Informatique Robotique', '2019-05-01', '2021-01-23', 'autreInfo1', '0', NULL, '9');
INSERT INTO `theses` (`id`, `sujet`, `type`, `date_debut`, `date_fin`, `autre_info`, `est_hdr`,  `financement_id`, `auteur_id`) VALUES (2, 'these2', 'Taitement d image avance', '2017-02-24', '2018-07-23', 'autreInfo2', '1', '1', '2');
INSERT INTO `theses` (`id`, `sujet`, `type`, `date_debut`, `date_fin`, `autre_info`, `est_hdr`,  `financement_id`, `auteur_id`) VALUES (3, 'these3', 'MicroElectronique avance', '2019-03-24', '2019-11-23', 'autreInfo3', '0', '2', '12');
INSERT INTO `theses` (`id`, `sujet`, `type`, `date_debut`, `date_fin`, `autre_info`, `est_hdr`,  `financement_id`, `auteur_id`) VALUES (4, 'these4', 'Resolution de transfert important de donnees', '2019-06-27', '2020-03-29', 'autreInfo4', '1', '3', '2');
INSERT INTO `theses` (`id`, `sujet`, `type`, `date_debut`, `date_fin`, `autre_info`, `est_hdr`,  `financement_id`, `auteur_id`) VALUES (5, 'these5', 'Medecine et Informatique', '2019-02-24', '2019-09-07', 'autreInfo5', '0', '4', '14');
INSERT INTO `theses` (`id`, `sujet`, `type`, `date_debut`, `date_fin`, `autre_info`, `est_hdr`,  `financement_id`, `auteur_id`) VALUES (6, 'these6', 'Informatique au service de la planete', '2020-06-24', '2021-01-19', 'autreInfo6', '0', NULL, '15');

--
-- Creations des dirigents_theses
--
INSERT INTO `dirigeants_theses` (`dirigeant_id`, `these_id`, `taux`) VALUES ('10', '2', '100');
INSERT INTO `dirigeants_theses` (`dirigeant_id`, `these_id`, `taux`) VALUES ('6', '1', '27');
INSERT INTO `dirigeants_theses` (`dirigeant_id`, `these_id`, `taux`) VALUES ('10', '1', '73');
INSERT INTO `dirigeants_theses` (`dirigeant_id`, `these_id`, `taux`) VALUES ('6', '3', '100');
INSERT INTO `dirigeants_theses` (`dirigeant_id`, `these_id`, `taux`) VALUES ('10', '4', '100');
INSERT INTO `dirigeants_theses` (`dirigeant_id`, `these_id`, `taux`) VALUES ('10', '5', '100');
INSERT INTO `dirigeants_theses` (`dirigeant_id`, `these_id`, `taux`) VALUES ('10', '6', '45');
INSERT INTO `dirigeants_theses` (`dirigeant_id`, `these_id`, `taux`) VALUES ('6', '6', '55');

--
-- Creations des encadrants_theses
--
INSERT INTO `encadrants_theses` (`encadrant_id`, `these_id`, `taux`) VALUES ('3', '1', '54');
INSERT INTO `encadrants_theses` (`encadrant_id`, `these_id`, `taux`) VALUES ('4', '1', '46');
INSERT INTO `encadrants_theses` (`encadrant_id`, `these_id`, `taux`) VALUES ('3', '2', '22');
INSERT INTO `encadrants_theses` (`encadrant_id`, `these_id`, `taux`) VALUES ('4', '2', '47');
INSERT INTO `encadrants_theses` (`encadrant_id`, `these_id`, `taux`) VALUES ('6', '2', '31');
INSERT INTO `encadrants_theses` (`encadrant_id`, `these_id`, `taux`) VALUES ('3', '3', '100');
INSERT INTO `encadrants_theses` (`encadrant_id`, `these_id`, `taux`) VALUES ('4', '4', '100');
INSERT INTO `encadrants_theses` (`encadrant_id`, `these_id`, `taux`) VALUES ('6', '5', '75');
INSERT INTO `encadrants_theses` (`encadrant_id`, `these_id`, `taux`) VALUES ('4', '5', '25');
INSERT INTO `encadrants_theses` (`encadrant_id`, `these_id`, `taux`) VALUES ('6', '6', '100');

--
-- Creations des equipes_responsables
--
INSERT INTO `equipes_responsables` (`equipe_id`, `responsable_id`) VALUES ('1', '2');
INSERT INTO `equipes_responsables` (`equipe_id`, `responsable_id`) VALUES ('2', '3');
INSERT INTO `equipes_responsables` (`equipe_id`, `responsable_id`) VALUES ('3', '11');

INSERT INTO `equipes_responsables` (`equipe_id`, `responsable_id`) VALUES ('4', '2');
INSERT INTO `equipes_responsables` (`equipe_id`, `responsable_id`) VALUES ('5', '3');
INSERT INTO `equipes_responsables` (`equipe_id`, `responsable_id`) VALUES ('6', '11');
INSERT INTO `equipes_responsables` (`equipe_id`, `responsable_id`) VALUES ('7', '2');

--
-- Creations des projets
--
INSERT INTO `projets` (`id`, `titre`, `description`, `type`, `budget`, `date_debut`, `date_fin`, `financement_id`) VALUES (1, 'projet1', 'descriptionProjet1', 'type1', '100000', '2016-04-01', '2021-10-16', '1');
INSERT INTO `projets` (`id`, `titre`, `description`, `type`, `budget`, `date_debut`, `date_fin`, `financement_id`) VALUES (2, 'projet2', 'descriptionProjet2', 'type3', '300000', '2017-11-03', '2022-10-16', '2');
INSERT INTO `projets` (`id`, `titre`, `description`, `type`, `budget`, `date_debut`, `date_fin`, `financement_id`) VALUES (3, 'projet3', 'descriptionProjet3', 'type2', '400000', '2017-07-12', '2023-11-21', '3');
INSERT INTO `projets` (`id`, `titre`, `description`, `type`, `budget`, `date_debut`, `date_fin`, `financement_id`) VALUES (4, 'projet4', 'descriptionProjet4', 'type4', '200000', '2016-05-27', '2022-10-16', '4');

--
-- Creations des motifs
--
INSERT INTO `motifs` (`id`, `nom_motif`, `est_dans_liste`) VALUES ('1', 'motif1', '1');
INSERT INTO `motifs` (`id`, `nom_motif`, `est_dans_liste`) VALUES ('2', 'motif2', '1');
INSERT INTO `motifs` (`id`, `nom_motif`, `est_dans_liste`) VALUES ('3', 'motif3', '1');
INSERT INTO `motifs` (`id`, `nom_motif`, `est_dans_liste`) VALUES ('4', 'motif4', '1');
INSERT INTO `motifs` (`id`, `nom_motif`, `est_dans_liste`) VALUES ('5', 'motif5', '1');
INSERT INTO `motifs` (`id`, `nom_motif`, `est_dans_liste`) VALUES ('6', 'motif6', '1');
INSERT INTO `motifs` (`id`, `nom_motif`, `est_dans_liste`) VALUES ('7', 'motif7', '1');
INSERT INTO `motifs` (`id`, `nom_motif`, `est_dans_liste`) VALUES ('8', 'motif8', '1');

--
-- Creations des lieux
--
INSERT INTO `lieus` (`id`, `nom_lieu`, `est_dans_liste`) VALUES ('1', 'Tours', '1');
INSERT INTO `lieus` (`id`, `nom_lieu`, `est_dans_liste`) VALUES ('2', 'Paris', '1');
INSERT INTO `lieus` (`id`, `nom_lieu`, `est_dans_liste`) VALUES ('3', 'Angers', '1');
INSERT INTO `lieus` (`id`, `nom_lieu`, `est_dans_liste`) VALUES ('4', 'Rennes', '1');
INSERT INTO `lieus` (`id`, `nom_lieu`, `est_dans_liste`) VALUES ('5', 'Lille', '1');
INSERT INTO `lieus` (`id`, `nom_lieu`, `est_dans_liste`) VALUES ('6', 'Orleans', '1');
INSERT INTO `lieus` (`id`, `nom_lieu`, `est_dans_liste`) VALUES ('7', 'Bordeaux', '1');
INSERT INTO `lieus` (`id`, `nom_lieu`, `est_dans_liste`) VALUES ('8', 'Londres', '1');
INSERT INTO `lieus` (`id`, `nom_lieu`, `est_dans_liste`) VALUES ('9', 'Berlin', '1');
INSERT INTO `lieus` (`id`, `nom_lieu`, `est_dans_liste`) VALUES ('10', 'BArcelone', '1');

--
-- Creations des missions
--
INSERT INTO `missions` (`id`, `complement_motif`, `date_depart`, `date_retour`, `sans_frais`, `etat`, `nb_nuites`, `nb_repas`, `billet_agence`, `commentaire_transport`, `projet_id`, `lieu_id`, `motif_id`) VALUES 
('1', 'complemntMotif1', '2019-05-01 10:55:13', '2019-05-30 13:10:25', '0', 'soumis', '29', '87', '1', 'vehicule personnel commentaires', '2', '1', '1');
INSERT INTO `missions` (`id`, `complement_motif`, `date_depart`, `date_retour`, `sans_frais`, `etat`, `nb_nuites`, `nb_repas`, `billet_agence`, `commentaire_transport`, `projet_id`, `lieu_id`, `motif_id`) VALUES
('2', 'complemntMotif2', '2017-06-10 11:23:40', '2017-07-07 13:10:25', '1', 'valide', '27', '81', '0', 'vehicule service commentaires', '1', '2', '2');
INSERT INTO `missions` (`id`, `complement_motif`, `date_depart`, `date_retour`, `sans_frais`, `etat`, `nb_nuites`, `nb_repas`, `billet_agence`, `commentaire_transport`, `projet_id`, `lieu_id`, `motif_id`) VALUES
('3', 'complemntMotif3', '2016-11-24 16:50:57', '2016-12-20 13:10:25', '1', 'valide', '26', '78', '0', 'train et avion3', '1', '3', '3');
INSERT INTO `missions` (`id`, `complement_motif`, `date_depart`, `date_retour`, `sans_frais`, `etat`, `nb_nuites`, `nb_repas`, `billet_agence`, `commentaire_transport`, `projet_id`, `lieu_id`, `motif_id`) VALUES
('4', 'complemntMotif4', '2018-04-10 08:01:58', '2018-05-01 13:10:25', '0', 'valide', '21', '63', '1', 'train et avion34', '2', '4', '1');
INSERT INTO `missions` (`id`, `complement_motif`, `date_depart`, `date_retour`, `sans_frais`, `etat`, `nb_nuites`, `nb_repas`, `billet_agence`, `commentaire_transport`, `projet_id`, `lieu_id`, `motif_id`) VALUES
('5', 'complemntMotif5', '2019-03-18 06:25:57', '2019-04-03 13:10:25', '0', 'valide', '16', '48', '0', 'vehicule personnel commentaires', '2', '5', '4');
INSERT INTO `missions` (`id`, `complement_motif`, `date_depart`, `date_retour`, `sans_frais`, `etat`, `nb_nuites`, `nb_repas`, `billet_agence`, `commentaire_transport`, `projet_id`, `lieu_id`, `motif_id`) VALUES
('6', 'complemntMotif6', '2018-07-10 11:28:14', '2018-07-24 13:10:25', '1', 'valide', '14', '42', '1', 'train et avion36', '1', '9', '1');
INSERT INTO `missions` (`id`, `complement_motif`, `date_depart`, `date_retour`, `sans_frais`, `etat`, `nb_nuites`, `nb_repas`, `billet_agence`, `commentaire_transport`, `projet_id`, `lieu_id`, `motif_id`) VALUES
('7', 'complemntMotif7', '2019-10-21 04:35:11', '2019-11-30 13:10:25', '0', 'soumis', '40', '120', '1', 'train et avion37', '2', '10', '2');

--
-- Creations des transports
--
INSERT INTO `transports` (`id`, `type_transport`, `im_vehicule`, `pf_vehicule`) VALUES ('1', 'vehicule_personnel', '01010101', '1');
INSERT INTO `transports` (`id`, `type_transport`, `im_vehicule`, `pf_vehicule`) VALUES ('2', 'vehicule_service', '01010102', '2');
INSERT INTO `transports` (`id`, `type_transport`, `im_vehicule`, `pf_vehicule`) VALUES ('3', 'train', NULL, NULL);
INSERT INTO `transports` (`id`, `type_transport`, `im_vehicule`, `pf_vehicule`) VALUES ('4', 'avion', NULL, NULL);
INSERT INTO `transports` (`id`, `type_transport`, `im_vehicule`, `pf_vehicule`) VALUES ('5', 'vehicule_personnel', '01010105', '3');
INSERT INTO `transports` (`id`, `type_transport`, `im_vehicule`, `pf_vehicule`) VALUES ('6', 'vehicule_service', '01010106', '4');
INSERT INTO `transports` (`id`, `type_transport`, `im_vehicule`, `pf_vehicule`) VALUES ('7', 'vehicule_personnel', '01010107', '5');
INSERT INTO `transports` (`id`, `type_transport`, `im_vehicule`, `pf_vehicule`) VALUES ('8', 'vehicule_service', '01010108', '6');
INSERT INTO `transports` (`id`, `type_transport`, `im_vehicule`, `pf_vehicule`) VALUES ('9', 'vehicule_service', '01010109', '7');
INSERT INTO `transports` (`id`, `type_transport`, `im_vehicule`, `pf_vehicule`) VALUES ('10', 'vehicule_personnel', '01010110', '8');
INSERT INTO `transports` (`id`, `type_transport`, `im_vehicule`, `pf_vehicule`) VALUES ('11', 'vehicule_personnel', '01010111', '9');
INSERT INTO `transports` (`id`, `type_transport`, `im_vehicule`, `pf_vehicule`) VALUES ('12', 'vehicule_service', '01010112', '10');

--
-- Creations des missions_transports
--
INSERT INTO `missions_transports` (`mission_id`, `transport_id`) VALUES ('1', '1');
INSERT INTO `missions_transports` (`mission_id`, `transport_id`) VALUES ('2', '2');
INSERT INTO `missions_transports` (`mission_id`, `transport_id`) VALUES ('3', '3');
INSERT INTO `missions_transports` (`mission_id`, `transport_id`) VALUES ('3', '4');
INSERT INTO `missions_transports` (`mission_id`, `transport_id`) VALUES ('4', '3');
INSERT INTO `missions_transports` (`mission_id`, `transport_id`) VALUES ('4', '4');
INSERT INTO `missions_transports` (`mission_id`, `transport_id`) VALUES ('5', '1');
INSERT INTO `missions_transports` (`mission_id`, `transport_id`) VALUES ('6', '3');
INSERT INTO `missions_transports` (`mission_id`, `transport_id`) VALUES ('7', '3');

--
-- Creations des equipes_projets
--
INSERT INTO `equipes_projets` (`equipe_id`, `projet_id`) VALUES ('1', '2');
INSERT INTO `equipes_projets` (`equipe_id`, `projet_id`) VALUES ('2', '1');
INSERT INTO `equipes_projets` (`equipe_id`, `projet_id`) VALUES ('3', '2');
INSERT INTO `equipes_projets` (`equipe_id`, `projet_id`) VALUES ('4', '3');
INSERT INTO `equipes_projets` (`equipe_id`, `projet_id`) VALUES ('5', '4');
INSERT INTO `equipes_projets` (`equipe_id`, `projet_id`) VALUES ('6', '4');
INSERT INTO `equipes_projets` (`equipe_id`, `projet_id`) VALUES ('7', '3');

--
-- Creations des budgets_annuel
--
INSERT INTO `budgets_annuels` (`projet_id`, `annee`, `budget`) VALUES ('1', '2016', '10000');
INSERT INTO `budgets_annuels` (`projet_id`, `annee`, `budget`) VALUES ('1', '2017', '15000');
INSERT INTO `budgets_annuels` (`projet_id`, `annee`, `budget`) VALUES ('1', '2018', '20000');
INSERT INTO `budgets_annuels` (`projet_id`, `annee`, `budget`) VALUES ('1', '2019', '25000');
INSERT INTO `budgets_annuels` (`projet_id`, `annee`, `budget`) VALUES ('2', '2017', '40000');
INSERT INTO `budgets_annuels` (`projet_id`, `annee`, `budget`) VALUES ('2', '2018', '50000');
INSERT INTO `budgets_annuels` (`projet_id`, `annee`, `budget`) VALUES ('2', '2019', '60000');
INSERT INTO `budgets_annuels` (`projet_id`, `annee`, `budget`) VALUES ('3', '2017', '15000');
INSERT INTO `budgets_annuels` (`projet_id`, `annee`, `budget`) VALUES ('3', '2018', '20000');
INSERT INTO `budgets_annuels` (`projet_id`, `annee`, `budget`) VALUES ('3', '2019', '25000');
INSERT INTO `budgets_annuels` (`projet_id`, `annee`, `budget`) VALUES ('4', '2016', '10000');
INSERT INTO `budgets_annuels` (`projet_id`, `annee`, `budget`) VALUES ('4', '2017', '15000');
INSERT INTO `budgets_annuels` (`projet_id`, `annee`, `budget`) VALUES ('4', '2018', '20000');
INSERT INTO `budgets_annuels` (`projet_id`, `annee`, `budget`) VALUES ('4', '2019', '25000');


COMMIT;