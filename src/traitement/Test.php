<?php
    require '../class/Stock.php';
    require 'BDD.php';

    /******* Connexion BDD MySQL *******/
    $bdd = new BDD();
    $bdd->connect();
    print nl2br("\n");
   
    /******* Matériel informatique******/
    $mat1 = new Materiel("1", "clavier", "Logitech", "D", "");
    $mat2 = new Materiel("2", "souris", "hyperx", "D", "blabla");
    $mat3 = new Materiel("3", "tablette", "samsung", "P", "");
    $mat4 = new Materiel("4", "ordinateur", "acer", "P", "");
    $mat5 = new Materiel("5", "clavier", "razer", "R", "");
    $mat6 = new Materiel("6", "clavier", "razer", "R", "");

    /************* Liste du matos*******/
    $stock = new Stock(); 
    $stock->addMaterielToList($mat1);
    $stock->addMaterielToList($mat2);
    $stock->addMaterielToList($mat3);
    $stock->addMaterielToList($mat4);
    $stock->addMaterielToList($mat5);
    $stock->addMaterielToList($mat6);
    print("Affichage du stock:");
    print nl2br("\n");
    $stock->stockToString();
    
    /************** Prêts***************/
    $pret1 = new Pret($mat1, "16/05/2024", "17/05/2024", "Mairie");
    $prets = new ListPrets();
    $prets->addPretToList($pret1);

    print("Affichage du stock après le prêt:");
    print nl2br("\n");
    $prets->pretsToString();
    $stock->stockToString();


    /****** Aide-Mémoire pour DATE******/
    $debutdate = new DateTime("2024/05/16");
    $findate = new DateTime("2024/05/16");
    if($findate > $debutdate) {
        print("Date correcte");
    }
    else {
        print("Erreur: Dates incorrectes");
    }

    /************************************/
    /***** Test Formulaire de stock *****/
    print nl2br("\n");
    
    $temp1 = $_POST["reference"];
    $temp2 = $_POST["materiel"];
    $temp3 = $_POST["marque"];
    $temp4 = $_POST["etat"];
    $temp5 = $_POST["note"];
    if(!isset($temp1) || !isset($temp2) || !isset($temp3) || !isset($temp4) || !isset($temp5)) {
        print("\n Le formulaire n'est pas rempli");
    }
    else {
        $stock->addMaterielToList(new Materiel($temp1, $temp2, $temp3, $temp4, $temp5));
        print nl2br("\n");
        $stock->stockToString();
    }
    $req = "INSERT INTO stock (ident, materiel, marque, etat, note) VALUES ('$temp1', '$temp2', '$temp3', '$temp4', '$temp5')";
    try {
        $bdd->getPdo()->query($req);
    } catch(Exception $e) {
        die("Erreur: Impossible d'ajouter dans la BDD".$e->getMessage());
    }
    
    /******* FIN DE LA CONNEXION ********/
    print("Fin de la connexion à la base de données");
    print nl2br("\n");
    $mysqlBDD = null;
    


    $temp1 = $_POST['reference']; 
    $temp2 = $_POST["materiel"]; 
    $temp3 = $_POST["marque"];
    $temp4 = $_POST["etat"]; 
    $temp5 = $_POST["note"];
    $result = $bdd->getPdo()->query("INSERT INTO stock (ident, materiel, marque, etat, note) 
                             VALUES ('$temp1', '$temp2', '$temp3', '$temp4', '$temp5')");
    $bdd->getPdo()->query($req);
   
?>