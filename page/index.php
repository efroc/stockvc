<!DOCTYPE html>
<html lang="fr">
<!----------------------------------------------------- HEAD PAGE ------------------------------------------------------------->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <!--<meta http-equiv="refresh" content="60">-->
    <link href="css/index.css" rel="stylesheet"/>
    <title>Stock Informatique Vitré Communauté</title>
    <link rel="website icon" type="png" href="../ressources/images/VClogo.png"/>
</head>

<!----------------------------------------------------- BODY PAGE ------------------------------------------------------------->
<body>

<!------------------------------------------------------- MENU ---------------------------------------------------------------->
    <h1 class="title"><p>Gestion du stock et des prêts</p></h1>
    <ul class="menu">
        <li style="float:left"><a class="redirection" target="_blank" href="https://www.vitrecommunaute.org/"><img src="../ressources/images/VClogo.png" alt="logo" height="59px"></a></li>
        <li style="float:left"><a class="redirection" target="_blank" href="https://www.mairie-vitre.com/"><img src="../ressources/images/mairielogo.png" alt="logo" height="59px"></a></li>
        <li><a href="index.php?menu=1"><p class="menu-text">Stock</p></a></li>
        <li><a href="index.php?menu=2"><p class="menu-text">Prêts et Alertes</p></a></li>
        <li><a href="index.php?menu=3"><p class="menu-text">Historique</p></a></li>
        <li style="float:right"><a class="login" href="index.php?menu=4"><p class="menu-text">Se connecter</p></a></li> 
    </ul>

<!--------------------------------------------------- CONNEXION BDD ----------------------------------------------------------->
    <?php
        require '../src/traitement/BDD.php';
        require '../src/class/Stock.php';
        require '../src/traitement/Erreur.php';
        $bdd = new BDD();
        $bdd->connect();
        $localdate = date('Y-m-d');
        echo("Date du jour : ". $localdate);
    ?>

<!----------------------------------------------- AFFICHAGE SELON MENU -------------------------------------------------------->
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
<!---------------------------------------------- FORMULAIRE VERS BDD ---------------------------------------------------------->
                <?php
                    if(isset($_POST['submit-stock'])) {
                        $newmat = new Materiel($_POST['reference'], strtolower($_POST['materiel']), strtolower($_POST['marque']), 
                                strtolower($_POST['etat']), strtolower($_POST['note']));
                        
                        for($i = 0; $i < $_POST['number']; $i++) {
                            $bdd->addMaterielToStock($newmat);
                        }        
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
<!------------------------------------------------ BOUTONS DE TRI ------------------------------------------------------------->
                <?php 
                    $trie ="";
                    $state;
                    $id;
                    $ref ="";
                    if(isset($_POST['submit-reference'])) {
                        $trie = ' ORDER BY reference';
                    }
                    if(isset($_POST['submit-materiel'])) {
                        $trie = ' ORDER BY materiel';
                    }
                    if(isset($_POST['submit-nb'])) {
                        $trie = ' ORDER BY number';
                    }
                    if(isset($_POST['submit-etat'])) {
                        $trie = ' ORDER BY etat';
                    } 
                    if(isset($_POST['submit-marque'])) {
                        $trie = ' ORDER BY marque';
                    }
                    if(isset($_POST['submit-note'])) {
                        $trie = ' ORDER BY note DESC';
                    }
                    $result = $bdd->getPdo()->query('SELECT *, COUNT(*) as number FROM stock GROUP BY reference, materiel, marque, etat, note'.$trie);
                    foreach($result as $res) {
                ?>  
                <tr class="stock-table">     
                    <td><?php print $res['reference']; $id = $res['ident']; ?></td>
                    <td><?php print $res['materiel']; ?></td>
                    <td><?php print $res['number']; ?></td>
                    <td><?php print $res['marque']; ?></td>
                    <td><?php print $res['etat']; $state = $res['etat']; ?></td>
                    <td><?php print $res['note']; ?></td>
                    <td class="button">
                        <form action="index.php?menu=2" method="POST">
                            <button type="submit" name="submit-add" title="Ajouter aux prêts">
                            <input type="hidden" value="<?php echo $res['reference']; ?>" name="id"/>
                            <img src="../ressources/images/ajouter.png" alt="ajouter" height="20px">
                            </button>
                        </form>
                    </td>
                    <td class="button">
                        <form action="index.php?menu=1" method="POST">
                            <button type="submit" name="submit-edit" title="Modifier">
                            <input type="hidden" value="<?php echo $id; ?>" name="id"/>
                            <img src="../ressources/images/modifier.png" alt="modifier" height="20px">
                        </form>
                    </td>
                    <td class="button">
                        <form action="index.php?menu=1" method="POST">
                            <button type="submit" name="submit-supp" title="Supprimer">
                            <input type="hidden" value="<?php echo $id; ?>" name="id"/>
                            <img src="../ressources/images/basket.png" alt="supprimer" height="20px">
                            </button>
                        </form>
                    </td>
                </tr>
<!------------------------------------------ BOUTONS DES ACTIONS DU STOCK ----------------------------------------------------->
                <?php
                    }
                    if(isset($_POST['submit-supp'])) {
                        $bdd->suppMaterielFromStock($_POST['id']);
                    }
                ?>
            </table>   
            <br/>
            <?php
                if(isset($_POST["submit-edit"])) {
                    $id = $_POST['id'];
            ?>
                    <form action="index.php?menu=1" method="POST">
                        <label for="materiel">*Matériel: </label>
                        <input type="text" id="mat-edit" name="mat-edit" required placeholder=""/>
                        <label for="marque">*Marque: </label>
                        <input type="text" id="marque-edit" name="marque-edit" required placeholder=""/>
                        <label for="note">Note: </label>
                        <input type="text" id="note-edit" name="note-edit" placeholder=""/>
                        <button type="submit" name="edit" title="Modifier">Modifier</button>
                    </form>  
                    <form action="index.php?menu=1" method="POST">
                        <button type="submit" name="cancel" title="Annuler">Annuler</button>
                    </form>
            <?php
                    if(isset($_POST["edit"])) {
                        $req = "UPDATE stock SET materiel = {$_POST['mat-edit']}, marque = {$_POST['marque-edit']}, 
                        note = {$_POST['note-edit']} WHERE ident = {$id}";
                        try {
                            $bdd->getPdo()->exec($req);
                        } catch(Exception $e) {
                            die("Erreur: Impossible de modifier la BDD".$e->getMessage());
                        }
                    }
                }
            ?>
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
            <div class="pret-action">
<!----------------------------------------------------PRET ACTIONS------------------------------------------------------------->
                <h3>Effectuer un prêt</h3>
                <form action="index.php?menu=2" method="POST">
                    <ul class="pret-form">
                        <li>
                            <label for="reference">Référence</label><br/>
                            <input type="text" id="reference" name="reference" value="<?php if(isset($_POST['submit-add'])) echo($_POST['id']);?>" required placeholder=""/>
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
                    if(isset($_POST['submit-pret'])) {
                        $id = $_POST['id'];
                        $ref = strtolower($_POST['reference']);
                        $start = strtolower($_POST['start']);
                        $end = strtolower($_POST['end']);
                        $client = strtolower($_POST['client']);

                        if($start < $end) {
                            $req = "INSERT INTO pret (reference, start, end, client) 
                                    VALUES ('$ref', '$start', '$end', '$client')";
                            $updatereq = "UPDATE stock SET etat = 'déjà prêté' 
                                            WHERE ident = '{$id}'";
                            try {
                                $bdd->getPdo()->query($req);
                                $bdd->getPdo()->query($updatereq);
                            } catch(Exception $e) {
                                die("Erreur: Impossible d'ajouter dans la BDD".$e->getMessage());
                            }
                        }
                    }
                ?>
<!--------------------------------------------------- LISTE DES ALERTES ------------------------------------------------------->
                <h3>Alertes</h3>
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
<!-----------------------------------------------BOUTONS DE TRI DES PRETS------------------------------------------------------>
                    <?php 
                        $trie = "";
                        if(isset($_POST['submit-reference'])) {
                            $trie = ' ORDER BY reference';
                        }
                        if(isset($_POST['submit-start'])) {
                            $trie = ' ORDER BY start';
                        }
                        if(isset($_POST['submit-end'])) {
                            $trie = ' ORDER BY end';
                        }
                        if(isset($_POST['submit-client'])) {
                            $trie = ' ORDER BY client';
                        }
                        $result = $bdd->getPdo()->query('SELECT * FROM stock INNER JOIN pret ON stock.reference = pret.reference'.$trie);
                        foreach($result as $res) {
                    ?>
                    <tr class="pret-table">
                        <td class="ref"><?php print $res['reference']; $id = $res['ident']; ?></td>
                        <td class="mat"><?php print $res['materiel']; ?> </td>
                        <td class="marque"><?php print $res['marque']; ?></td>
                        <td class="note"><?php print $res['note']; ?></td>
                        <td class="start"><?php print $res['start']; ?></td>
                        <td class="end"><?php print $res['end']; ?></td>
                        <td class="client"><?php print $res['client']; ?></td>
                        <td class="button">
                            <form action="index.php?menu=2" method="POST">
                                <button type="submit" name="submit-edit" title="Modifier">
                                <input type="hidden" value="<?php echo $id; ?>" name="id"/>
                                <img src="../ressources/images/modifier.png" alt="modifier" height="20px">
                            </form>
                         </td>
                        <td class="button">
                            <form action="index.php?menu=2" method="POST">
                                <button type="submit" name="submit-supp" title="Supprimer">
                                <input type="hidden" value="<?php echo $id; ?>" name="id"/>
                                <img src="../ressources/images/basket.png" alt="supprimer" height="20px">
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php
                        }
                        if(isset($_POST['submit-supp'])) {
                            $req = "DELETE FROM pret WHERE ident = {$_POST['id']} ";
                            $updatereq = "UPDATE stock SET etat = 'disponible' 
                                            WHERE ident = {$_POST['id']}";
                            $bdd->getPdo()->exec($req);
                            try {
                                $bdd->getPdo()->query($updatereq);
                                $bdd->getPdo()->query($req);
                            } catch(Exception $e) {
                                die("Erreur: Impossible de supprimer dans la BDD".$e->getMessage());
                            }
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
            <h3>Tout l'historique</h3>
            <table>
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
<!-----------------------------------------------------BOUTONS DE TRI HISTORIQUE----------------------------------------------->
                <?php
                    $trie ="";
                    if(isset($_POST['submit-date'])) {
                        $trie = ' ORDER BY date';
                    }
                    if(isset($_POST['submit-action'])) {
                        $trie = ' ORDER BY action';
                    }
                    if(isset($_POST['submit-reference'])) {
                        $trie = ' ORDER BY identMateriel';
                    }
                    if(isset($_POST['submit-message'])) {
                        $trie = ' ORDER BY message';
                    }
                    $result = $bdd->getPdo()->query("SELECT * FROM historique ".$trie);
                    foreach($result as $res) {
                ?>
                <tr class="historique-table">
                    <td><?php print $res['date']; ?></td>
                    <td><?php print $res['action']; ?></td>
                    <td><?php print $res['identMateriel']; ?></td>
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

        <?php            
                break;
            }
        ?>

    </div>
    <!--
    <footer>
        <p>Salut</p>
    </footer>
        -->
</body>