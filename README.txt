########## Programme pour gérer les matériels informatiques en stock et en prêt ##########

*Besoin d'une interface STOCK qui représente la liste de tout le matériel
disponible en stock (PC, clavier, écran, etc..)

*Besoin d'une interface PRET qui effectue une demande de prêt, et retire
du stock le matériel prêté jusqu'à la date de fin de prêt

*Besoin d'un onglet ALERTE qui préviendra quand le stock est bas ou 
que le matériel prêté n'est pas rendu

***MATERIEL***
Un matériel c'est : 
- type : tour, clavier, écran, etc
- marque : acer, asus, etc
- référence/numéro/ident
- état : dispo/prêté/réparation/ etc

***STOCK***
List[MATERIEL] affichée en onglet stock

Actions: 
- Ajouter/retirer/modifier un objet du stock

***PRET***

Actions:
- Effectuer/modifier un prêt
- Confirmer la fin du prêt (ALERTE si dépassement de la date)

***ALERTE***

Actions:
- Envoie une alerte si dépassement de date
- Envoie une alerte si trop peu de matériel disponible

#####Langages#####
MySQL -> base de données
PHP -> requêtes pour BDD et classes
HTML,CSS -> interface front

#####Accès Serveur Apache#####
-> localhost/MyProject/stockvc/
-> s.info/Programmes/htdocs/MyProject/stockvc/

JOUR 1: 
    Modélisation papier du projet et commencement de la structure HTML globale

JOUR 2: 
    Commencement du CSS et squelette HTML V1 fait

JOUR 3: 
    On continue la structure html et on installe le pack XAMPP, MySQL, Apache, PHP

JOUR 4: 
    Installer le pack XAMPP, MySQL, Apache, PHP en administrateur
    Pack installé, début de tests des classes PHP

JOUR 5:
    Prise en main de MySQL et de phpMyAdmin, succès de la connexion à une base depuis 
    une page php, et affichage des informations de la table.

JOUR 6, 7 et 8: 
    Création de requête MySQL pour ajouter, supprimer et afficher données de la BDD

JOUR 9: 
    Mise en forme d'une page HTML plus propre et plus lisible pour accueillir 
    l'application. La page de stock fonctionne bien, Ajout, suppression, trie.
    
A FAIRE !!!!!!!!!!!!!!!!!!
    MODIFICATION DE STOCK : ne marche pas


