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
SQL -> base de données
PHP ou JS-> requêtes pour BDD et classes
HTML CSS -> interface front

JOUR 1: 
    Modélisation papier du projet et commencement de la structure HTML globale

JOUR 2: 
    Commencement du CSS et squelette HTML V1 fait

JOUR 3: 
    On continue la structure html et on installe le pack XAMPP, MySQL, Apache, PHP
