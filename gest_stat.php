<?php

include('mission_data.php');

if (empty($_SESSION['cmp'])) {
    header("location:first_authent.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NIG-parc</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="stat_style.css">
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
</head>
<body>
<?php
include('navbar.php');
?>
<div class="container">
    <div class="container-1">
        <form action="page.php" method="POST">
            <div class="form-group">
                <!-- Retour au Menu d'accueil -->
                <button class="go-home-btn" type="submit" name="home">
                    <i class="glyphicon glyphicon-arrow-left"></i>
                </button>
                <!-- Page du Jour -->
                <p class="gest_veh">Statistiques</p>
            </div>
        </form>
        <div class ="form-group">
            <form action="page.php" method="POST">
                <!-- Bouton pour ouvrir le modal -->
                <button class="btn btn-respon-1" type="submit" name="home">
                    <span>Statistique Missions</span><br>
                    <i class="fa fa-bullseye"></i>
                </button>
                <!-- Bouton pour ouvrir le modal -->
                <button class="btn btn-respon" type="submit" name="home">
                    <span>Statistique Operations</span><br>
                    <i class="fa fa-cogs"> </i>
                </button>
                
                <!-- Bouton pour ouvrir le modal -->
                <button class="btn btn-respon" type="submit" name="home">
                    <span>Statistique fournisseurs</span><br>
                    <i class="fa fa-users"></i>
                </button>
                <!-- Bouton pour ouvrir le modal -->
                <button class="btn btn-respon" type="submit" name="home">
                    <span>Autres Stat</span><br>
                    <i class="fa fa-flag-checkered"> </i>
                </button>
            </form>
        </div>
    </div><br>
    <div class="form-group">
        <div class="container-R-1">
                <p class="gest_veh-1">Missions Stat</p>
                <div class ="form-group">
                    <!-- Bouton pour ouvrir le modal -->
                    <div class="btn btn-responsables">
                        <span>Miisions effectués</span><br>
                        <i class="fa fa-wrench"> <?= $totalTerminer ?></i>
                    </div>
                    <div class="btn btn-responsables" type="submit" name="assurances">
                        <span>Missions Annulés</span><br>
                        <i class="fa fa-shield-alt"> <?= $totalAnnulés ?></i>
                    </div>
                </div>
        </div>
        <div class="container-R-2">
            <div class="form-group">
                <p class="gest_veh-2">Frais de mission par trimestre 2024</p>
            </div>
            <div class ="form-group">
                    <!-- Bouton pour ouvrir le modal -->
                    <div class="btn btn-respon-2">
                        <span>Janvier-Mars</span><br>
                        <span>154 000 CFA</span>
                    </div>

                <div class="button-container right-buttons"> <!-- Conteneur pour les boutons à droite -->
                    <!-- Bouton pour ouvrir le modal -->
                    <div class="btn btn-respon-3">
                        <span>Avril-Juin</span><br>
                        <span>142 000 CFA</span>
                    </div>
                </div>
            </div> 
            <div class ="form-group">
                    <!-- Bouton pour ouvrir le modal -->
                    <div class="btn btn-respon-3">
                        <span>Juillet-Septembre</span><br>
                        <span>240 000 CFA</span>
                    </div>

                <div class="button-container right-buttons"> <!-- Conteneur pour les boutons à droite -->
                    <!-- Bouton pour ouvrir le modal -->
                    <div class="btn btn-respon-2">
                        <span>Octobre-Decembre</span><br>
                        <span>223 000 CFA</span>
                    </div>
                </div>
            </div>               
        </div>
        
    </div>
</div>
</body>
</html>