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
    $stock->suppMaterielFromList($mat3);
    
    $prets = new Prets();

    
    
    $stock->stockToString();
    

?>