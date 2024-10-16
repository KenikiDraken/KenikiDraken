<?php
require_once("cn.php");

session_start();
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
  <link rel="stylesheet" type="text/css" href="style_index.css">
  <script type="text/javascript" src="js/jquery.js"></script>
  <script type="text/javascript" src="js/bootstrap.js"></script>
</head>
<body>
<nav class="navbar">
    <div class="logo-container">
        <ul>
            <li><img src="images/logo.jpeg" alt="Logo" class="logo">NIG-parc</li>
        </ul>
    </div>
    <div class="user-info">
        <ul>
            <li>
                <div class="form-group-1">
                    <div class="user-circle">
                        <?php 
                        $username = isset($_SESSION['cmp']) ? $_SESSION['cmp'] : 'U'; 
                        $firstLetter = strtoupper(substr($username, 0, 1));
                        echo $firstLetter; 
                        ?>
                    </div>
                    <span class="user-name"><?php echo $username; ?></span>
                </div>
            </li>
        </ul>
    </div>
    <div class="deconnexion-container">
        <ul>
            <li>
                <a class="deconnexion" href="quitter.php?quitter=1" style="color: red;">Déconnexion</a>
            </li>
        </ul>
    </div>
</nav>
<style>
    .container-1 {
    background-color: #bfbfbfc7; /* Gris plus foncé pour le cadre */
    padding: 80px; /* Augmente l'espace intérieur pour le cadre */
    border-radius: 5px; /* Arrondir légèrement les coins */
    display: grid;
    grid-template-columns: repeat(4, 1fr); /* 4 colonnes pour les boutons */
    gap: 20px; /* Espace entre les boutons */
    max-width: 1000px; /* Largeur maximale du cadre */
    margin: 40px auto; /* Centrer le cadre horizontalement et ajouter un espace avec la navbar */

}
</style>
 <form action="page.php" method="POST">
    <div class="container-1">
        <button class="btn btn-vehicules" type="submit" name="vehicules">
            <i class="fa fa-car"></i>
            <span>Gestion des Véhicules</span>
        </button>
        <button class="btn btn-personnel" type="submit" name="fournisseurs">
            <i class="fa fa-users"></i>
            <span>Gestion des fournisseurs</span>
        </button>
        <button class="btn btn-operations" type="submit" name="operations">
            <i class="fa fa-wrench"></i>
            <span>Gestion des Opérations</span>
        </button>
        <button class="btn btn-missions" type="submit" name="missions">
            <i class="fa fa-briefcase"></i>
            <span>Gestion des Missions</span>
        </button>
        <button class="btn btn-chauffeurs" type="submit" name="chauffeurs">
            <i class="fa fa-id-badge"></i>
            <span>Gestion des Chauffeurs</span>
        </button>
        <button class="btn btn-responsables" type="submit" name="responsables">
            <i class="fa fa-user-tie"></i>
            <span>Gestion des Responsables</span>
        </button>
        <button class="btn btn-alertes"type="submit" name="alertes">
            <i class="fa fa-bell"></i>
            <span>Gestion des Alertes</span>
        </button>
        <button class="btn btn-statistiques" type="submit" name="statistiques">
            <i class="fa fa-chart-line"></i>
            <span>Statistiques</span>
        </button>
    </div>
    </form>
<br>

</body>
</html>
