<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <!--<meta http-equiv="refresh" content="60">-->   <!--Auto refresh chaque minute -->
    <link href="css/stock.css" rel="stylesheet"/>
    <title>Stock Informatique Vitré Communauté</title>
    <link rel="website icon" type="png" href="../ressources/images/VClogo.png"/>
</head>
<body>
    <ul class="menu">
        <li><img src="../ressources/images/VClogo.png" alt="logo" height="42px"></li>
        <li><a href="indexS.php">Stock</a></li>
        <li class="alerte"><a href="indexP.php">Prêts et Alertes</a><p class="circle-light">!</p></li>
        <li style="float:right"><a class="active" href="#">Se connecter</a></li>
        <li style="float:right"><a target="_blank" href="https://www.vitrecommunaute.org/">Vitré Communauté</a></li>
    </ul>
    <!-- <p>Page des prêts</p> -->
    <!-- Création connexion BDD -->
    <?php 
        require '../src/traitement/BDD.php';
        $bdd = new BDD();
        $bdd->connect();
        $localdate = date('Y-m-d');
        echo("Date du jour: ".$localdate);
    ?>
    <!---------------------------->
    <br/><br/>
    
    <div class="pret-window">
        <div class="pret-action">
            <div class="pret-query">
                <!-- Ajouter en stock -->
                <h1 class="titre">Demande de prêt</h1>
                <form action="indexP.php" method="POST">
                    <ul class="first-form">
                        <li>
                            <label for="reference">*Référence :</label>
                            <input type="text" id="reference" name="reference" value="<?php if(isset($_POST['id'])) echo $_POST['id'];?>" required placeholder=""/>
                        </li>
                        <li>
                            <label for="demandeur">*Client :</label>
                            <input type="text" id="demandeur" name="demandeur" required/>
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
                            <button type="submit" name="submit">Confirmer la demande</button>
                        </li>
                    </ul>
                </form>
            </div>
            <?php
                if(isset($_POST['submit'])) {
                    $ref = $_POST['reference'];
                    $client = $_POST['demandeur'];
                    $start = $_POST['start'];
                    $end = $_POST['end'];
                  
                    if($start < $end) {
                        $req = "INSERT INTO pret (ident, start, end, client) VALUES ('$ref', '$start', '$end', '$client')";
                        $updatereq = "UPDATE stock SET etat = 'déjà prêté' WHERE ident = '{$ref}'";
                        try {
                            $bdd->getPdo()->query($req);
                            $bdd->getPdo()->query($updatereq);
                        } catch(Exception $e) {
                            die("Erreur: Impossible d'ajouter dans la BDD".$e->getMessage());
                        }
                    }
                    
                }
            ?>
            <br/><br/> <!-- Sépare les deux formulaires d'actions -->
            
            <div class="alerte-query">
                <!-- Retirer du stock -->
                <h1 class="titre">Liste des alertes</h1>
                <p class="text">Liste vide</p>
            </div>
        </div>
        <div class="nada">

        </div>
        <div class="scrollbar">
            <!-- Liste de tout le matériel en stock -->
            <h1>Liste des prêts en cours</h1>
            <table class="pret-table">
                <tr>
                    <th class="ref">Référence</th>
                    <th class="start">Début du prêt</th>
                    <th class="end">Fin du prêt</th>
                    <th class="client">Client</th>
                </tr>
                <?php 
                    $result = $bdd->getPdo()->query('SELECT * FROM pret');
                    foreach($result as $res) {
                ?>
                <tr>
                    <td class="ref"><?php print $res['ident']; $id = $res['ident']; ?></td>
                    <td class="start"><?php print $res['start']; ?></td>
                    <td class="end"><?php print $res['end']; ?></td>
                    <td class="client"><?php print $res['client']; ?></td>
                </tr>
                <?php
                    }
                ?>        
                


            </table>
        </div>
    </div>  
   
</body>
</html>