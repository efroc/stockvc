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
        <li><a href="indexS.php">Stock</a></li>
        <li class="alerte"><a href="indexP.php">Prêts et Alertes</a><p class="circle-light">!</p></li>
        <li style="float:right"><a class="active" href="#">Se connecter</a></li>
        <li style="float:right"><a target="_blank" href="https://www.vitrecommunaute.org/">Vitré Communauté</a></li>
    </ul>
    <!-- <p>Page des prêts</p> -->
    
    <br/><br/>
    
    <div class="pret-window">
        <div class="pret-action">
            <div class="pret-query">
                <!-- Ajouter en stock -->
                <h1 class="titre">Demande de prêt</h1>
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
                            <label for="demandeur">*Demandeur :</label>
                            <input type="text" id="demandeur" name="demandeur" required/>
                        </li>
                        <li>
                            <label for="start">*Début du prêt :</label>
                            <input type="date" id="start" name="start" required/>
                        </li>
                        <li>
                            <label for="end">*Fin du prêt :</label>
                            <input type="date" id="end" name="end" required/>
                        </li>
                        <li>
                            <button type="submit">Confirmer la demande</button>
                        </li>
                    </ul>
                </form>
                
            </div>
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
            <table class="stock-table">
                <tr>
                    <th>Référence</th>
                    <th>Matériel</th>
                    <th>Marque</th>
                    <th>Demandeur</th>
                    <th>Début du prêt</th>
                    <th>Fin du prêt</th>
                </tr>
            </table>
        </div>
    </div>  
   
</body>
</html>