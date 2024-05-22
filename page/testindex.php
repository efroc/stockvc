<!DOCTYPE html>
<html lang="fr">
<!---------------------------- HEAD PAGE -------------------------------->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="refresh" content="60">    <!--Auto refresh chaque minute -->
    <link href="css/testcss.css" rel="stylesheet"/>
    <title>Stock Informatique Vitré Communauté</title>
    <link rel="website icon" type="png" href="../ressources/images/VClogo.png"/>
</head>

<!------------------------------ BODY PAGE ------------------------------>
<body>

    <!-------------------------- MENU ----------------------------------->
    <?php $menu = $_GET['menu']; ?>
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
                    
            </div>

            <!------------------- AFFICHE STOCK ------------------------->
            <div class="stock-list">
            <h3>Tout le stock</h3>
            <table>
                <tr>
                    <th>Référence</th>
                    <th>Matériel</th>
                    <th>Marque</th>
                    <th>Etat</th>
                    <th>Note</th>
                    <th></th>
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
                        <td><a class="image" href="#"><img src="../ressources/images/ajouter.png" alt="ajouter" height="20px"></a>
                            <a class="image" href="#"><img src="../ressources/images/basket.png" alt="supprimer" height="20px"></a></td>
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