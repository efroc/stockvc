<!DOCTYPE html>
<html lang="fr">
<!---------------------------- HEAD PAGE -------------------------------->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="refresh" content="60"> 
    <link href="css/testcss.css" rel="stylesheet"/>
    <title>Stock Informatique Vitré Communauté</title>
    <link rel="website icon" type="png" href="../ressources/images/VClogo.png"/>
</head>

<!------------------------------ BODY PAGE ------------------------------>
<body>

    <!-------------------------- MENU ----------------------------------->
    <h1 class="title"><p>Gestion du stock et des prêts</p></h1>
    <ul class="menu">
        <li style="float:left"><a target="_blank" href="https://www.vitrecommunaute.org/"><img src="../ressources/images/VClogo.png" alt="logo" height="50px"></a></li>
        <li><a href="testindex.php?menu=1"><p>Stock</p></a></li>
        <li><a href="testindex.php?menu=2"><p>Prêts et Alertes</p></a></li>
        <li style="float:right"><a href="testindex.php?menu=3"><p>Se connecter</p></a></li> 
    </ul>

    <!-------------------------- CONNEXION BDD -------------------------->
    <?php
        require '../src/traitement/BDD.php';
        $bdd = new BDD();
        $bdd->connect();
    ?>

    <!-------------------------- AFFICHAGE SELON MENU ------------------->
    <div class="contenu">
        <?php
            switch($_GET['menu']) {
                case 1:
        ?>            
        <!----------------------- CASE 1 -------------------------------->
        <!----------------------- STOCK --------------------------------->
        <div class="stock">
            <div class="stock-action">
                <!-------------- AJOUTE AU STOCK ------------------------>
                <h3>Ajouter en stock</h3>
                <form action="testindex.php" method="POST">
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
                            <input type="radio" id="etat" name="etat" value="D" checked/>Disponible
                            <input type="radio" id="etat" name="etat" value="P"/>Prêté
                            <input type="radio" id="etat" name="etat" value="R"/>En réparation
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
                <!---------------- FORMULAIRE VERS BDD ------------------>
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

            <!------------------- AFFICHE STOCK ------------------------->
            <div class="stock-list">
            <h3>Tout le stock</h3>
            <table>
                <tr>
                    <th class="ref">Référence</th>
                    <th class="mat">Matériel</th>
                    <th class="marque">Marque</th>
                    <th class="etat">Etat</th>
                    <th class="note">Note</th>
                    <th class="addorsupp"></th>
                </tr>
                <?php 
                    $result = $bdd->getPdo()->query('SELECT * FROM stock');
                    foreach($result as $res) {
                ?>  
                    <tr>     
                        <td><?php print $res['ident']; ?></td>
                        <td><?php print $res['materiel']; ?></td>
                        <td><?php print $res['marque']; ?></td>
                        <td><?php print $res['etat']; ?></td>
                        <td><?php print $res['note']; ?></td>
                        <td><a class="image" href="#" title="Ajouter aux prêts" ><img src="../ressources/images/ajouter.png" alt="ajouter" height="20px"></a>
                            <a class="image" href="#" title="Supprimer"><img src="../ressources/images/basket.png" alt="supprimer" height="20px"></a></td>
                    </tr>
                <?php
                    }
                ?>
            </table>   



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