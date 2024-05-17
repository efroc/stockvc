<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="refresh" content="60">    <!--Auto refresh chaque minute -->
    <link href="css/stock.css" rel="stylesheet"/>
    <title>Stock Informatique Vitré Communauté</title>
</head>
<body>
    <ul class="menu">
        <li><img src="../ressources/images/VClogo.png" alt="logo" height="42px"></li>
        <li><a href="stock.html">Stock</a></li>
        <li class="alerte"><a href="pret.html">Prêts et Alertes</a><p class="circle-light">!</p></li>
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
                <!-- Ajouter en stock -->
                <h1 class="titre">Ajouter en stock</h1>
                <form action="../src/traitement/Test.php" method="POST"> <!-- Action et method à définir plus tard -->
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
                            <input type="radio" id="etat" name="etat" value="D" checked/>Disponible
                            <input type="radio" id="etat" name="etat" value="P"/>Prêté
                            <input type="radio" id="etat" name="etat" value="R"/>En réparation
                        </li>
                        <li>
                            <label for="note">Note :</label>
                            <textarea id="note" name="note" placeholder="Facultatif"></textarea>
                        </li>
                        <li>
                            <button type="submit">Ajouter au stock</button>
                        </li>
                    </ul>
                </form>
                
            </div>
            <br/><br/> <!-- Sépare les deux formulaires d'actions -->
            
            <div class="second-action">
                <!-- Retirer du stock -->
                <h1 class="titre">Retirer du stock</h1>
            </div>
        </div>
        <div class="nada">

        </div>
        <div class="scrollbar">
            <!-- Liste de tout le matériel en stock -->
            <!---------- Affichage du stock ---------->
            <?php
               
            ?>
            <!---------------------------------------->
            <h1>Tout le stock</h1>
            <table>
                <tr>
                    <th>Référence</th>
                    <th>Matériel</th>
                    <th>Marque</th>
                    <th>Etat</th>
                    <th>Note</th>
                </tr>
                <?php 
                    $result = $bdd->getPdo()->query('SELECT * FROM stock');
                    foreach($result as $res) {
                ?>  
                    <tr>     
                        <td><?php print $res['ident']; ?></td>
                        <td><?php print $res['type']; ?></td>
                        <td><?php print $res['marque']; ?></td>
                        <td><?php print $res['etat']; ?></td>
                        <td><?php print $res['note']; ?></td>
                    </tr>
                <?php
                    }
                ?>
            </table>
        </div>
    </div> 
</body>
</html>