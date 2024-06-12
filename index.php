<!DOCTYPE html>
<html lang="fr">
<!----------------------------------------------------- HEAD PAGE ------------------------------------------------------------->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <link href="page/css/index.css" rel="stylesheet"/>
    <title>Stock Informatique Vitré Communauté</title>
    <link rel="website icon" type="png" href="images/VClogo.png"/>
</head>

<!----------------------------------------------------- BODY PAGE ------------------------------------------------------------->
<body>
<!--------------------------------------------------- CONNEXION BDD ----------------------------------------------------------->
<?php
    require 'src/traitement/BDD.php';
    /***** Création de la connexion *****/ 
    $bdd = new BDD();
    $connexion = $bdd->connect();
    /***** Date locale *****/
    $localdate = date('Y-m-d');
    /***** Dates pour requetes *****/
    $dateYear = date('Y-m-d', strtotime("-1 Year"));
    $dateMonth = date("Y-m-d", strtotime("-1 Month"));
    $dateWeek = date("Y-m-d", strtotime("-1 Week"));
    $dateDay = date("Y-m-d", strtotime("-1 Day"));
    /***** Alertes *****/
    $requete = "SELECT ident FROM pret WHERE alerte < '{$localdate}'";
    $resAlerte = $bdd->getPdo()->query($requete);
    $tabAlerte = array();
    foreach($resAlerte as $res) { 
        array_push($tabAlerte, $res['ident']);
    } 
?>

<!------------------------------------------------------- MENU ---------------------------------------------------------------->
    <div class="head">
        <a class="redirection-left" target="_blank" href="https://www.vitrecommunaute.org/">
            <img class="DSIlogo" src="images/DSIlogo.png" alt="logo" height="59px"><img src="images/VClogo.png" alt="logo" height="59px">
        </a>
        <p class="title">Gestion du stock et des prêts</p>
        <a class="redirection-right" target="_blank" href="https://www.mairie-vitre.com/"><img src="images/mairielogo.png" alt="logo" height="59px"></a>
    </div>
    <ul class="menu">
        <li><a href="index.php?menu=1"><p class="menu-text">Stock</p></a></li>
        <li><a href="index.php?menu=2"><p class=<?php if(count($tabAlerte) > 0) {echo("menu-text-alerte");} else { echo("menu-text"); }?>>Prêts et Alertes</p></a></li>
        <li><a href="index.php?menu=3"><p class="menu-text">Historique</p></a></li>
        <li style="float:right"><a class="login" href="index.php?menu=5"><p class="menu-text">Se connecter</p></a></li> 
        <li style="float:right"><a href="index.php?menu=4"><p class="menu-text">Utilisation</p></a></li>
    </ul>

<!------------------------------------------------AFFICHE INFOS CONNEXION------------------------------------------------------>    
<?php 
    echo $connexion; echo("Date du jour : " .$localdate);
?>

<!----------------------------------------------- AFFICHAGE SELON MENU -------------------------------------------------------->
<!--CASE 1: STOCK-----CASE 2: PRET-----CASE 3: HISTORIQUE-----CASE 4: LOGIN---------------------------------------------------->
    <div class="contenu">
        <?php
            if(isset($_GET['menu'])) switch($_GET['menu']) {
                case 1:       
        ?>            
<!------------------------------------------------------------------------------------------------------------------------------
--------------------------------------------------------------------------------------------------------------------------------
-------------------------------------------------------CASE 1 STOCK-------------------------------------------------------------
--------------------------------------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------------->
        
        <div class="stock">
<!-------------------------------------- TRAITEMENT DE TOUTES LES ACTIONS DE STOCK -------------------------------------------->
            <?php
                $tri ="";
                $rebut=false;
                /***** Ajout au stock *****/
                if(isset($_POST['submit-stock'])) {
                    $ref = $_POST['reference']; $mat = strtolower($_POST['materiel']); $marque = strtolower($_POST['marque']);
                    $etat = strtolower($_POST['etat']); $note = strtolower($_POST['note']); $proprietaire = $_POST['proprietaire'];
                    $num = $_POST['number'];

                    $requete = "INSERT INTO stock (reference, materiel, marque, etat, note, proprietaire) 
                                VALUES ('{$ref}', '{$mat}', '{$marque}', '{$etat}', '{$note}', '{$proprietaire}')";
                    $success = $_POST['number'];

                    for($i = 0; $i < $_POST['number']; $i++) {
                        if($bdd->getPdo()->query($requete) === false) {
                            echo("Ajout dans le stock échoué");
                            $success-=1;
                        } 
                    }
                    $historeq = "INSERT INTO historique (date, action, reference, materiel, marque, etat, proprietaire, nombre, note, start, end) 
                                VALUES ('{$localdate}', 'Ajout au stock', '{$_POST['reference']}', '{$mat}', '{$marque}', '{$etat}', '{$proprietaire}', '{$num}', '{$note}', 'NULL', 'NULL')";
                    try {
                        $bdd->query($historeq);  
                    } catch(Exception $e) {
                        die("Impossible d'ajouter à l'historique : ".$e->getMessage());
                    } 
                    header('Location: page/redirection.php');
                }
                /***** Modifier du stock *****/
                if(isset($_POST["confirm-edit"])) {
                    if($_POST['etat-edit'] === 'rebut') {
                        try {
                            $bdd->getPdo()->query("DELETE FROM stock WHERE ident = {$_POST['id-edit']}");
                            try {
                                $bdd->getPdo()->query("INSERT INTO historique (date, action, reference, materiel, marque, etat, proprietaire, nombre, note) 
                                VALUES ('{$localdate}', 'Rebut', '{$_POST['ref-edit']}', '{$_POST['mat-edit']}', '{$_POST['marque-edit']}', 'rebut', 
                                '{$_POST['propriétaire-edit']}', 1, '{$_POST['note-edit']}')");
                            } catch (Exception $e) {
                                die("Impossible d'ajouter à l'historique : ".$e->getMessage());
                            }
                        } catch(Exception $e) {
                            die("Impossible de supprimer du stock : ".$e->getMessage());
                        }
                    } else {
                        $req = "UPDATE stock SET materiel = '{$_POST['mat-edit']}', marque = '{$_POST['marque-edit']}', 
                                etat = '{$_POST['etat-edit']}', note = '{$_POST['note-edit']}', proprietaire = '{$_POST['proprietaire-edit']}' WHERE ident = '{$_POST['id-edit']}'";
                        $historeq = "INSERT INTO historique (date, action, reference, materiel, marque, etat, proprietaire, nombre, note) 
                                VALUES ('{$localdate}', 'Modification du stock', '{$_POST['ref-edit']}', '{$_POST['mat-edit']}', '{$_POST['marque-edit']}', 
                                '{$_POST['etat-edit']}', '{$_POST['propriétaire-edit']}', 1, '{$_POST['note-edit']}')";
                        try {
                            $bdd->getPDO()->query($req);
                            try {
                                $bdd->getPdo()->query($historeq);
                            } catch(PDOException $e) {
                                die("Impossible d'ajouter à l'historique : ".$e->getMessage());
                            }
                        } catch(Exception $e) {
                            die("Erreur: Impossible de modifier la BDD".$e->getMessage());
                        }
                    }
                    header('Location: page/redirection.php'); 
                }
                /***** Retrait du stock *****/
                if((isset($_POST['confirm-supp']) && ($_POST['etat-supp'] !== 'déjà prêté')) || $rebut === true) {
                    $ref = $_POST['ref-supp']; $mat = strtolower($_POST['mat-supp']); $marque = strtolower($_POST['marque-supp']); $num = $_POST['number-supp'];
                    $etat = strtolower($_POST['etat-supp']); $note = strtolower($_POST['note-supp']); $proprietaire = $_POST['proprietaire-supp'];
                    $requete = "SELECT ident FROM stock WHERE reference = '{$_POST['ref-supp']}' AND materiel = '{$_POST['mat-supp']}' AND 
                                marque = '{$_POST['marque-supp']}' AND etat = '{$_POST['etat-supp']}' AND note = '{$_POST['note-supp']}' AND 
                                proprietaire = '{$_POST['proprietaire-supp']}' LIMIT {$_POST['number-supp']}";
                    $success = 0;
                    try {
                        $result = $bdd->getPDO()->query($requete);
                        foreach($result as $res) {
                            try {
                                $bdd->getPdo()->query("DELETE FROM stock WHERE ident = {$res['ident']} ");
                                $success+=1;
                            } catch(Exception $e) {
                                die("Impossible de supprimer du stock : ".$e->getMessage());
                            }
                        }
                    } catch(Exception $e) {
                        die("".$e->getMessage());
                    }
                    $historeq = "INSERT INTO historique (date, action, reference, materiel, marque, etat, proprietaire, nombre, note) 
                                VALUES ('{$localdate}', 'Rebut', '{$ref}', '{$mat}', '{$marque}', 'Rebut', '{$proprietaire}', '{$num}', '{$note}')";
                    try {
                        $bdd->getPdo()->query($historeq);
                    } catch(Exception $e) {
                        die("Impossible d'ajouter à l'historique : ".$e->getMessage());
                    }
                    header('Location: page/redirection.php'); 
                }
                /***** BOUTONS DE TRI *****/
                if(isset($_POST['submit-reference'])) {
                    $tri = ' ORDER BY reference';
                }
                if(isset($_POST['submit-materiel'])) {
                    $tri = ' ORDER BY materiel';
                }
                if(isset($_POST['submit-nb'])) {
                    $tri = ' ORDER BY number';
                }
                if(isset($_POST['submit-etat'])) {
                    $tri = ' ORDER BY etat';
                } 
                if(isset($_POST['submit-marque'])) {
                    $tri = ' ORDER BY marque';
                }
                if(isset($_POST['submit-note'])) {
                    $tri = ' ORDER BY note DESC';
                }
                if(isset($_POST['submit-proprietaire'])) {
                    $tri = ' ORDER BY proprietaire';
                }

            ?>
            <div class="stock-action">
<!----------------------------------------------FORMULAIRE EDITION DE STOCK---------------------------------------------------->
                <?php
                    if(isset($_POST["submit-edit"])) {
                ?>
                    <h3 class="action-clignote">Modification du stock</h3>
                    <div class="modif-stock">
                        <form class="modif" action="index.php?menu=1" method="POST"><br/>
                            <input type="hidden" value="<?php echo $_POST['id']; ?>" name="id-edit"/>
                            <label for="ref">*Référence</label>
                            <input type="text" id="ref-edit" maxlength="30" name="ref-edit" value="<?php echo $_POST['ref']; ?>" required <?php if($_POST['etat']!=='disponible') echo("readonly");?>><br/>
                            <label for="mat">*Matériel</label> 
                            <input type="text" id="mat-edit" maxlength="30" name="mat-edit" value="<?php echo $_POST['materiel']; ?>" required placeholder=""/><br/>
                            <label for="marque">Marque</label><br/>
                            <input type="text" id="marque-edit" maxlength="30" name="marque-edit" value="<?php echo $_POST['marque']; ?>" placeholder=""/>
                            <br/>
                            <label for="etat">*Etat</label><br/>
                            <?php
                                if($_POST['etat'] !== "déjà prêté") {
                            ?>
                            <input type="radio" id="etat-edit" name="etat-edit" value="disponible" checked/>Disponible
                            <input type="radio" id="etat-edit" name="etat-edit" value="affecté"/>Affecté<br/>
                            <input type="radio" id="etat-edit" name="etat-edit" value="en réparation"/>En réparation
                            <input type="radio" id="etat-edit" name="etat-edit" value="rebut"/>Rebut<br/>
                            <?php
                                } else {
                            ?>
                            <input type="radio" id="etat-edit" name="etat-edit" value="déjà prêté" checked/>Prêté<br/>
                            <?php
                                }
                            ?>
                            <label for="note">Note</label><br/> 
                            <input type="text" id="note-edit" maxlength="150" name="note-edit" value="<?php echo $_POST['note']; ?>"/><br/>
                            <label for="proprietaire">Propriétaire</label><br/> 
                            <select name="proprietaire-edit" id="proprietaire-edit" required>
                                <option <?php if($_POST['proprietaire'] === 'Vitré Communauté') echo("selected=\"selected\""); ?> value="Vitré Communauté">Vitré Communauté</option>
                                <option <?php if($_POST['proprietaire'] === 'Mairie') echo("selected=\"selected\""); ?> value="Mairie">Mairie</option>
                            </select>
                            <button type="submit" name="confirm-edit" title="Confirmer">Confirmer</button>
                        </form>
                        <form action="index.php?menu=1" method="POST">
                            <button type="submit" name="cancel-edit" title="Annuler">Annuler</button>
                        </form>
                    </div>
<!---------------------------------------------FORMULAIRE SUPPRESSION DE STOCK------------------------------------------------->
                <?php
                    } else if(isset($_POST["submit-supp"]) && $_POST['etat'] !== "déjà prêté") {
                ?>
                    <h3 class="action-clignote">Suppression du stock</h3>
                    <div class="supp-stock">
                        <form class="supp" action="index.php?menu=1" method="POST"><br/>
                            <label for="ref">Référence</label><br/>
                            <input type="text" id="ref-supp" maxlength="30" name="ref-supp" value="<?php echo $_POST['reference']; ?>" required readonly><br/>
                            <label for="mat">Matériel</label><br/> 
                            <input type="text" id="mat-supp" maxlength="30" name="mat-supp" value="<?php echo $_POST['materiel']; ?>" required readonly/><br/>
                            <label for="marque">Marque</label><br/>
                            <input type="text" id="marque-supp" maxlength="30" name="marque-supp" value="<?php echo $_POST['marque']; ?>" readonly/><br/>
                            <label for="nombre">Nombre à supprimer</label><br/>
                            <input type="number" id="number-supp" name="number-supp" min="1" max="<?php echo $_POST['number'];?>" value="1"/><br/>
                            <label for="etat">Etat</label><br/>
                            <input type="text" id="etat-supp" name="etat-supp" value="<?php echo $_POST['etat'];?>" readonly/><br/>
                            <label for="note">Note</label><br/> 
                            <input type="text" id="note-supp" maxlength="150" name="note-supp" value="<?php echo $_POST['note']; ?>" readonly/><br/>
                            <label for="proprietaire">Propriétaire</label><br/>
                            <input type="text" id="proprietaire-supp" name="proprietaire-supp" value="<?php echo $_POST['proprietaire'];?>" readonly/><br/>
                            <button type="submit" name="confirm-supp" title="Confirmer">Confirmer</button>
                        </form>
                        <form action="index.php?menu=1" method="POST">
                            <button type="submit" name="cancel-supp" title="Annuler">Annuler</button>
                        </form>
                    </div>
<!-------------------------------------------- FORMULAIRE AJOUTER AU STOCK ---------------------------------------------------->
                <?php
                    } else {
                ?>
                <h3 class="action-clignote">Ajouter en stock</h3>
                <form action="index.php?menu=1" method="POST">
                    <ul class="stock-form">
                        <li>
                            <label for="reference">*Référence</label><br/>
                            <input type="text" id="reference" maxlength="30" name="reference" value="<?php if(isset($_POST['submit-add-stock'])) echo($_POST['ref']); ?>" required placeholder="Ex: N° de série"/>
                        </li>
                        <li>
                            <label for="materiel">*Matériel</label><br/>
                            <input type="text" id="materiel" name="materiel" maxlength="30" value="<?php if(isset($_POST['submit-add-stock'])) echo($_POST['mat']); ?>" required placeholder="Ex: clavier"/>
                        </li>
                        <li>
                            <label for="marque">Marque</label><br/>
                            <input type="text" id="marque" name="marque" maxlength="30" value="<?php if(isset($_POST['submit-add-stock'])) echo($_POST['marque']); ?>" placeholder="Ex: logitech"/>
                        </li>
                        <li>
                            <label for="nombre">Nombre à ajouter</label><br/>
                            <input type="number" id="number" name="number" min="1" max="50" value="1" placeholder="Max:50"/>
                        </li>
                        <li>
                            <label for="etat">*Etat</label><br/>
                            <input type="radio" id="etat" name="etat" value="disponible" checked/>Disponible
                            <!--<input type="radio" id="etat" name="etat" value="déjà prêté"/>Prêté-->
                            <input type="radio" id="etat" name="etat" value="affecté"/>Affecté<br/>
                            <input type="radio" id="etat" name="etat" value="en réparation"/>En réparation
                            <input type="radio" id="etat" name="etat" value="rebut"/>Rebut
                        </li>
                        <li>
                            <label for="note">Note</label><br/>
                            <input type="text" id="note" name="note" maxlength="150" value="<?php if(isset($_POST['submit-add-stock'])) echo($_POST['note']); ?>" placeholder="Facultatif"/>
                        </li>
                        <li>
                            <label for="proprietaire">*Propriétaire</label><br/>
                            <select name="proprietaire" id="proprietaire" required>
                                <option <?php if(isset($_POST['submit-add-stock'])) { 
                                                if($_POST['proprietaire'] === 'Vitré Communauté') echo("selected=\"selected\"");
                                              } ?> value="Vitré Communauté">Vitré Communauté
                                </option>
                                <option <?php if(isset($_POST['submit-add-stock'])) { 
                                                if($_POST['proprietaire'] === 'Mairie') echo("selected=\"selected\"");
                                              } ?> value="Mairie">Mairie
                                </option>
                            </select>
                        </li>
                        <li>
                            <button type="submit" name="submit-stock">Ajouter au stock</button>
                        </li>
                    </ul>
                </form>
                <?php
                    }
                ?>  
            </div>

<!---------------------------------------------- AFFICHAGE DU STOCK ----------------------------------------------------------->
            <div class="stock-list">
            <h3>Tout le stock</h3>
            <table>
                <tr class="stock-table">
                    <th class="ref">
                        <form action="index.php?menu=1" method="POST">
                            <button type="submit" name="submit-reference" title="Trier par référence">Référence</button>
                        </form>
                    </th>
                    <th class="mat">
                        <form action="index.php?menu=1" method="POST">
                            <button type="submit" name="submit-materiel" title="Trier par matériel">Matériel</button>
                        </form>
                    </th>
                    <th class="nb">
                        <form action="index.php?menu=1" method="POST">
                            <button type="submit" name="submit-nb" title="Trier par nombre">Nombre</button>
                        </form>
                    </th>
                    <th class="marque">
                        <form action="index.php?menu=1" method="POST">
                            <button type="submit" name="submit-marque" title="Trier par marque">Marque</button>
                        </form>
                    </th>
                    <th class="etat">
                        <form action="index.php?menu=1" method="POST">
                            <button type="submit" name="submit-etat" title="Trier par état">Etat</button>
                        </form>
                    </th>
                    <th class="note">
                        <form action="index.php?menu=1" method="POST">
                            <button type="submit" name="submit-note" title="Trier par note">Note</button>
                        </form>
                    </th>
                    <th class="proprietaire">
                        <form action="index.php?menu=1" method="POST">
                            <button type="submit" name="submit-proprietaire" title="Trier par propriétaire">Propriétaire</button>
                        </form>
                    </th>
                    <th class="button"></th>
                    <th class="button"></th>
                    <th class="button"></th>
                </tr>
                <?php 
                    $result = $bdd->getPdo()->query('SELECT *, COUNT(*) as number FROM stock GROUP BY reference, materiel, marque, etat, note, proprietaire'.$tri);
                    foreach($result as $res) {
                        $id = $res['ident']; $ref = $res['reference']; $mat = $res['materiel']; $marque = $res['marque']; 
                        $etat = $res['etat']; $note = $res['note']; $num = $res['number'];; $proprietaire = $res['proprietaire'];
                ?>  
                <tr class="stock-table">     
                    <td class="ref"><?php print $res['reference']; ?></td>
                    <td><?php print $res['materiel']; ?></td>
                    <td><?php print $res['number']; ?>
                        <form action="index.php?menu=1" method="POST">
                            <button type="submit" name="submit-add-stock" title="Ajouter du stock">
                            <input type="hidden" value="<?php echo $ref ?>" name="ref"/>
                            <input type="hidden" value="<?php echo $mat ?>" name="mat"/>
                            <input type="hidden" value="<?php echo $marque; ?>" name="marque"/>
                            <input type="hidden" value="<?php echo $note ?>" name="note"/>
                            <input type="hidden" value="<?php echo $proprietaire ?>" name="proprietaire"/>
                            <img src="images/ajouter.png" alt="ajouter" height="10px" width="10px">
                            </button>
                        </form>
                    </td>
                    <td><?php print $res['marque']; ?></td>
                    <td><?php print $res['etat']; ?></td>
                    <td><?php print $res['note']; ?></td>
                    <td><?php print $res['proprietaire']; ?></td>
                    <td class="button">
                        <form action="<?php if($etat !== 'disponible') { echo("index.php?menu=1"); } else { echo("index.php?menu=2"); }?>" method="POST">
                            <button type="submit" name="submit-add" title="Ajouter aux prêts">
                            <input type="hidden" value="<?php echo $ref ?>" name="ref"/>
                            <input type="hidden" value="<?php echo $mat ?>" name="mat"/>
                            <input type="hidden" value="<?php echo $marque ?>" name="marque"/>
                            <input type="hidden" value="<?php echo $note ?>" name="note"/>
                            <input type="hidden" value="<?php echo $proprietaire ?>" name="proprietaire"/>
                            <input type="hidden" value="<?php echo $num ?>" name="number"/>
                            <img src="images/ajouter.png" alt="ajouter" height="20px">
                            </button>
                        </form>
                    </td>
                    <td class="button">
                        <form action="index.php?menu=1" method="POST">
                            <button type="submit" name="submit-edit" title="Modifier">
                            <input type="hidden" value="<?php echo $id; ?>" name="id"/>
                            <input type="hidden" value="<?php echo $ref; ?>" name="ref"/>
                            <input type="hidden" value="<?php echo $mat; ?>" name="materiel"/>
                            <input type="hidden" value="<?php echo $marque; ?>" name="marque"/>
                            <input type="hidden" value="<?php echo $etat; ?>" name="etat"/>
                            <input type="hidden" value="<?php echo $note; ?>" name="note"/>
                            <input type="hidden" value="<?php echo $proprietaire ?>" name="proprietaire"/>
                            <img src="images/modifier.png" alt="modifier" height="20px">
                        </form>
                    </td>
                    <td class="button">
                        <form action="index.php?menu=1" method="POST">
                            <button type="submit" name="submit-supp" title="Supprimer">
                            <input type="hidden" value="<?php echo $ref; ?>" name="reference"/>
                            <input type="hidden" value="<?php echo $marque; ?>" name="marque"/>
                            <input type="hidden" value="<?php echo $mat; ?>" name="materiel"/>
                            <input type="hidden" value="<?php echo $etat; ?>" name="etat"/>
                            <input type="hidden" value="<?php echo $num ?>" name="number"/>
                            <input type="hidden" value="<?php echo $note; ?>" name="note"/>
                            <input type="hidden" value="<?php echo $proprietaire ?>" name="proprietaire"/>
                            <img src="images/basket.png" alt="supprimer" height="20px">
                            </button>
                        </form>
                    </td>
                </tr>
                <?php
                    }
                ?>
            </table>   
            </div>
        </div>
<!------------------------------------------------------------------------------------------------------------------------------        
--------------------------------------------------------------------------------------------------------------------------------       
----------------------------------------------------- CASE 2 : PRET ------------------------------------------------------------       
--------------------------------------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------------->       
        <?php            
                break;
                case 2:
        ?>
        <div class="pret">
<!--------------------------------------TRAITEMENT DE TOUTES LES ACTIONS DE PRET----------------------------------------------->
            <?php
                /***** Ajouter aux prêts *****/
                if(isset($_POST['submit-pret'])) {
                    if($_POST['start'] <= $_POST['end'] && $_POST['alerte'] <= $_POST['end'] && $_POST['alerte'] >= $_POST['start'] ) {
                        $requete = "SELECT * FROM stock WHERE reference = '{$_POST['ref']}' AND materiel = '{$_POST['mat']}' 
                            AND marque = '{$_POST['marque']}' AND etat = 'disponible' AND note = '{$_POST['note']}'  LIMIT {$_POST['number']}";
                        $success = 0;
                        try {
                            $result = $bdd->getPdo()->query($requete);
                            foreach($result as $res) {
                                $requete = "INSERT INTO pret (ident, reference, start, end, client, alerte) 
                                            VALUES ('{$res['ident']}', '{$res['reference']}', '{$_POST['start']}', '{$_POST['end']}', '{$_POST['client']}', '{$_POST['alerte']}')";
                                $updatereq = "UPDATE stock SET etat = 'déjà prêté' WHERE ident = '{$res['ident']}'";
                                $bdd->getPdo()->query($requete);
                                $success+=1;
                                try {
                                    $bdd->getPdo()->query($updatereq);
                                } catch (Exception $e) {
                                    die("Impossible d'actualiser le stock : ".$e->getMessage());
                                }
                            }
                        } catch(Exception $e) {
                            die("Impossible d'ajouter aux prêts : ".$e->getMessage());
                        }
                        $historeq = "INSERT INTO historique (date, action, reference, materiel, marque, etat, proprietaire, nombre, note, client, start, end) 
                                    VALUES ('{$localdate}', 'Ajout aux prêts', '{$res['reference']}', '{$_POST['mat']}', '{$_POST['marque']}', 'déjà prêté', '{$res['proprietaire']}',
                                    '{$success}', '{$_POST['note']}', '{$_POST['client']}', '{$_POST['start']}', '{$_POST['end']}')";
                        try {
                            $bdd->getPdo()->query($historeq);
                        } catch(Exception $e) {
                            die("Impossible d'ajouter à l'historique : ". $e->getMessage());
                        }
                    }                                                                                                       
                    header('Location: page/redirection.php');  
                }
                /***** Modifier un prêt *****/
                if(isset($_POST['confirm-edit'])) {
                    if($_POST['start'] < $_POST['end']) {
                        $requete = "UPDATE pret SET start = '{$_POST['start']}', end = '{$_POST['end']}', 
                        client = '{$_POST['client']}', alerte = '{$_POST['alerte']}' WHERE ident = '{$_POST['id-edit']}'";
                        try {
                            $historeq = "INSERT INTO historique (date, action, reference, materiel, client, start, end) 
                                        VALUES ('{$localdate}', 'Modification de prêt', '{$_POST['ref-edit']}', '{$_POST['mat-edit']}', '{$_POST['client']}', '{$_POST['start']}', '{$_POST['end']}')";
                            $bdd->getPdo()->query($requete);
                            try {
                                $bdd->getPdo()->query($historeq);
                            } catch(Exception $e) {
                                die("Impossible d'ajouter dans l'historique : ".$e->getMessage());
                            }
                        } catch (Exception $e) {
                            die("Impossible de modifier le prêt : ".$e->getMessage());
                        }
                    }
                }
                /***** Supprimer un prêt *****/
                if(isset($_POST['confirm-supp'])) {
                    $client = str_replace('\'', ' ', $_POST['client']);
                    try {
                        $result = $bdd->getPdo()->query("SELECT ident FROM pret WHERE reference = '{$_POST['reference']}' 
                                    AND start = '{$_POST['start']}' AND end = '{$_POST['end']}' AND client = {$bdd->getPdo()->quote($_POST['client'])} 
                                    AND alerte = '{$_POST['alerte']}' LIMIT {$_POST['number']}");
                        foreach($result as $res) {
                            try {
                                $bdd->getPdo()->query("DELETE FROM pret WHERE ident = '{$res['ident']}'");
                                $bdd->getPdo()->query("UPDATE stock SET etat = 'disponible' WHERE ident = {$res['ident']}");
                            } catch(Exception $e) {
                                die("Impossible de supprimer et de mettre à jour un prêt : ".$e->getMessage());
                            }
                        }
                        try {
                            $bdd->getPdo()->query("INSERT INTO historique (date, action, reference, materiel, nombre, client, start, end) 
                                VALUES ('{$localdate}', 'Suppression de prêt', '{$_POST['reference']}', '{$_POST['materiel']}', '{$_POST['number']}', '{$client}', '{$_POST['start']}', '{$_POST['end']}')");
                        } catch (Exception $e) {
                            die("Impossible d'ajouter dans l'historique : ".$e->getMessage());
                        }
                    }   catch(Exception $e) {
                        die("Impossible de récupérer les données de Pret : ".$e->getMessage());
                    }
                }
                /***** Boutons de tri *****/
                $tri = "";
                if(isset($_POST['submit-reference'])) {
                    $tri = ' ORDER BY pret.reference';
                }
                if(isset($_POST['submit-materiel'])) {
                    $tri = ' ORDER BY materiel';
                }
                if(isset($_POST['submit-marque'])) {
                    $tri = ' ORDER BY marque';
                }
                if(isset($_POST['submit-note'])) {
                    $tri = ' ORDER BY note';
                }
                if(isset($_POST['submit-start'])) {
                    $trie = ' ORDER BY start';
                }
                if(isset($_POST['submit-end'])) {
                    $tri = ' ORDER BY end';
                }
                if(isset($_POST['submit-client'])) {
                    $tri = ' ORDER BY client';
                }
                if(isset($_POST['submit-alerte'])) {
                    $tri = ' ORDER BY alerte';
                }
                ?>
            
            <div class="pret-action">

<!--------------------------------------------------- FORMULAIRE EDITION DE PRET ---------------------------------------------->
                <?php
                    if(isset($_POST["submit-edit"])) {
                ?>
                    <h3 class="action-clignote">Modification du prêt</h3>
                    <div class="modif-pret">
                        <form class="edit" action="index.php?menu=2" method="POST">
                            <input type="hidden" value="<?php echo $_POST['id']; ?>" name="id-edit"/>
                            <label for="ref">Référence: </label>
                            <input type="text" id="ref-edit" name="ref-edit" max-length="30" value="<?php echo $_POST['ref']; ?>" required readonly/>
                            <label for="mat">Matériel: </label> 
                            <input type="text" id="mat-edit" name="mat-edit" max-length="30" value="<?php echo $_POST['materiel']; ?>" required placeholder="" readonly/>
                            <label for="marque">Marque: </label>
                            <input type="text" id="marque-edit" name="marque-edit" max-length="30" value="<?php echo $_POST['marque']; ?>" placeholder="" readonly/>
                            <label for="note">Note: </label> 
                            <input type="text" id="note-edit" name="note-edit" max-length="150" value="<?php echo $_POST['note']; ?>" readonly/>
                            <label for="start">*Début du prêt</label>
                            <input type="date" id="start" name="start" value="<?php echo $_POST['start']; ?>" required/><br/>
                            <label for="end">*Fin du prêt</label>
                            <input type="date" id="end" name="end" value="<?php echo $_POST['end']; ?>" required/><br/>
                            <label for="client">*Client</label>
                            <select name="client" id="client" required>
                                <option value="Mairie d\'Argentré du Plessis">Mairie d'Argentré du Plessis</option>
                                <option value="Mairie d\'Availles-sur-Seiche">Mairie d'Availles-sur-Seiche</option>
                                <option value="Mairie de Bais">Mairie de Bais</option>
                                <option value="Mairie de Balazé">Mairie de Balazé</option>
                                <option value="Mairie de Bréal-sous-Vitré">Mairie de Bréal-sous-Vitré</option>
                                <option value="Mairie de Brielles">Mairie de Brielles</option>
                                <option value="Mairie de Champeaux">Mairie de Champeaux</option>
                                <option value="Mairie de Châteaubourg">Mairie de Châteaubourg</option>
                                <option value="Mairie de Châtillon-en-Vendelais">Mairie de Châtillon-en-Vendelais</option>
                                <option value="Mairie de Cornillé">Mairie de Cornillé</option>
                                <option value="Mairie de Domagné">Mairie de Domagné</option>
                                <option value="Mairie de Domalain">Mairie de Domalain</option>
                                <option value="Mairie de Drouges">Mairie de Drouges</option>
                                <option value="Mairie d\'Erbrée">Mairie d'Erbrée</option>
                                <option value="Mairie d\'Étrelles">Mairie d'Étrelles</option>
                                <option value="Mairie de Gennes-sur-Seiche">Mairie de Gennes-sur-Seiche</option>
                                <option value="Mairie de La Chapelle-Erbrée">Mairie de La Chapelle-Erbrée</option>
                                <option value="Mairie de La Guerche-de-Bretagne">Mairie de La Guerche-de-Bretagne</option>
                                <option value="Mairie de La Selle-Guerchaise">Mairie de La Selle-Guerchaise</option>
                                <option value="Mairie de Landavran">Mairie de Landavran</option>
                                <option value="Mairie de Le Pertre">Mairie de Le Pertre</option>
                                <option value="Mairie de Louvigné-de-Bais">Mairie de Louvigné-de-Bais</option>
                                <option value="Mairie de Marpiré">Mairie de Marpiré</option>
                                <option value="Mairie de Mecé">Mairie de Mecé</option>
                                <option value="Mairie de Mondevert">Mairie de Mondevert</option>
                                <option value="Mairie de Montautour">Mairie de Montautour</option>
                                <option value="Mairie de Montreuil-des-Landes">Mairie de Montreuil-des-Landes</option>
                                <option value="Mairie de Montreuil-sous-Pérouse">Mairie de Montreuil-sous-Pérouse</option>
                                <option value="Mairie de Moulins">Mairie de Moulins</option>
                                <option value="Mairie de Moussé">Mairie de Moussé</option>
                                <option value="Mairie de Pocé-les-Bois">Mairie de Pocé-les-Bois</option>
                                <option value="Mairie de Princé">Mairie de Princé</option>
                                <option value="Mairie de Rannée">Mairie de Rannée</option>
                                <option value="Mairie de Saint-Aubin-des-Landes">Mairie de Saint-Aubin-des-Landes</option>
                                <option value="Mairie de Saint-Christophe-des-Bois">Mairie de Saint-Christophe-des-Bois</option>
                                <option value="Mairie de Saint-Didier">Mairie de Saint-Didier</option>
                                <option value="Mairie de Saint-Germain-du-Pinel">Mairie de Saint-Germain-du-Pinel</option>
                                <option value="Mairie de Saint-Jean-sur-Vilaine">Mairie de Saint-Jean-sur-Vilaine</option>
                                <option value="Mairie de Saint-M\'Hervé">Mairie de Saint-M'Hervé</option>
                                <option value="Mairie de Taillis">Mairie de Taillis</option>
                                <option value="Mairie de Torcé">Mairie de Torcé</option>
                                <option value="Mairie de Val D\'Izé">Mairie de Val D'Izé</option>
                                <option value="Mairie de Vergéal">Mairie de Vergéal</option>
                                <option value="Mairie de Visseiche">Mairie de Visseiche</option>
                                <option value="Mairie de Vitré">Mairie de Vitré</option>
                                <option value="CCAS de Chateaubourg">CCAS de Chateaubourg</option>
                                <option value="CCAS de Chatillon-en-Vendelais">CCAS de Chatillon-en-Vendelais</option>
                                <option value="CCAS de Val d\'Izé">CCAS de Val d'Izé</option>
                                <option value="CCAS de Vitré">CCAS de Vitré</option>
                                <option value="Smictom Sud Est 35">Smictom Sud Est 35</option>
                                <option value="Eau des Portes de Bretagne">Eau des Portes de Bretagne</option>
                                <option value="Syndicat d\'Urbanisme du Pays de Vitré">Syndicat d'Urbanisme du Pays de Vitré</option>
                                <option value="Vitré Communauté">Vitré Communauté</option>
                                <option value="Syndicat de traitement S3TEC">Syndicat de traitement S3TEC</option>
                            </select>
                            <button type="submit" name="confirm-edit" title="Confirmer">Confirmer</button>
                        </form>
                        <form action="index.php?menu=2" method="POST">
                            <button type="submit" name="cancel-edit" title="Annuler">Annuler</button>
                        </form>
                    </div>
                <?php
                    } else if(isset($_POST['submit-supp'])) {
                ?>
                    <h3 class="action-clignote">Suppression de prêt</h3>
                    <div class="supp-pret">
                        <form action="index.php?menu=2" method="POST"><br/>
                            <input type="hidden" value="<?php echo $_POST['id']; ?>" name="id"/>
                            <input type="hidden" value="<?php echo $_POST['alerte']; ?>" name="alerte"/>
                            <label for="reference">Référence: </label>
                            <input type="text" id="reference" name="reference" value="<?php echo $_POST['reference']; ?>" required readonly/>
                            <label for="materiel">Matériel: </label> 
                            <input type="text" id="materiel" name="materiel" value="<?php echo $_POST['materiel']; ?>" required placeholder="" readonly/>
                            <label for="marque">Marque: </label>
                            <input type="text" id="marque" name="marque" value="<?php echo $_POST['marque']; ?>" placeholder="" readonly/>
                            <label for="note">Note: </label> 
                            <input type="text" id="note" name="note" value="<?php echo $_POST['note']; ?>" readonly/>
                            <label for="start">Début du prêt</label>
                            <input type="date" id="start" name="start" value="<?php echo $_POST['start']; ?>" required readonly/><br/>
                            <label for="end">Fin du prêt</label>
                            <input type="date" id="end" name="end" value="<?php echo $_POST['end']; ?>" required readonly/><br/>
                            <label for="client">Client</label>
                            <input type="text" id="client" name="client" value="<?php echo $_POST['client']; ?>" required readonly/><br/>
                            <label for="nombre"*>Nombre à supprimer</label>
                            <input type="number" id="number" name="number" min="1" max="<?php if(isset($_POST['submit-supp'])) { echo($_POST['number']); } else { echo("1"); }?>" 
                                               value="1" required placeholder=""/><br/>
                            <button type="submit" name="confirm-supp">Confirmer</button>
                        </form>
                        <form action="index.php?menu=2" method="POST">
                            <button type="submit" name="cancel-supp" title="Annuler">Annuler</button>
                        </form>
                    </div>
                <?php
                    } else {
                ?>
                <!----------------------------------------------AJOUTER AUX PRETS-------------------------------------------------------------->
                <h3 class="action-clignote">Effectuer un prêt</h3>
                <form action="index.php?menu=2" method="POST">
                    <ul class="pret-form">
                        <li>
                            <label for="reference">Référence</label><br/>
                            <input type="text"   id="ref"  maxlength="30"   name="ref"    value="<?php if(isset($_POST['submit-add'])) echo($_POST['ref']);    ?>" required placeholder=""/>
                            <input type="hidden" id="mat"    name="mat"    value="<?php if(isset($_POST['submit-add'])) echo($_POST['mat']);    ?>"/>
                            <input type="hidden" id="marque" name="marque" value="<?php if(isset($_POST['submit-add'])) echo($_POST['marque']); ?>"/>
                            <input type="hidden" id="note"   name="note"   value="<?php if(isset($_POST['submit-add'])) echo($_POST['note']);   ?>"/>
                        </li>
                        <li>
                            <label for="nombre">Nombre à prêter</label><br/>
                            <input type="number" id="number" name="number" min="1" max="<?php if(isset($_POST['submit-add'])) { echo($_POST['number']); } else { echo("1"); }?>" 
                                               value="1" required placeholder=""/>
                        </li>
                        <li>
                            <label for="client">*Client</label><br/>
                            <select name="client" id="client" required>
                                <option value="Mairie d\'Argentré du Plessis">Mairie d'Argentré du Plessis</option>
                                <option value="Mairie d\'Availles-sur-Seiche">Mairie d'Availles-sur-Seiche</option>
                                <option value="Mairie de Bais">Mairie de Bais</option>
                                <option value="Mairie de Balazé">Mairie de Balazé</option>
                                <option value="Mairie de Bréal-sous-Vitré">Mairie de Bréal-sous-Vitré</option>
                                <option value="Mairie de Brielles">Mairie de Brielles</option>
                                <option value="Mairie de Champeaux">Mairie de Champeaux</option>
                                <option value="Mairie de Châteaubourg">Mairie de Châteaubourg</option>
                                <option value="Mairie de Châtillon-en-Vendelais">Mairie de Châtillon-en-Vendelais</option>
                                <option value="Mairie de Cornillé">Mairie de Cornillé</option>
                                <option value="Mairie de Domagné">Mairie de Domagné</option>
                                <option value="Mairie de Domalain">Mairie de Domalain</option>
                                <option value="Mairie de Drouges">Mairie de Drouges</option>
                                <option value="Mairie d\'Erbrée">Mairie d'Erbrée</option>
                                <option value="Mairie d\'Étrelles">Mairie d'Étrelles</option>
                                <option value="Mairie de Gennes-sur-Seiche">Mairie de Gennes-sur-Seiche</option>
                                <option value="Mairie de La Chapelle-Erbrée">Mairie de La Chapelle-Erbrée</option>
                                <option value="Mairie de La Guerche-de-Bretagne">Mairie de La Guerche-de-Bretagne</option>
                                <option value="Mairie de La Selle-Guerchaise">Mairie de La Selle-Guerchaise</option>
                                <option value="Mairie de Landavran">Mairie de Landavran</option>
                                <option value="Mairie de Le Pertre">Mairie de Le Pertre</option>
                                <option value="Mairie de Louvigné-de-Bais">Mairie de Louvigné-de-Bais</option>
                                <option value="Mairie de Marpiré">Mairie de Marpiré</option>
                                <option value="Mairie de Mecé">Mairie de Mecé</option>
                                <option value="Mairie de Mondevert">Mairie de Mondevert</option>
                                <option value="Mairie de Montautour">Mairie de Montautour</option>
                                <option value="Mairie de Montreuil-des-Landes">Mairie de Montreuil-des-Landes</option>
                                <option value="Mairie de Montreuil-sous-Pérouse">Mairie de Montreuil-sous-Pérouse</option>
                                <option value="Mairie de Moulins">Mairie de Moulins</option>
                                <option value="Mairie de Moussé">Mairie de Moussé</option>
                                <option value="Mairie de Pocé-les-Bois">Mairie de Pocé-les-Bois</option>
                                <option value="Mairie de Princé">Mairie de Princé</option>
                                <option value="Mairie de Rannée">Mairie de Rannée</option>
                                <option value="Mairie de Saint-Aubin-des-Landes">Mairie de Saint-Aubin-des-Landes</option>
                                <option value="Mairie de Saint-Christophe-des-Bois">Mairie de Saint-Christophe-des-Bois</option>
                                <option value="Mairie de Saint-Didier">Mairie de Saint-Didier</option>
                                <option value="Mairie de Saint-Germain-du-Pinel">Mairie de Saint-Germain-du-Pinel</option>
                                <option value="Mairie de Saint-Jean-sur-Vilaine">Mairie de Saint-Jean-sur-Vilaine</option>
                                <option value="Mairie de Saint-M\'Hervé">Mairie de Saint-M'Hervé</option>
                                <option value="Mairie de Taillis">Mairie de Taillis</option>
                                <option value="Mairie de Torcé">Mairie de Torcé</option>
                                <option value="Mairie de Val D\'Izé">Mairie de Val D'Izé</option>
                                <option value="Mairie de Vergéal">Mairie de Vergéal</option>
                                <option value="Mairie de Visseiche">Mairie de Visseiche</option>
                                <option value="Mairie de Vitré">Mairie de Vitré</option>
                                <option value="CCAS de Chateaubourg">CCAS de Chateaubourg</option>
                                <option value="CCAS de Chatillon-en-Vendelais">CCAS de Chatillon-en-Vendelais</option>
                                <option value="CCAS de Val d\'Izé">CCAS de Val d'Izé</option>
                                <option value="CCAS de Vitré">CCAS de Vitré</option>
                                <option value="Smictom Sud Est 35">Smictom Sud Est 35</option>
                                <option value="Eau des Portes de Bretagne">Eau des Portes de Bretagne</option>
                                <option value="Syndicat d\'Urbanisme du Pays de Vitré">Syndicat d'Urbanisme du Pays de Vitré</option>
                                <option value="Vitré Communauté">Vitré Communauté</option>
                                <option value="Syndicat de traitement S3TEC">Syndicat de traitement S3TEC</option>
                            </select>
                        </li>
                        <li>
                            <label for="start">*Début du prêt</label><br/>
                            <input type="date" id="start" name="start" value="<?php echo $localdate; ?>" required/>
                        </li>
                        <li>
                            <label for="end">*Fin du prêt</label><br/>
                            <input type="date" id="end" name="end" required/>
                        </li>
                        <li>
                            <label for="alerte">*Alerte</label><br/>
                            <input type="date" id="alerte" name="alerte" required/>
                        </li>
                        <li>
                            <button type="submit" name="submit-pret">Confirmer la demande</button>
                        </li>
                    </ul>
                </form>
                <?php
                    }
                ?>
            </div>

<!-----------------------------------------------------LISTE DES PRETS--------------------------------------------------------->
            <div class="pret-liste">
                <h3>Liste des prêts en cours</h3>
                <table>
                    <tr class="pret-table">
                        <th class="ref">
                            <form action="index.php?menu=2" method="POST">
                                <button type="submit" name="submit-reference" title="Trier par référence">Référence</button>
                            </form>
                        </th>
                        <th class="mat">
                            <form action="index.php?menu=2" method="POST">
                                <button type="submit" name="submit-materiel" title="Trier par materiel">Matériel</button>
                            </form>
                        </th>
                        <th class="nb">
                            <form action="index.php?menu=2" method="POST">
                                <button type="submit" name="submit-nb" title="Trier par nombre">Nombre</button>
                            </form>
                        </th>
                        <th class="marque">
                            <form action="index.php?menu=2" method="POST">
                                <button type="submit" name="submit-marque" title="Trier par marque">Marque</button>
                            </form>
                        </th>
                        <th class="note">
                            <form action="index.php?menu=2" method="POST">
                                <button type="submit" name="submit-note" title="Trier par note">Note</button>
                            </form>
                        </th>
                        <th class="start">
                            <form action="index.php?menu=2" method="POST">
                                <button type="submit" name="submit-start" title="Trier par date de début">Début du prêt</button>
                            </form>
                        </th>
                        <th class="end">
                            <form action="index.php?menu=2" method="POST">
                                <button type="submit" name="submit-end" title="Trier par date de fin">Fin du prêt</button>
                            </form>
                        </th>
                        <th class="client">
                            <form action="index.php?menu=2" method="POST">
                                <button type="submit" name="submit-client" title="Trier par client">Client</button>
                            </form>
                        </th>
                        <th class="alerte">
                            <form action="index.php?menu=2" method="POST">
                                <button type="submit" name="submit-alerte" title="Trier par alerte">Alerte</button>
                            </form>
                        </th>
                        <th></th>
                        <th></th>
                    </tr>
                    <?php 
                        $result = $bdd->getPdo()->query("SELECT *, COUNT(*) as number FROM stock INNER JOIN pret ON stock.ident = pret.ident WHERE etat = 'déjà prêté' GROUP BY stock.reference, materiel, marque, etat, note".$tri);
                        /*$result = $bdd->getPdo()->query("SELECT *  FROM stock INNER JOIN pret ON stock.ident = pret.ident WHERE etat = 'déjà prêté'".$tri);*/
                        foreach($result as $res) {
                    ?>
                    <tr class="pret-table">
                        <td class="ref">
                            <?php if(in_array($res['ident'], $tabAlerte))  {
                                echo("<p class='clignote'>"); echo($res['reference']); echo("</p>"); }
                                else { print $res['reference']; }
                             ?>
                        </td>
                        <td class="mat"><?php print $res['materiel']; ?> </td>
                        <td class="nb"><?php print $res['number']; ?> </td>
                        <td class="marque"><?php print $res['marque']; ?></td>
                        <td class="note"><?php print $res['note']; ?></td>
                        <td class="start"><?php print $res['start']; ?></td>
                        <td class="end"><?php print $res['end']; ?></td>
                        <td class="client"><?php print $res['client']; ?></td>
                        <td class="alerte"><?php print $res['alerte']; ?></td>
                        <td class="button">
                            <form action="index.php?menu=2" method="POST">
                                <button type="submit" name="submit-edit" title="Modifier">
                                <input  type="hidden" value="<?php echo $res['ident']; ?>"     name="id"/>
                                <input  type="hidden" value="<?php echo $res['reference']; ?>" name="ref"/>
                                <input  type="hidden" value="<?php echo $res['materiel']; ?>"     name="materiel"/>
                                <input  type="hidden" value="<?php echo $res['marque']; ?>"     name="marque"/>
                                <input  type="hidden" value="<?php echo $res['note']; ?>"     name="note"/>
                                <input  type="hidden" value="<?php echo $res['start']; ?>"     name="start"/>
                                <input  type="hidden" value="<?php echo $res['end']; ?>"       name="end"/>
                                <input  type="hidden" value="<?php echo $res['client']; ?>"    name="client"/>
                                <input  type="hidden" value="<?php echo $res['alerte']; ?>"    name="alerte"/>
                                <img src="images/modifier.png" alt="modifier" height="20px">
                            </form>
                         </td>
                        <td class="button">
                            <form action="index.php?menu=2" method="POST">
                                <button type="submit" name="submit-supp" title="Supprimer">
                                <input type="hidden" value="<?php echo $res['ident']; ?>" name="id"/>
                                <input  type="hidden" value="<?php echo $res['reference']; ?>" name="reference"/>
                                <input  type="hidden" value="<?php echo $res['materiel']; ?>"     name="materiel"/>
                                <input  type="hidden" value="<?php echo $res['marque']; ?>"     name="marque"/>
                                <input  type="hidden" value="<?php echo $res['note']; ?>"     name="note"/>
                                <input  type="hidden" value="<?php echo $res['number']; ?>"     name="number"/>
                                <input  type="hidden" value="<?php echo $res['start']; ?>"     name="start"/>
                                <input  type="hidden" value="<?php echo $res['end']; ?>"       name="end"/>
                                <input  type="hidden" value="<?php echo $res['client']; ?>"    name="client"/>
                                <input  type="hidden" value="<?php echo $res['alerte']; ?>"    name="alerte"/>
                                <img src="images/basket.png" alt="supprimer" height="20px">
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php
                        } 
                    ?>
                </table>

            </div>
        </div>
<!------------------------------------------------------------------------------------------------------------------------------
--------------------------------------------------------------------------------------------------------------------------------
------------------------------------------------------CASE 3 HISTORIQUE---------------------------------------------------------
--------------------------------------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------------->
        <?php
                break;
                case 3:
        ?>
        <div class="historique">
<!----------------------------------- TRAITEMENT DE TOUTES LES ACTIONS DE L'HISTORIQUE----------------------------------------->
            <?php
                $trie ="";
                $export ="";
                if(isset($_POST['submit-date'])) {
                    $trie = ' ORDER BY date DESC';
                }
                if(isset($_POST['submit-action'])) {
                    $trie = ' ORDER BY action';
                }
                if(isset($_POST['submit-reference'])) {
                    $trie = ' ORDER BY reference';
                }
                if(isset($_POST['submit-materiel'])) {
                    $trie = ' ORDER BY materiel';
                }
                if(isset($_POST['submit-marque'])) {
                    $trie = ' ORDER BY marque';
                }
                if(isset($_POST['submit-etat'])) {
                    $trie = ' ORDER BY etat DESC';
                }
                if(isset($_POST['submit-proprietaire'])) {
                    $trie = ' ORDER BY proprietaire';
                }
                if(isset($_POST['submit-nb'])) {
                    $trie = ' ORDER BY nombre DESC';
                }
                if(isset($_POST['submit-note'])) {
                    $trie = ' ORDER BY note';
                }
                if(isset($_POST['submit-client'])) {
                    $trie = ' ORDER BY client';
                }
                if(isset($_POST['submit-start'])) {
                    $trie = ' ORDER BY start';
                }
                if(isset($_POST['submit-end'])) {
                    $trie = ' ORDER BY end';
                }
                if(isset($_POST['submit-tri-histo'])) {
                    if($_POST['tri'] === 'annee') {
                        $trie .= "WHERE date > '{$dateYear}'";
                    } else if($_POST['tri'] === 'mois') {
                        $trie .= "WHERE date > '{$dateMonth}'";
                    } else if($_POST['tri'] === 'semaine') {
                        $trie .= "WHERE date > '{$dateWeek}'";
                    } else {
                        $trie .= " WHERE date = '{$localdate}'";
                    }
                }
                if(isset($_POST['submit-histo-xls'])) {
                    try {
                        $requete = "SELECT * FROM historique ".$trie;
                        $result = $bdd->getPdo()->query($requete);
                        $export .= '
                            <table>
                            <tr>
                            <td>id</id>
                            <td>date</id>
                            <td>action</id>
                            <td>reference</id>
                            <td>materiel</id>
                            <td>marque</id>
                            <td>etat</id>
                            <td>proprietaire</id>
                            <td>nombre</id>
                            <td>note</id>
                            <td>client</id>
                            <td>start</id>
                            <td>end</id>
                            </tr>
                        ';
                        foreach($result as $res) {
                            $export .= '
                                <tr>
                                <td>'.$res['id'].'</td>
                                <td>'.$res['date'].'</td>
                                <td>'.$res['action'].'</td>
                                <td>'.$res['reference'].'</td>
                                <td>'.$res['materiel'].'</td>
                                <td>'.$res['marque'].'</td>
                                <td>'.$res['etat'].'</td>
                                <td>'.$res['proprietaire'].'</td>
                                <td>'.$res['nombre'].'</td>
                                <td>'.$res['note'].'</td>
                                <td>'.$res['client'].'</td>
                                <td>'.$res['start'].'</td>
                                <td>'.$res['end'].'</td>
                                </tr>
                            ';
                        }
                        $export .= '</table>';
                        $fileName = "historique-".$localdate.".xls";
                        header('Content-Type: application/xls');
                        header('Content-Disposition: attachment; filename='.$fileName);
                        echo $export;
                    } catch (Exception $e) {
                        echo("Impossible d'exporter l'historique en .xls : ". $e->getMessage());
                    }
                    
                }
            ?>
            <div class="export">
                <h3 class="title-histo">Tout l'historique</h3>
                <form name="submit-histo" action="index.php?menu=3" method="POST">
                    <input type="submit" name="submit-histo-xls" value="Exporter l'historique en .xls"/>
                </form>
                <form name="tri-histo" action="index.php?menu=3" method="POST">
                    <select name="tri" id="tri" required>
                        <option value="annee">Afficher sur l'année</option>
                        <option value="mois">Afficher sur le mois</option>
                        <option value="semaine">Afficher sur la semaine</option>
                        <option value="jour">Afficher sur le jour</option>
                    </select>
                    <button type="submit" name="submit-tri-histo">Ok</button>
                </form>
            </div>
            <table>
<!------------------------------------------------- AFFICHAGE HISTORIQUE ------------------------------------------------------>
                <tr class="historique-table">
                    <th class="date">
                        <form action="index.php?menu=3" method="POST">
                            <button type="submit" name="submit-date" title="Trier par date">Date</button>
                        </form>
                    </th>
                    <th class="action">
                        <form action="index.php?menu=3" method="POST">
                            <button type="submit" name="submit-action" title="Trier par action">Action</button>
                        </form>
                    </th>
                    <th class="ref">
                        <form action="index.php?menu=3" method="POST">
                            <button type="submit" name="submit-reference" title="Trier par référence">Référence</button>
                        </form>
                    </th>
                    <th class="mat">
                        <form action="index.php?menu=3" method="POST">
                            <button type="submit" name="submit-materiel" title="Trier par materiel">Materiel</button>
                        </form>
                    </th>
                    <th class="marque">
                        <form action="index.php?menu=3" method="POST">
                            <button type="submit" name="submit-marque" title="Trier par marque">Marque</button>
                        </form>
                    </th>
                    <th class="etat">
                        <form action="index.php?menu=3" method="POST">
                            <button type="submit" name="submit-etat" title="Trier par état">Etat</button>
                        </form>
                    </th>
                    <th class="proprietaire">
                        <form action="index.php?menu=3" method="POST">
                            <button type="submit" name="submit-proprietaire" title="Trier par propriétaire">Propriétaire</button>
                        </form>
                    </th>
                    <th class="nb">
                        <form action="index.php?menu=3" method="POST">
                            <button type="submit" name="submit-nb" title="Trier par nombre">Nombre</button>
                        </form>
                    </th>
                    <th class="note">
                        <form action="index.php?menu=3" method="POST">
                            <button type="submit" name="submit-note" title="Trier par note">Note</button>
                        </form>
                    </th>
                    <th class="client">
                        <form action="index.php?menu=3" method="POST">
                            <button type="submit" name="submit-client" title="Trier par client">Client</button>
                        </form>
                    </th>
                    <th class="start">
                        <form action="index.php?menu=3" method="POST">
                            <button type="submit" name="submit-start" title="Trier par début">Début</button>
                        </form>
                    </th>
                    <th class="end">
                        <form action="index.php?menu=3" method="POST">
                            <button type="submit" name="submit-end" title="Trier par fin">Fin</button>
                        </form>
                    </th>
                </tr>
                <?php
                    $result = $bdd->getPdo()->query("SELECT * FROM historique ".$trie);
                    foreach($result as $res) {
                ?>
                <tr class="historique-table">
                    <td class="date"><?php print $res['date']; ?></td>
                    <td class="action"><?php print $res['action']; ?></td>
                    <td class="ref"><?php print $res['reference']; ?></td>
                    <td class="mat"><?php print $res['materiel']; ?></td>
                    <td class="marque"><?php print $res['marque']; ?></td>
                    <td class="etat"><?php print $res['etat']; ?></td>
                    <td class="proprietaire"><?php print $res['proprietaire']; ?></td>
                    <td class="nb"><?php print $res['nombre']; ?></td>
                    <td class="note"><?php print $res['note']; ?></td>
                    <td class="client"><?php print $res['client']; ?></td>
                    <td class="start"><?php print $res['start']; ?></td>
                    <td class="end"><?php print $res['end']; ?></td>
                </tr>
                <?php
                    }
                ?>
            </table>
        </div>
<!------------------------------------------------------------------------------------------------------------------------------
--------------------------------------------------------------------------------------------------------------------------------
------------------------------------------------------CASE 4 UTILISATION -------------------------------------------------------
--------------------------------------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------------->
        <?php
                break;
                case 4:
        ?>
        <div class="utilisation">
            <h3>Navigation</h3>
            <p>Bienvenue dans le guide d'utilisation de l'application. On va d'abord commencer par parcourir les onglets.</p>
            <br/>
            <div class="navigation">
                <img src="images/utilisation1.png" alt="utilisation" height="100px">
                <p>On retrouve ici le menu principal, avec les onglets Stock, Prêts et Historique. 
                    Ceux-ci sont pointés grâce aux flèches rouges. On retrouve également les logos 
                    au haut pointés par 2 flèches bleues. En cliquant dessus, vous serez redirigés vers leur site internet. </p>
            </div>
            <br/>
            <h3>Stock</h3>
            <div class="utilisation-stock">
                <img src="images/utilisation-stock1.png" alt="utilisation" height="250px">
                <p>En cliquant sur l'onglet Stock, cette interface se présentera devant vous. A droite se trouve la liste du stock, 
                    et à gauche les actions. Pour ajouter un matériel dans le stock, il vous suffit de compléter le formulaire à gauche,
                    ou alors vous pouvez simplement cliquer sur le bouton dans la colonne Nombre sur un matériel déjà existant (flèche bleue), 
                    pour pouvoir en ajouter plus. Vous devrez dans tous les cas cliquer sur le bouton Ajouter au stock.</p>
                <p>A droite de chaque matériel du stock se trouvent 3 boutons, représentés par les flèches rouges. Le premier vous permet de 
                    l'ajouter en prêt, nous y reviendrons plus tard. Sachez juste que vous ne pouvez faire un prêt que si le matériel est disponible.
                    <br/>Le second bouton vous permet de modifier les caractéristiques d'un matériel. En cliquant dessus, une fenêtre 
                    Modifier du stock s'affichera en dessous à gauche. 
                    <br/>Le troisième bouton permet de supprimer un matériel de la liste du stock. En cliquant dessus, une autre fenêtre s'affichera 
                    également en dessous à gauche. Vous ne pouvez pas supprimer 
                    un matériel si celui-ci est déjà prêté.</p>
            </div>
            <br/>
            <h3>Prêts</h3>
            <div class="utilisation-pret">
                <img src="images/utilisation-pret1.png" alt="utilisation" height="250px">
                <p>En cliquant sur l'onglet Prêts, cette interface se présentera devant vous. A droite se trouve la liste des prêts, et à gauche les actions.
                    Pour ajouter un prêt, vous pouvez remplir le formulaire Effectuer un prêt. Vous pouvez aussi cliquer sur Ajouter aux prêts sur 
                    un matériel depuis l'onglet Stock comme cité précédemment, et la référence s'affichera automatiquement (flèche bleue). 
                    <br/>Vous pouvez faire un prêt d'un maximum 50 même matériel en une seule fois. N'oubliez pas d'inscrire une date valide 
                    (date de fin égale ou après la date de début).
                    <br/>Pour modifier les caractéristiques d'un prêt, vous pouvez cliquer sur le bouton Modifier à droite. Celui-ci vous affichera 
                    une fenêtre en bas à gauche. Attention : vous ne pouvez pas modifier les caractéristiques du matériel, seulement du prêt. 
                    <br/>Pour supprimer un prêt, cliquer sur le bouton Supprimer à droite.
                    <br/>Lorsque le prêt atteindra la date butoir de 5 jours, une alerte se déclenchera.</p>
            </div>
            <br/>
            <h3>Historique</h3>
            <div class="utilisation-historique">
                <img src="images/utilisation-historique1.png" alt="utilisation" height="250px">
                <p>En cliquant sur l'onglet Historique, cette interface se présentera devant vous. Elle contient la liste de toute les actions effectuées 
                    sur l'application. On retrouve la date locale lors de l'action, et la référence du matériel.
                    <br/>Vous pouvez exporter l'historique grâce au bouton en haut à droite de la page.
                </p>
            </div>
        </div>
<!------------------------------------------------------------------------------------------------------------------------------
--------------------------------------------------------------------------------------------------------------------------------
------------------------------------------------------CASE 5 SE CONNECTER-------------------------------------------------------
--------------------------------------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------------->
        <?php
                break;
                case 5:
        ?>
        <div class="log-in">
            <p>Non fonctionnel</p>
            <p>Développé par Evan Froc</p>
        </div>
        <?php            
                break;
            }
        ?>
    </div>
</body>