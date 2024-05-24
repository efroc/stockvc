<!DOCTYPE html>
<html lang="fr">
<!-------------------------------------------- HEAD PAGE -------------------------------->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <!--<meta http-equiv="refresh" content="60">-->
    <link href="css/testcss.css" rel="stylesheet"/>
    <title>Stock Informatique Vitré Communauté</title>
    <link rel="website icon" type="png" href="../ressources/images/VClogo.png"/>
</head>

<!----------------------------------------- BODY PAGE ----------------------------------->
<body>

    <!--------------------------------------- MENU -------------------------------------->
    <h1 class="title"><p>Gestion du stock et des prêts</p></h1>
    <ul class="menu">
        <li style="float:left"><a target="_blank" href="https://www.vitrecommunaute.org/"><img src="../ressources/images/VClogo.png" alt="logo" height="59px"></a></li>
        <li><a href="testindex.php?menu=1"><p class="menu-text">Stock</p></a></li>
        <li><a href="testindex.php?menu=2"><p class="menu-text">Prêts et Alertes</p></a></li>
        <li style="float:right"><a href="testindex.php?menu=3"><p class="menu-text">Se connecter</p></a></li> 
    </ul>

    <!--------------------------------- CONNEXION BDD ----------------------------------->
    <?php
        require '../src/traitement/BDD.php';
        $bdd = new BDD();
        $bdd->connect();
    ?>

    <!----------------------------- AFFICHAGE SELON MENU -------------------------------->
    <div class="contenu">
        <?php
            if(isset($_GET['menu'])) switch($_GET['menu']) {
                case 1:
        ?>            
        <!-------------------------------- CASE 1 --------------------------------------->
        <!-------------------------------- STOCK ---------------------------------------->
        <div class="stock">
            <div class="stock-action">
                <!-------------------- AJOUTE AU STOCK ---------------------------------->
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
                            <input type="radio" id="etat" name="etat" value="en réparation"/>En réparation
                        </li>
                        <li>
                            <label for="note">Note</label>
                            <input type="text" id="note" name="note" placeholder="Facultatif"/>
                        </li>
                        <li>
                            <button type="submit" name="submit">Ajouter au stock</button>
                        </li>
                    </ul>
                </form>
                <!-------------------- FORMULAIRE VERS BDD ------------------------------>
                <?php
                    if(isset($_POST['submit'])) {
                        $ref = $_POST['reference'];
                        $mat = strtolower($_POST['materiel']);
                        $marque = strtolower($_POST['marque']);
                        $etat = strtolower($_POST['etat']);
                        $note = strtolower($_POST['note']);
                        $req = "INSERT INTO stock (ident, materiel, marque, etat, note) VALUES ('$ref', '$mat', '$marque', '$etat', '$note')";
                        try {
                            $bdd->getPdo()->query($req);
                        } catch(Exception $e) {
                            die("Erreur: Impossible d'ajouter dans la BDD".$e->getMessage());
                        }
                    }   
                ?>
            </div>

            <!-------------------------- AFFICHE STOCK ---------------------------------->
            <div class="stock-list">
            <h3>Tout le stock</h3>
            <table>
                <tr>
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
                <!--------------------------- BOUTONS DE TRIE --------------------------->
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
                <tr>     
                    <td><?php print $res['ident']; $id = $res['ident']; ?></td>
                    <td><?php print $res['materiel']; ?></td>
                    <td><?php print $res['marque']; ?></td>
                    <td><?php print $res['etat']; ?></td>
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
                <!------------------------ BOUTONS ACTIONS ------------------------------>
                <?php
                    }
                    if(isset($_POST['submit-supp'])) {
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











        <?php            
                break;
                case 2:
        ?>
        <!------ CASE 2 --------->


        <?php
                break;
                case 3:
        ?>
        <!------ CASE 3 --------->
        <!---- SE CONNECTER ----->


        <?php            
                break;
            }
        ?>
    </div>


</body>