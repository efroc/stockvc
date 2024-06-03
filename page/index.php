<!DOCTYPE html>
<html lang="fr">
<!----------------------------------------------------- HEAD PAGE ------------------------------------------------------------->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <link href="css/index.css" rel="stylesheet"/>
    <title>Stock Informatique Vitré Communauté</title>
    <link rel="website icon" type="png" href="../images/VClogo.png"/>
</head>

<!----------------------------------------------------- BODY PAGE ------------------------------------------------------------->
<body>
<!--------------------------------------------------- CONNEXION BDD ----------------------------------------------------------->
<?php
    require '../src/traitement/BDD.php';
    require '../src/class/Stock.php';
    /***** Création de la connexion *****/ 
    $bdd = new BDD();
    $connexion = $bdd->connect();
    /***** Date locale *****/
    $localdate = date('Y-m-d');
    $dateAlerte = date('Y-m-d', strtotime("+5 Days"));
    /***** Création var globale erreur ******/   
    $erreur = "";
    /***** Alertes *****/
    $requete = "SELECT ident FROM pret WHERE end < '{$dateAlerte}'";
    $resAlerte = $bdd->getPdo()->query($requete);
    $tabAlerte = array();
    foreach($resAlerte as $res) { 
        array_push($tabAlerte, $res['ident']);
    } 
?>

<!------------------------------------------------------- MENU ---------------------------------------------------------------->
    <div class="head">
        <a class="redirection-left" target="_blank" href="https://www.vitrecommunaute.org/">
            <img class="DSIlogo" src="../images/DSIlogo.png" alt="logo" height="59px"><img src="../images/VClogo.png" alt="logo" height="59px">
        </a>
        <p class="title"><a class="jebaited" title="Clique pour gagner 500€" target="_blank" href="https://www.youtube.com/watch?v=-a5Ba-CG8uc">G</a>estion du stock et des prêts</p>
        <a class="redirection-right" target="_blank" href="https://www.mairie-vitre.com/"><img src="../images/mairielogo.png" alt="logo" height="59px"></a>
    </div>
    <ul class="menu">
        <li><a href="index.php?menu=1"><p class="menu-text">Stock</p></a></li>
        <li><a href="index.php?menu=2"><p class=<?php if(count($tabAlerte) > 0) {echo("menu-text-alerte");} else { echo("menu-text"); }?>>Prêts et Alertes</p></a></li>
        <li><a href="index.php?menu=3"><p class="menu-text">Historique</p></a></li>
        <li style="float:right"><a class="login" href="index.php?menu=4"><p class="menu-text">Se connecter</p></a></li> 
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
                /***** Ajout au stock *****/
                if(isset($_POST['submit-stock'])) {
                    $newmat = new Materiel($_POST['reference'], strtolower($_POST['materiel']), strtolower($_POST['marque']), 
                            strtolower($_POST['etat']), strtolower($_POST['note']));
                    $historeq = "INSERT INTO historique (date, reference, action, message) 
                                VALUES ('{$localdate}', '{$_POST['reference']}', 'Ajout au stock',
                                 '{$_POST['number']} {$_POST['materiel']} ont été ajouté au stock.')";
                    
                    for($i = 0; $i < $_POST['number']; $i++) {
                        $bdd->addMaterielToStock($newmat); 
                    }
                    try {
                        $bdd->query($historeq);  
                    } catch(Exception $e) {
                        die("Impossible d'ajouter à l'historique : ".$e->getMessage());
                    }                                                                                                       
                    header('Location: redirection.php');     
                }
                /***** Modifier du stock *****/
                if(isset($_POST["confirm-edit"])) {
                    $req = "UPDATE stock SET materiel = '{$_POST['mat-edit']}', marque = '{$_POST['marque-edit']}', 
                            etat = '{$_POST['etat-edit']}', note = '{$_POST['note-edit']}' WHERE ident = '{$_POST['id-edit']}'";
                    $historeq = "INSERT INTO historique (date, reference, action, message) 
                            VALUES ('{$localdate}', '{$_POST['ref-edit']}', 'Modification du stock',
                            'Un ou plusieurs paramètres du {$_POST['mat-edit']} ont été modifié dans le stock.')";
                    try {
                        $bdd->getPDO()->query($req);
                        try {
                            $bdd->getPdo()->query($historeq);
                        } catch(PDOException $e) {
                            die("Impossible d'ajouter à l'historique : ".$e->getMessage());
                        }
                    } catch(Exception $e) {
                        $erreur = "Erreur: Impossible de modifier la BDD".$e->getMessage();
                    }
                    header('Location: redirection.php'); 
                }
                /***** Retrait du stock *****/
                if(isset($_POST['submit-supp']) && ($_POST['etat'] === 'disponible')) {
                    $bdd->suppMaterielFromStock($_POST['id']);
                    $historeq = "INSERT INTO historique (date, reference, action, message) 
                                VALUES ('{$localdate}', '{$_POST['reference']}', 'Retrait du stock',
                                 'Un {$_POST['materiel']} a été retiré du stock.')";
                    try {
                        $bdd->getPdo()->query($historeq);
                    } catch(Exception $e) {
                        die("Impossible d'ajouter à l'historique : ".$e->getMessage());
                    }
                    header('Location: redirection.php'); 
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

            ?>
            <div class="stock-action">
<!-------------------------------------------- FORMULAIRE AJOUTER AU STOCK ---------------------------------------------------->
                <h3>Ajouter en stock</h3>
                <form action="index.php?menu=1" method="POST">
                    <ul class="stock-form">
                        <li>
                            <label for="reference">Référence</label><br/>
                            <input type="text" id="reference" name="reference" placeholder="Ex: N° de série"/>
                        </li>
                        <li>
                            <label for="materiel">*Matériel</label><br/>
                            <input type="text" id="materiel" name="materiel" required placeholder="Ex: clavier"/>
                        </li>
                        <li>
                            <label for="marque">Marque</label><br/>
                            <input type="text" id="marque" name="marque" placeholder="Ex: logitech"/>
                        </li>
                        <li>
                            <label for="nombre">Nombre à ajouter</label><br/>
                            <input type="number" id="number" name="number" min="1" max="50" value="1" placeholder="Max:50"/>
                        </li>
                        <li>
                            <label for="etat">*Etat</label><br/>
                            <input type="radio" id="etat" name="etat" value="disponible" checked/>Disponible
                            <input type="radio" id="etat" name="etat" value="déjà prêté"/>Prêté
                            <input type="radio" id="etat" name="etat" value="affecté"/>Affecté<br/>
                            <input type="radio" id="etat" name="etat" value="en réparation"/>En réparation
                            <input type="radio" id="etat" name="etat" value="rebut"/>Rebut
                        </li>
                        <li>
                            <label for="note">Note</label><br/>
                            <input type="text" id="note" name="note" placeholder="Facultatif"/>
                        </li>
                        <li>
                            <button type="submit" name="submit-stock">Ajouter au stock</button>
                        </li>
                    </ul>
                </form>
                <?php
                    if(isset($_POST["submit-edit"])) {
                ?>
                    <h3>Modification du stock</h3>
                    <div class="modif-stock">
                        <form class="modif" action="index.php?menu=1" method="POST">
                            <input type="hidden" value="<?php echo $_POST['id']; ?>" name="id-edit"/>
                            <label for="ref">Référence: </label>
                            <input type="text" id="ref-edit" name="ref-edit" value="<?php echo $_POST['ref']; ?>" required readonly><br/>
                            <label for="mat">Matériel: </label> 
                            <input type="text" id="mat-edit" name="mat-edit" value="<?php echo $_POST['materiel']; ?>" required placeholder=""/><br/>
                            <label for="marque">Marque: </label>
                            <input type="text" id="marque-edit" name="marque-edit" value="<?php echo $_POST['marque']; ?>" placeholder=""/>
                            <br/>
                            <label for="etat">Etat: </label> 
                            <input type="radio" id="etat-edit" name="etat-edit" value="disponible" checked/>Disponible
                            <input type="radio" id="etat-edit" name="etat-edit" value="affecté"/>Affecté
                            <input type="radio" id="etat-edit" name="etat-edit" value="en réparation"/>En réparation
                            <input type="radio" id="etat-edit" name="etat-edit" value="rebut"/>Rebut<br/>
                            <label for="note">Note: </label> 
                            <input type="text" id="note-edit" name="note-edit" value="<?php echo $_POST['note']; ?>"/><br/>
                            <button type="submit" name="confirm-edit" title="Confirmer">Confirmer</button>
                            <input type="hidden" value="<?php echo $_POST['id'] ?>" name="id"/>
                        </form>
                        <form action="index.php?menu=1" method="POST">
                            <button type="submit" name="cancel-edit" title="Annuler">Annuler</button>
                        </form>
                    </div>
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
                    <th class="button"></th>
                    <th class="button"></th>
                    <th class="button"></th>
                </tr>
                <?php 
                    $result = $bdd->getPdo()->query('SELECT *, COUNT(*) as number FROM stock GROUP BY reference, materiel, marque, etat, note'.$tri);
                    foreach($result as $res) {
                        $id; $ref; $mat; $marque; $etat; $note; $num;
                ?>  
                <tr class="stock-table">     
                    <td class="ref"><?php print $res['reference']; $id = $res['ident']; $ref = $res['reference']; ?></td>
                    <td><?php print $res['materiel']; $mat = $res['materiel']; ?></td>
                    <td><?php print $res['number']; $num = $res['number']; ?></td>
                    <td><?php print $res['marque']; $marque = $res['marque']; ?></td>
                    <td><?php print $res['etat']; $etat = $res['etat']; ?></td>
                    <td><?php print $res['note']; $note = $res['note']; ?></td>
                    <td class="button">
                        <form action="<?php if($etat !== 'disponible') { echo("index.php?menu=1"); } else { echo("index.php?menu=2"); }?>" method="POST">
                            <button type="submit" name="submit-add" title="Ajouter aux prêts">
                            <input type="hidden" value="<?php echo $ref ?>" name="ref"/>
                            <input type="hidden" value="<?php echo $mat ?>" name="mat"/>
                            <input type="hidden" value="<?php echo $marque ?>" name="marque"/>
                            <input type="hidden" value="<?php echo $note ?>" name="note"/>
                            <input type="hidden" value="<?php echo $num ?>" name="number"/>
                            <img src="../images/ajouter.png" alt="ajouter" height="20px">
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
                            <img src="../images/modifier.png" alt="modifier" height="20px">
                        </form>
                    </td>
                    <td class="button">
                        <form action="index.php?menu=1" method="POST">
                            <button type="submit" name="submit-supp" title="Supprimer">
                            <input type="hidden" value="<?php echo $etat; ?>" name="etat"/>
                            <input type="hidden" value="<?php echo $mat; ?>" name="materiel"/>
                            <input type="hidden" value="<?php echo $ref; ?>" name="reference"/>
                            <input type="hidden" value="<?php echo $id; ?>" name="id"/>
                            <img src="../images/basket.png" alt="supprimer" height="20px">
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
                    if($_POST['start'] < $_POST['end']) {
                        $requete = "SELECT * FROM stock WHERE reference = '{$_POST['ref']}' AND materiel = '{$_POST['mat']}' 
                            AND marque = '{$_POST['marque']}' AND etat = 'disponible' AND note = '{$_POST['note']}'  LIMIT {$_POST['number']}";
                        try {
                            $result = $bdd->getPdo()->query($requete);
                            foreach($result as $res) {
                                $requete = "INSERT INTO pret (ident, reference, start, end, client) 
                                            VALUES ('{$res['ident']}', '{$res['reference']}', '{$_POST['start']}', '{$_POST['end']}', '{$_POST['client']}')";
                                $historeq = "INSERT INTO historique (date, reference, action, message) 
                                            VALUES ('{$localdate}', '{$res['reference']}', 'Ajout aux prêts',
                                            'Un {$res['materiel']} a été prêté à {$_POST['client']} du {$_POST['start']} au {$_POST['end']}.')";
                                $updatereq = "UPDATE stock SET etat = 'déjà prêté' WHERE ident = '{$res['ident']}'";
                                $bdd->getPdo()->query($requete);
                                try {
                                    $bdd->getPdo()->query($updatereq);
                                    try {
                                        $bdd->getPdo()->query($historeq);
                                    } catch(Exception $e) {
                                        die("Impossible d'ajouter à l'historique : ". $e->getMessage());
                                    }
                                } catch (Exception $e) {
                                    die("Impossible d'actualiser le stock : ".$e->getMessage());
                                }
                            }
                        } catch(Exception $e) {
                            die("Impossible d'ajouter aux prêts : ".$e->getMessage());
                        }
                    }                                                                                                       
                    header('Location: redirection.php');  
                }
                /***** Modifier un prêt *****/
                if(isset($_POST['confirm-edit'])) {
                    if($_POST['start'] < $_POST['end']) {
                        $requete = "UPDATE pret SET start = '{$_POST['start']}', end = '{$_POST['end']}', 
                        client = '{$_POST['client']}' WHERE ident = '{$_POST['id-edit']}'";
                        try {
                            $historeq = "INSERT INTO historique (date, reference, action, message) 
                                        VALUES ('{$localdate}', '{$_POST['ref-edit']}', 'Modification de prêt',
                                        'Le prêt de {$_POST['mat-edit']} à {$_POST['client']} du {$_POST['start']} au {$_POST['end']} a été modifié.')";
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
                if(isset($_POST['submit-supp'])) {
                    $req = "DELETE FROM pret WHERE ident = {$_POST['id']} ";
                    $updatereq = "UPDATE stock SET etat = 'disponible' 
                                    WHERE ident = {$_POST['id']}";
                    try {
                        $bdd->getPdo()->query($req);
                        try {
                            $client = str_replace('\'', ' ', $_POST['client']);
                            $historeq = "INSERT INTO historique (date, reference, action, message) 
                                        VALUES ('{$localdate}', '{$_POST['ref']}', 'Suppression de prêt',
                                        'Le prêt de {$_POST['materiel']} à {$client} du {$_POST['start']} au {$_POST['end']} a été supprimé.')";
                            $bdd->getPdo()->query($updatereq);
                            try {
                                $bdd->getPdo()->query($historeq);
                            } catch(Exception $e) {
                                die("Impossible d'ajouter dans l'historique : ".$e->getMessage());
                            }
                        } catch (Exception $e) {
                            die("Impossible de mettre à jour le stock. ".$e->getMessage());
                        }
                    } catch(Exception $e) {
                        die("Erreur: Impossible de supprimer dans la BDD".$e->getMessage());
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
                ?>
            
            <div class="pret-action">
<!----------------------------------------------AJOUTER AUX PRETS-------------------------------------------------------------->
                <h3>Effectuer un prêt</h3>
                <form action="index.php?menu=2" method="POST">
                    <ul class="pret-form">
                        <li>
                            <label for="reference">Référence</label><br/>
                            <input type="text"   id="ref"    name="ref"    value="<?php if(isset($_POST['submit-add'])) echo($_POST['ref']);    ?>" required placeholder=""/>
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
                            <button type="submit" name="submit-pret">Confirmer la demande</button>
                        </li>
                    </ul>
                </form>
                <?php
                    if(isset($_POST["submit-edit"])) {
                ?>
                    <h3>Modification du prêt</h3>
                    <div class="modif-pret">
                        <form class="edit" action="index.php?menu=2" method="POST">
                            <input type="hidden" value="<?php echo $_POST['id']; ?>" name="id-edit"/>
                            <label for="ref">Référence: </label>
                            <input type="text" id="ref-edit" name="ref-edit" value="<?php echo $_POST['ref']; ?>" required readonly/>
                            <label for="mat">Matériel: </label> 
                            <input type="text" id="mat-edit" name="mat-edit" value="<?php echo $_POST['materiel']; ?>" required placeholder="" readonly/>
                            <label for="marque">Marque: </label>
                            <input type="text" id="marque-edit" name="marque-edit" value="<?php echo $_POST['marque']; ?>" placeholder="" readonly/>
                            <label for="note">Note: </label> 
                            <input type="text" id="note-edit" name="note-edit" value="<?php echo $_POST['note']; ?>" readonly/>
                            <label for="start">*Début du prêt</label>
                            <input type="date" id="start" name="start" value="<?php echo $_POST['start']; ?>" required/>
                            <label for="end">*Fin du prêt</label>
                            <input type="date" id="end" name="end" value="<?php echo $_POST['end']; ?>" required/>
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
                        <th></th>
                        <th></th>
                    </tr>
                    <?php 
                        $result = $bdd->getPdo()->query("SELECT * FROM stock INNER JOIN pret ON stock.ident = pret.ident WHERE etat = 'déjà prêté'".$tri);
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
                        <td class="marque"><?php print $res['marque']; ?></td>
                        <td class="note"><?php print $res['note']; ?></td>
                        <td class="start"><?php print $res['start']; ?></td>
                        <td class="end"><?php print $res['end']; ?></td>
                        <td class="client"><?php print $res['client']; ?></td>
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
                                <img src="../images/modifier.png" alt="modifier" height="20px">
                            </form>
                         </td>
                        <td class="button">
                            <form action="index.php?menu=2" method="POST">
                                <button type="submit" name="submit-supp" title="Supprimer">
                                <input type="hidden" value="<?php echo $res['ident']; ?>" name="id"/>
                                <input  type="hidden" value="<?php echo $res['reference']; ?>" name="ref"/>
                                <input  type="hidden" value="<?php echo $res['materiel']; ?>"     name="materiel"/>
                                <input  type="hidden" value="<?php echo $res['start']; ?>"     name="start"/>
                                <input  type="hidden" value="<?php echo $res['end']; ?>"       name="end"/>
                                <input  type="hidden" value="<?php echo $res['client']; ?>"    name="client"/>
                                <img src="../images/basket.png" alt="supprimer" height="20px">
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
                if(isset($_POST['submit-message'])) {
                    $trie = ' ORDER BY message';
                }

                if(isset($_POST['submit-histo'])) {
                    try {
                        $requete = "SELECT * FROM historique";
                        $result = $bdd->getPdo()->query($requete);
                        $export .= '
                            <table>
                            <tr>
                            <td>id</id>
                            <td>date</id>
                            <td>reference</id>
                            <td>action</id>
                            <td>message</id>
                            </tr>
                        ';
                        foreach($result as $res) {
                            $export .= '
                                <tr>
                                <td>'.$res['id'].'</td>
                                <td>'.$res['date'].'</td>
                                <td>'.$res['reference'].'</td>
                                <td>'.$res['action'].'</td>
                                <td>'.$res['message'].'</td>
                                </tr>
                            ';
                        }
                        $export .= '</table>';
                        $fileName = "historique-".$localdate.".xls";
                        header('Content-Type: application/xls');
                        header('Content-Disposition: attachment; filename='.$fileName);
                        echo $export;
                    } catch (Exception $e) {
                        echo("Impossible de récupérer l'historique : ". $e->getMessage());
                    }
                    
                }
            ?>
            <div class="export">
                <h3 class="title-histo">Tout l'historique</h3>
                <form name="submit-histo" action="index.php?menu=3" method="POST">
                    <input type="submit" name="submit-histo" value="Exporter l'historique en .xls"/>
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
                    <th class="message">
                        <form action="index.php?menu=3" method="POST">
                            <button type="submit" name="submit-message" title="Trier par message">Message</button>
                        </form>
                    </th>
                </tr>
                <?php
                    $result = $bdd->getPdo()->query("SELECT * FROM historique ".$trie);
                    foreach($result as $res) {
                ?>
                <tr class="historique-table">
                    <td><?php print $res['date']; ?></td>
                    <td><?php print $res['action']; ?></td>
                    <td><?php print $res['reference']; ?></td>
                    <td><?php print $res['message']; ?></td>
                </tr>
                <?php
                    }
                ?>
            </table>
        </div>
<!------------------------------------------------------------------------------------------------------------------------------
--------------------------------------------------------------------------------------------------------------------------------
------------------------------------------------------CASE 4 SE CONNECTER-------------------------------------------------------
--------------------------------------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------------------->
        <?php
                break;
                case 4:
        ?>
        <div class="log-in">
            <p>Non fonctionnel</p>
        </div>
        <?php            
                break;
            }
        ?>
    </div>

<!-------------------------------------------------------FOOTER CONSOLE-------------------------------------------------------->
    <div class="footer">
<!-----------------------------------------------------ACTIONS CONSOLE--------------------------------------------------------->
        
        <div class="footer-content">
            <p>Message d'erreur :</p>
            <p><?php echo($erreur); ?></p>
        </div>
    </div>
</body>