<?php
    require '../class/Stock.php';
    require '../class/Prets.php';
    require '../class/Alertes.php';

    /** Matériel informatique
     */
    $mat1 = new Materiel("1", "clavier", "Logitech", "D", "");
    $mat2 = new Materiel("2", "souris", "hyperx", "D", "blabla");
    $mat3 = new Materiel("3", "tablette", "samsung", "P", "");
    $mat4 = new Materiel("4", "ordinateur", "acer", "P", "");
    $mat5 = new Materiel("5", "clavier", "razer", "R", "");
    $mat6 = new Materiel("6", "clavier", "razer", "R", "");

    /** Liste du matos
     */
    $stock = new Stock(); 
    $stock->addMaterielToList($mat1);
    $stock->addMaterielToList($mat2);
    $stock->addMaterielToList($mat3);
    $stock->addMaterielToList($mat4);
    $stock->addMaterielToList($mat5);
    $stock->addMaterielToList($mat6);
    $stock->stockToString();
    
    /** Prêts
     */
    $pret1 = new Pret($mat1, "16/05/2024", "17/05/2024", "Mairie");
    $prets = new Prets();
    $prets->addPretToList($pret1);

    $prets->pretsToString();
    $stock->stockToString();


    /** Aide-Mémoire pour DATE**/
    $debutdate = new DateTime("2024/05/16");
    $findate = new DateTime("2024/05/16");
    if($findate > $debutdate) {
        print("Date correcte");
    }
    else {
        print("Erreur: Dates incorrectes");
    }
    /***************************/
?>