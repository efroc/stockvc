<!DOCTYPE html>
<html lang="fr">
<!---------- HEAD PAGE ---------->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <!--<meta http-equiv="refresh" content="60">-->    <!--Auto refresh chaque minute -->
    <link href="css/stock.css" rel="stylesheet"/>
    <title>Stock Informatique Vitré Communauté</title>
    <link rel="website icon" type="png" href="../ressources/images/VClogo.png"/>
</head>

<!---------- BODY PAGE ---------->
<body>
    <ul class="menu">
        <li><img src="../ressources/images/VClogo.png" alt="logo" height="42px"></li>
        <li><a href="indexS.php">Stock</a></li>
        <li class="alerte"><a href="indexP.php">Prêts et Alertes</a><p class="circle-light">!</p></li>
        <li style="float:right"><a class="active" href="#">Se connecter</a></li>
        <li style="float:right"><a target="_blank" href="https://www.vitrecommunaute.org/">Vitré Communauté</a></li>
    </ul>
    <!------- Page du stock ------>
    <!-- Création connexion BDD -->
    <?php 
        require '../src/traitement/BDD.php';
        $bdd = new BDD();
        $bdd->connect();
    ?>
    <!---------------------------->
    <br/><br/>

    <div class="stock">
        <div class="stock-action">
            <div class="first-action">
                <!---------- Ajouter en stock ---------->
                <h1 class="titre">Ajouter en stock</h1>
                <form action="indexS.php" method="POST"> 
                    <ul class="first-form">
                        <li>
                            <label for="reference">*Référence :</label>
                            <input type="text" id="reference" name="reference" required placeholder=""/>
                        </li>
                        <li>
                            <label for="materiel">*Matériel :</label>
                            <input type="text" id="materiel" name="materiel" required placeholder="Ex: Clavier"/>
                        </li>
                        <li>
                            <label for="marque">*Marque :</label>
                            <input type="text" id="marque" name="marque" required placeholder="Ex: Logitech"/>
                        </li>
                        <li>
                            <label for="etat">*Etat :</label>
                            <input type="radio" id="etat" name="etat" value="disponible" checked/>Disponible
                            <input type="radio" id="etat" name="etat" value="déjà prêté"/>Prêté
                            <input type="radio" id="etat" name="etat" value="en réparation"/>En réparation
                        </li>
                        <li>
                            <label for="note">Note :</label>
                            <textarea id="note" name="note" placeholder="Facultatif"></textarea>
                        </li>
                        <li>
                            <button type="submit" name="submit">Ajouter au stock</button>
                        </li> 
                    </ul>
                </form>
            </div>
            <!-- Formulaire vers BDD pour ajout du stock -->
            <?php
                if(isset($_POST['submit'])) {
                    $ref = $_POST['reference'];
                    $mat = $_POST['materiel'];
                    $marque = $_POST['marque'];
                    $etat = $_POST['etat'];
                    $note = $_POST['note'];
                    $req = "INSERT INTO stock (ident, materiel, marque, etat, note) VALUES ('$ref', '$mat', '$marque', '$etat', '$note')";
                    try {
                        $bdd->getPdo()->query($req);
                    } catch(Exception $e) {
                        die("Erreur: Impossible d'ajouter dans la BDD".$e->getMessage());
                    }
                }
            ?>
            
        </div>
        <div class="nada">

        </div>
        <div class="scrollbar">
            <!-- Liste de tout le matériel en stock -->
            <!---------------------------------------->
            <h1>Tout le stock</h1>
            <table>
                <tr>
                    <th class="ref">Référence</th>
                    <th class="mat">Matériel</th>
                    <th class="marque">Marque</th>
                    <th class="etat">Etat</th>
                    <th class="note">Note</th>
                    <th class="button"></th>
                </tr>
                <!---------- Affichage du stock ---------->
                <?php 
                    $result = $bdd->getPdo()->query('SELECT * FROM stock');
                    foreach($result as $res) {
                ?>  
                    <tr>     
                        <td class="ref"><?php print $res['ident']; $id = $res['ident']; ?></td>
                        <td class="mat"><?php print $res['materiel']; ?></td>
                        <td class="marque"><?php print $res['marque']; ?></td>
                        <td class="etat"><?php print $res['etat']; ?></td>
                        <td class="note"><?php print $res['note']; ?></td>
                        <td class="button">
                            <form action="indexP.php" method="POST">
                                <button type="submit" name="submit-add" title="Ajouter aux prêts">
                                <input type="hidden" value="<?php echo $id; ?>" name="id"/>
                                <img src="../ressources/images/ajouter.png" alt="ajouter" height="20px"></button>      
                            </form>
                        </td>
                        <td class="button">
                            <form action="indexS.php" method="POST">
                                <button type="submit" name="submit-supp" title="Supprimer">
                                <input type="hidden" value="<?php echo $id; ?>" name="id"/>
                                <img src="../ressources/images/basket.png" alt="supprimer" height="20px"></button>
                            </form>
                        </td>
                    </tr>
                    <!-------------------- RETRAIT DU STOCK ------------------->
                <?php
                    }
                    if(isset($_POST['submit-add'])) {
                        
                    }
                    
                    if(isset($_POST['submit-supp'])) {
                        $req = "DELETE FROM stock WHERE ident = {$_POST['id']} ";
                        $bdd->getPdo()->exec($req);
                        try {
                            $bdd->getPdo()->query($req);
                        } catch(Exception $e) {
                            die("Erreur: Impossible d'ajouter dans la BDD".$e->getMessage());
                        }
                    }
                ?>
            </table>
        </div>
    </div> 
</body>
</html>