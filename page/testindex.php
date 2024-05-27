<!DOCTYPE html>
<html lang="fr">
<!----------------------------------------------------- HEAD PAGE ------------------------------------------------------------->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <!--<meta http-equiv="refresh" content="60">-->
    <link href="css/testcss.css" rel="stylesheet"/>
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
        <li><a href="testindex.php?menu=1"><p class="menu-text">Stock</p></a></li>
        <li><a href="testindex.php?menu=2"><p class="menu-text">Prêts et Alertes</p></a></li>
        <li><a href="testindex.php?menu=3"><p class="menu-text">Historique</p></a></li>
        <li style="float:right"><a class="login" href="testindex.php?menu=3"><p class="menu-text">Se connecter</p></a></li> 
    </ul>

<!--------------------------------------------------- CONNEXION BDD ----------------------------------------------------------->
    <?php
        require '../src/traitement/BDD.php';
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
                <form action="testindex.php?menu=1" method="POST">
                    <ul class="stock-form">
                        <li>
                            <label for="reference">*Référence</label>
                            <input type="text" id="reference" name="reference" required placeholder=""/>
                        </li>
                        <li>
                            <label for="materiel">*Matériel</label>
                            <input type="text" id="materiel" name="materiel" required placeholder="Ex: clavier"/>
                        </li>
                        <li>
                            <label for="marque">*Marque</label>
                            <input type="text" id="marque" name="marque" required placeholder="Ex: logitech"/>
                        </li>
                        <li>
                            <label for="etat">*Etat</label>
                            <input type="radio" id="etat" name="etat" value="disponible" checked/>Disponible
                            <input type="radio" id="etat" name="etat" value="déjà prêté"/>Prêté
                            <input type="radio" id="etat" name="etat" value="affecté"/>Affecté
                            <input type="radio" id="etat" name="etat" value="en réparation"/>En réparation
                            <input type="radio" id="etat" name="etat" value="rebut"/>Rebut
                        </li>
                        <li>
                            <label for="note">Note</label>
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
                        $ref = $_POST['reference'];
                        $mat = strtolower($_POST['materiel']);
                        $marque = strtolower($_POST['marque']);
                        $etat = strtolower($_POST['etat']);
                        $note = strtolower($_POST['note']);
                        $histo = "Le matériel suivant a été ajouté au stock. Matériel : ".$mat. 
                                 " | Marque : ".$marque. " | Etat : " .$etat. " | Note : " .$note;
                        $req = "INSERT INTO stock (ident, materiel, marque, etat, note) VALUES ('$ref', '$mat', '$marque', '$etat', '$note')";
                        try {
                            $bdd->getPdo()->query($req);
                            $req = "INSERT INTO historique (identMateriel, message, date) VALUES ('$ref', '$histo', '$localdate')";
                            try {
                                $bdd->getPdo()->query($req);
                            }
                            catch(Exception $e) {
                                die("Erreur: Impossible d'ajouter dans l'historique".$e->getMessage());
                            }
                        } catch(Exception $e) {
                            die("Erreur: Impossible d'ajouter dans la BDD".$e->getMessage());
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
                        <form action="testindex.php?menu=1" method="POST">
                            <button type="submit" name="submit-reference" title="Trier par référence">Référence</button>
                        </form>
                    </th>
                    <th class="mat">
                        <form action="testindex.php?menu=1" method="POST">
                            <button type="submit" name="submit-materiel" title="Trier par matériel">Matériel</button>
                        </form>
                    </th>
                    <th class="marque">
                        <form action="testindex.php?menu=1" method="POST">
                            <button type="submit" name="submit-marque" title="Trier par marque">Marque</button>
                        </form>
                    </th>
                    <th class="etat">
                        <form action="testindex.php?menu=1" method="POST">
                            <button type="submit" name="submit-etat" title="Trier par état">Etat</button>
                        </form>
                    </th>
                    <th class="note">
                        <form action="testindex.php?menu=1" method="POST">
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
                    $id;
                    if(isset($_POST['submit-reference'])) {
                        $trie = ' ORDER BY ident';
                    }
                    if(isset($_POST['submit-materiel'])) {
                        $trie = ' ORDER BY materiel';
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
                    $result = $bdd->getPdo()->query('SELECT * FROM stock'.$trie);
                    foreach($result as $res) {
                ?>  
                <tr class="stock-table">     
                    <td><?php print $res['ident']; $id = $res['ident']; ?></td>
                    <td><?php print $res['materiel']; ?></td>
                    <td><?php print $res['marque']; ?></td>
                    <td><?php print $res['etat']; $state = $res['etat']; ?></td>
                    <td><?php print $res['note']; ?></td>
                    <td class="button">
                        <form action="testindex.php?menu=2" method="POST">
                            <button type="submit" name="submit-add" title="Ajouter aux prêts">
                            <input type="hidden" value="<?php echo $id; ?>" name="id"/>
                            <img src="../ressources/images/ajouter.png" alt="ajouter" height="20px">
                            </button>
                        </form>
                    </td>
                    <td class="button">
                        <form action="testindex.php?menu=1" method="POST">
                            <button type="submit" name="submit-edit" title="Modifier">
                            <input type="hidden" value="<?php echo $id; ?>" name="id"/>
                            <img src="../ressources/images/modifier.png" alt="modifier" height="20px">
                        </form>
                    </td>
                    <td class="button">
                        <form action="testindex.php?menu=1" method="POST">
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
                    if(isset($_POST['submit-supp']) && $state === "disponible") {
                        $req = "DELETE FROM stock WHERE ident = {$_POST['id']} ";
                        $bdd->getPdo()->exec($req);
                        try {
                            $bdd->getPdo()->query($req);
                        } catch(Exception $e) {
                            die("Erreur: Impossible de supprimer dans la BDD".$e->getMessage());
                        }
                    }
                    
                ?>
            </table>   
            <br/>
            <?php
                if(isset($_POST["submit-edit"])) {
            ?>
                    <form action="testindex.php?menu=1" method="POST">
                        <label for="materiel">*Matériel: </label>
                        <input type="text" id="mat-edit" name="mat-edit" required placeholder=""/>
                        <label for="marque">*Marque: </label>
                        <input type="text" id="marque-edit" name="marque-edit" required placeholder=""/>
                        <label for="note">Note: </label>
                        <input type="text" id="note-edit" name="note-edit" placeholder=""/>
                        <button type="submit" name="edit" title="Modifier">Modifier</button>
                    </form>  
                    <form action="testindex.php?menu=1" method="POST">
                        <button type="submit" name="cancel" title="Annuler">Annuler</button>
                    </form>
            <?php
                    if(isset($_POST["edit"])) {
                        $req = "UPDATE stock SET materiel = {$_POST['mat-edit']}, marque = {$_POST['marque-edit']}, 
                        note = {$_POST['note-edit']} WHERE ident = {$_POST['id']}";
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
                <form action="testindex.php?menu=2" method="POST">
                    <ul class="pret-form">
                        <li>
                            <label for="reference">*Référence :</label>
                            <input type="text" id="reference" name="reference" value="<?php if(isset($_POST['id'])) echo $_POST['id'];?>" required placeholder=""/>
                        </li>
                        <li>
                            <label for="client">*Client :</label>
                            <input type="text" id="client" name="client" required/>
                        </li>
                        <li>
                            <label for="start">*Début du prêt :</label>
                            <input type="date" id="start" name="start" value="<?php echo $localdate; ?>" required/>
                        </li>
                        <li>
                            <label for="end">*Fin du prêt :</label>
                            <input type="date" id="end" name="end" required/>
                        </li>
                        <li>
                            <button type="submit" name="submit-pret">Confirmer la demande</button>
                        </li>
                    </ul>
                </form>
                <?php
                    if(isset($_POST['submit-pret'])) {
                        $ref = strtolower($_POST['reference']);
                        $start = strtolower($_POST['start']);
                        $end = strtolower($_POST['end']);
                        $client = strtolower($_POST['client']);

                        if($start < $end) {
                            $req = "INSERT INTO pret (ident, start, end, client) 
                                    VALUES ('$ref', '$start', '$end', '$client')";
                            $updatereq = "UPDATE stock SET etat = 'déjà prêté' 
                                            WHERE ident = '{$ref}'";
                            try {
                                $bdd->getPdo()->query($req);
                                $bdd->getPdo()->query($updatereq);
                            } catch(Exception $e) {
                                die("Erreur: Impossible d'ajouter dans la BDD".$e->getMessage());
                            }
                        }
                    }
                ?>
                <!------------------------ LISTE DES ALERTES ----------------------------->
                <h3>Alertes</h3>
            </div>
<!-----------------------------------------------------LISTE DES PRETS--------------------------------------------------------->
            <div class="pret-liste">
                <h3>Liste des prêts en cours</h3>
                <table>
                    <tr class="pret-table">
                        <th class="ref">
                            <form action="testindex.php?menu=2" method="POST">
                                <button type="submit" name="submit-reference" title="Trier par référence">Référence</button>
                            </form>
                        </th>
                        <th class="mat">
                            <form action="testindex.php?menu=2" method="POST">
                                <button type="submit" name="submit-materiel" title="Trier par materiel">Matériel</button>
                            </form>
                        </th>
                        <th class="marque">
                            <form action="testindex.php?menu=2" method="POST">
                                <button type="submit" name="submit-marque" title="Trier par marque">Marque</button>
                            </form>
                        </th>
                        <th class="note">
                            <form action="testindex.php?menu=2" method="POST">
                                <button type="submit" name="submit-note" title="Trier par note">Note</button>
                            </form>
                        </th>
                        <th class="start">
                            <form action="testindex.php?menu=2" method="POST">
                                <button type="submit" name="submit-start" title="Trier par date de début">Début du prêt</button>
                            </form>
                        </th>
                        <th class="end">
                            <form action="testindex.php?menu=2" method="POST">
                                <button type="submit" name="submit-end" title="Trier par date de fin">Fin du prêt</button>
                            </form>
                        </th>
                        <th class="client">
                            <form action="testindex.php?menu=2" method="POST">
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
                            $trie = ' ORDER BY ident';
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
                        $result = $bdd->getPdo()->query('SELECT * FROM stock INNER JOIN pret ON stock.ident = pret.ident'.$trie);
                        foreach($result as $res) {
                    ?>
                    <tr class="pret-table">
                        <td class="ref"><?php print $res['ident']; $id = $res['ident']; ?></td>
                        <td class="mat"><?php print $res['materiel']; ?> </td>
                        <td class="marque"><?php print $res['marque']; ?></td>
                        <td class="note"><?php print $res['note']; ?></td>
                        <td class="start"><?php print $res['start']; ?></td>
                        <td class="end"><?php print $res['end']; ?></td>
                        <td class="client"><?php print $res['client']; ?></td>
                        <td class="button">
                            <form action="testindex.php?menu=2" method="POST">
                                <button type="submit" name="submit-edit" title="Modifier">
                                <input type="hidden" value="<?php echo $id; ?>" name="id"/>
                                <img src="../ressources/images/modifier.png" alt="modifier" height="20px">
                            </form>
                         </td>
                        <td class="button">
                            <form action="testindex.php?menu=2" method="POST">
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
                        <form action="testindex.php?menu=3" method="POST">
                            <button type="submit" name="submit-date" title="Trier par date">Date</button>
                        </form>
                    </th>
                    <th class="ref">
                        <form action="testindex.php?menu=3" method="POST">
                            <button type="submit" name="submit-reference" title="Trier par référence">Référence</button>
                        </form>
                    </th>
                    <th class="message">
                        <form action="testindex.php?menu=3" method="POST">
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
                    if(isset($_POST['submit-reference'])) {
                        $trie = ' ORDER BY identMateriel';
                    }
                    if(isset($_POST['submit-message'])) {
                        $trie = ' ORDER BY message';
                    }
                    $result = $bdd->getPdo()->query("SELECT * FROM historique ".$trie);
                    foreach($result as $res) {
                ?>
                <tr>
                    <td><?php print $res['date']; ?></td>
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