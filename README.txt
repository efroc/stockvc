/*************************EXPLICATION DE L4APPLICATION***********************/
 - C'EST QUOI ?
    C'est un outil de gestion du matériel informatique en stock et en prêt.

- COMMENT ON L'UTILISE ?
    Il sufit d'ouvrir la page index.php, et le reste se fait tout seul.
    Un guide d'utilisation est présent sur le site pour se faire la main 
    dessus.

/*******************************EXPLICATION DU CODE*************************/
Architecture de projet :
STOCKVC 
-index.php
-README.txt
-images
    -toutes les images
-page
    -css
        -index.css
    -redirection.php
-src
    -traitement
        -BDD.php

Le fichier index.php contient la quasi-totalité du code de l'application. 
Celui-ci appelle index.css pour la mise en forme, BDD.php pour la gestion 
de la connexion à la Base de Données, et à redirection.php pour l'actualisation 
de la page quand c'est nécessaire.

Le dossier images contient toutes les images disponibles sur le logiciel.

Architecture du code d'index.php :

<html>
<head>
    Le head contient le titre de l'application, le lien vers index.css, et 
    le logo de la page.
<head>
<body>
    <div class="head">
        Ici on trouve les plusieurs logos et le titre en haut de page.

    <ul class="menu">
        Tandis qu'ici on trouve le menu principal de navigation dont
        l'onglet Stock, Prêts, Historique, Utilisation et Connexion.
        Lorsqu'on clique sur un onglet, on initialise la variable menu
        à 1, 2, 3, 4 ou 5.
    
    <div class="contenu">
        C'est ici que la reste du code est mis en place. 

        <?php
            if(isset($_GET['menu'])) switch($_GET['menu']) {
                case 1:
        ?>  
            Ici on navigue dans l'onglet Stock
        <?php
                break; 
                case 2:
        ?>
            Ici on navigue dans l'onglet Prêt
        <?php
                break;
                case 3:
        ?>
            Ici on navigue dans l'onglet Historique
        <?php
                break; 
                case 4:
        ?>
            Ici on navigue dans l'onglet Utilisation
        <?php
                break;
                case 5:
        ?>
            Ici on navigue dans l'onglet Se Connecter
        <?php
                break;
            }
        ?>
<body>

On retrouve ci-dessus l'architecture principale du code dans index.php.
D'autres explications sont notées régulièrement dans le code en commentaires.
