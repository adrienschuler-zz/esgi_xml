Projet XML - 5PPA AL
================================

## Liste des fonctionnalités implémentées :

* Inscription
* Connexion
* Création des livres 
* Création des chapitres
* Consultation des livres (introduction, chapitres, requête XPATH)
* Exporter un livre au format TXT
* Supprimer un livre
* Supprimer un chapitre

## L’interface d’administration se présente comme suit :

Tableau contenant la liste des livres créés avec :

* Titre
* Auteur
* Date de création
* Date de modification
* Statut indiquant si des chapitres restes à créer (chapitres référencés mais non créés)
* Actions : Consulter, modifier, exporter, supprimer

## Interface de consultation des livres :

Formulaire permettant de spécifier ce que l’on veut consulter :
Introduction
Chapitre (Liste déroulantes pré-rempli avec les chapitres disponibles)
Vue globale du fichier XML, avec possibilité de téléchargement (format TXT)

Interface de modification des livres :
Lien pour modifier l’introduction
Lien pour ajouter un chapitre
Un tableau contenant la liste des chapitres créés avec :
Numéro du chapitre
Date de création
Date de modification
Action : Consulter, modifier, supprimer
Tableau contenant la liste des numéros de chapitres restant à créer (Car référencés dans le jeu)
Numéro du chapitre
Bouton créer

## Outils utilisés :

### PHP
### SimpleXML/XPATH : Création des livres, utilisateurs, fonctions de recherche, Consultation, suppression
### HTML/CSS/JavaScript
### Format XML
#### Livres
#### Module de gestion des droits
### Versionning
* Git + Github

Plus:

* http://jquery.com/
* http://twitter.github.com/bootstrap/
* http://lesscss.org/
* http://www.google.com/webfonts
* http://code.google.com/p/google-code-prettify/
