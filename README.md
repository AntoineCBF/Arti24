# Arti24

Ce site web a pour but de mettre en relation les artisans et les particuliers en cas d'ugence (Cas de pannes, fuites, etc...)
Personnellement, c'était l'occasion pour moi de prendre en main le langage de programmation back-end PHP ainsi que le langage de requête SQL.

## Requirements
Pour faire tourner ce projet en local, j'ai utilisé une Base de donnée MySQL ainsi qu'un serveur Web (Apache).

Voici la description des différentes sections de ce projet:

## Overview
Pour comprendre le fonctionnement du projet, j'ai établit deux schémas qui sont ma ligne directrice de ce projet. Ils sont disponibles dans la section Annexe mais vous pourrez les retrouver ci-dessus.

### Schéma de l'infrastructure 
Dans ce document, vous retrouverez l'ensemble des pages du site Web qui doivent être affichées. En l'état, elles existent toutes mais il n'y a aucune fiche de style, on retrouve donc uniquement la structure.

![Overview](Annexe/Projet_Arti24.png "Structure du projet")

### Schéma de la BDD
De la même manière pour la base de donnée, le document suivant explique grossièrement la structure de la base de donnée. Il se peut que certains changements aient été effectué en pratique sur la base de donnée mais que le schéma n'ait pas été corrigé. La création de toutes les tables de la BDD se situe dans le fichier [scriptSQL](ScriptSQL/createTable2.sql).

![Overview](Annexe/Bases_De_donnees_Arti24.png "Structure de la BDD")

Ce schéma suit le principe de l'UML, de manière grossière.

## Connexion
Ce répertoire contient les pages concernant l'affichage des formulaires de connexion et d'inscription des artisans et particuliers. 

 + Le fichier **config.php** s'occupe de la connexion à la base de donnée (oui les identifiants sont en clair mais pas de chance pour vous la base tourne en local hehe)
 + Le fichier **connexion.php** traite la demande de connexion, et connecte l'utilisateur si le mot de passe et le nom d'utilisateur correspondent à une entrée de la BDD
 + Le fichier **function.php** contient une floppée de fonctions qui permettent l'affichage et la vérification de différente donnée insérée par l'utilisateur.
 + Le fichier **inscription.php** insère les données relatives à l'inscription d'un utilisateur dans la BDD. C'est un point sensible niveau sécurité.
 + Le fichier **login.php** affiche la page de connexion pour les artisans et particuliers. Une fois n'est pas coutume, les logins sont en clair en commentaire du document pour simplifier la phase de test. 
 + Le fichier **register.php** affiche la page d'inscription des artisans et particuliers.

## Espace Artisan

## Espace Particulier

## Traitement
