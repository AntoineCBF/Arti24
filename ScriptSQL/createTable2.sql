USE arti24;
-- Creation de la table metiers :
DROP TABLE Metier;
CREATE TABLE Metier (
    id_metier INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    metier VARCHAR(20) NOT NULL,
    type_urgence VARCHAR(100) NOT NULL,
    temps INT NOT NULL
);

INSERT INTO Metier(`metier`, `type_urgence`, `temps`) VALUES ("Electricien", "Coupure", 30), ("Electricien", "Radiateur", 60), ("Electricien", "Lumiere", 30), ("Electricien", "Autre", 0), ("Plombier", "Fuite", 30), ("Plombier", "Autre", 60), ("Plombier", "Toilettes", 75), ("Plombier", "Douche", 60), ("Serrurier", "Porte entree", 15), ("Serrurier", "Autre", 60), ("Serrurier", "Portail", 90), ("Serrurier", "Voiture", 60);

-- Creation de la table artisan :
DROP TABLE IF EXISTS `artisans`;
CREATE TABLE `artisans` (
 `id_Artisan` int NOT NULL AUTO_INCREMENT,
 `metier` enum('Plombier','Serrurier','Electricien') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
 `date_creation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
 `nom` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
 `nb_intervention` int NOT NULL DEFAULT '0',
 `abonnement` tinyint(1) NOT NULL,
 `nb_connexion` int NOT NULL DEFAULT '1',
 PRIMARY KEY (`id_Artisan`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ;

-- Creation de la table Banque :
DROP TABLE IF EXISTS `banque`;
CREATE TABLE `banque` (
 `id_banque` int NOT NULL AUTO_INCREMENT,
 `RIB` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
 `id_Artisan` int NOT NULL,
 `portefeuille` float DEFAULT '0',
 PRIMARY KEY (`id_banque`),
 KEY `id_Artisan` (`id_Artisan`),
 CONSTRAINT `banque_ibfk_1` FOREIGN KEY (`id_Artisan`) REFERENCES `artisans` (`id_Artisan`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ;

-- Creation de la table particuliers :
DROP TABLE IF EXISTS `particuliers`;
CREATE TABLE `particuliers` (
 `id_Particulier` int NOT NULL AUTO_INCREMENT,
 `nom` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
 `prenom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
 `date_creation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
 `nb_connexion` int NOT NULL DEFAULT '1',
 PRIMARY KEY (`id_Particulier`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ;

-- Creation de la privilege :
DROP TABLE IF EXISTS `privilege`;
CREATE TABLE `privilege` (
 `id_privilege` int NOT NULL AUTO_INCREMENT,
 `id_Artisan` int DEFAULT NULL,
 `id_Particulier` int DEFAULT NULL,
 `privilege` int NOT NULL,
 PRIMARY KEY (`id_privilege`),
 KEY `fk_id_art` (`id_Artisan`),
 KEY `fk_id_part` (`id_Particulier`),
 CONSTRAINT `fk_id_art` FOREIGN KEY (`id_Artisan`) REFERENCES `artisans` (`id_Artisan`) ON DELETE RESTRICT ON UPDATE RESTRICT,
 CONSTRAINT `fk_id_part` FOREIGN KEY (`id_Particulier`) REFERENCES `particuliers` (`id_Particulier`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ;

-- Creation table type intervention :
DROP TABLE IF EXISTS `typeintervention`;
CREATE TABLE `typeintervention` (
 `id_type_intervention` int NOT NULL AUTO_INCREMENT,
 `type_inter` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
 `perimetre_intervention` int DEFAULT '50',
 `id_Artisan` int NOT NULL,
 PRIMARY KEY (`id_type_intervention`),
 KEY `id_Artisan` (`id_Artisan`),
 CONSTRAINT `typeintervention_ibfk_1` FOREIGN KEY (`id_Artisan`) REFERENCES `artisans` (`id_Artisan`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ;

-- Creation table coordonnees :
DROP TABLE IF EXISTS `coordonnees`;
CREATE TABLE `coordonnees` (
 `id_coordonees` int NOT NULL AUTO_INCREMENT,
 `email` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
 `numeroTel` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
 `adresse` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
 `codePostal` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
 `ville` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
 `id_Artisan` int DEFAULT NULL,
 `id_Particulier` int DEFAULT NULL,
 PRIMARY KEY (`id_coordonees`),
 KEY `id_Artisan` (`id_Artisan`),
 KEY `id_Particulier` (`id_Particulier`),
 CONSTRAINT `coordonnees_ibfk_1` FOREIGN KEY (`id_Artisan`) REFERENCES `artisans` (`id_Artisan`),
 CONSTRAINT `coordonnees_ibfk_2` FOREIGN KEY (`id_Particulier`) REFERENCES `particuliers` (`id_Particulier`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ;


-- Creation table joursemain :
DROP TABLE IF EXISTS `joursemaine`;
CREATE TABLE `joursemaine` (
 `id_jour` int NOT NULL AUTO_INCREMENT,
 `nom_jour` enum('Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
 PRIMARY KEY (`id_jour`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ;


-- Creation table disponibiliteartisan

DROP TABLE IF EXISTS `disponibiliteartisan`;
CREATE TABLE `disponibiliteartisan` (
 `id_disponibilite` int NOT NULL AUTO_INCREMENT,
 `heure_debut` time DEFAULT NULL,
 `heure_fin` time DEFAULT NULL,
 `heure_debut_urgence` time DEFAULT NULL,
 `heure_fin_urgence` time DEFAULT NULL,
 `id_Artisan` int NOT NULL,
 `id_jour` int NOT NULL,
 PRIMARY KEY (`id_disponibilite`,`id_jour`),
 KEY `id_jour` (`id_jour`),
 KEY `id_artisan` (`id_Artisan`),
 CONSTRAINT `disponibiliteartisan_ibfk_1` FOREIGN KEY (`id_jour`) REFERENCES `joursemaine` (`id_jour`),
 CONSTRAINT `disponibiliteartisan_ibfk_2` FOREIGN KEY (`id_Artisan`) REFERENCES `artisans` (`id_Artisan`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ;

-- Creation table motdepasse

DROP TABLE IF EXISTS `motdepasse`;
CREATE TABLE `motdepasse` (
 `id_mdp` int NOT NULL AUTO_INCREMENT,
 `mdp` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
 `id_Artisan` int DEFAULT NULL,
 `id_Particulier` int DEFAULT NULL,
 PRIMARY KEY (`id_mdp`),
 KEY `id_Artisan` (`id_Artisan`),
 KEY `id_Particulier` (`id_Particulier`),
 CONSTRAINT `motdepasse_ibfk_1` FOREIGN KEY (`id_Artisan`) REFERENCES `artisans` (`id_Artisan`),
 CONSTRAINT `motdepasse_ibfk_2` FOREIGN KEY (`id_Particulier`) REFERENCES `particuliers` (`id_Particulier`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ;

-- Creation table intervention

DROP TABLE IF EXISTS `interventions`;
CREATE TABLE `interventions` (
 `id_intervention` int NOT NULL AUTO_INCREMENT,
 `date_debut` time NOT NULL,
 `date_fin` time NOT NULL,
 `date_jour` date NOT NULL,
 `id_Artisan` int DEFAULT NULL,
 `id_Particulier` int DEFAULT NULL,
 `type_intervention` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
 `prix` float DEFAULT NULL,
 PRIMARY KEY (`id_intervention`),
 KEY `id_Artisan` (`id_Artisan`),
 KEY `id_Particulier` (`id_Particulier`),
 CONSTRAINT `interventions_ibfk_1` FOREIGN KEY (`id_Artisan`) REFERENCES `artisans` (`id_Artisan`),
 CONSTRAINT `interventions_ibfk_2` FOREIGN KEY (`id_Particulier`) REFERENCES `particuliers` (`id_Particulier`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ;

-- Creation table avis :
DROP TABLE IF EXISTS `avis`;
CREATE TABLE `avis` (
 `id_avis` int NOT NULL AUTO_INCREMENT,
 `note` int NOT NULL,
 `type_inter` enum('Coupure','Fuite','Douche','Toilettes','Serrure') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
 `commentaire` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
 `date_inter` date DEFAULT NULL,
 `id_intervention` int DEFAULT NULL,
 PRIMARY KEY (`id_avis`),
 KEY `fk_avis_intervention` (`id_intervention`),
 CONSTRAINT `fk_avis_intervention` FOREIGN KEY (`id_intervention`) REFERENCES `interventions` (`id_intervention`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ;
