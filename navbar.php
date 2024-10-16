<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    
    <style>
        /* Styles pour la navbar */
        .navbar {
            background: linear-gradient(to right, #211f20, #003366);
            padding: 1px;
            font-family: Arial, sans-serif;
            margin-bottom: 0px; /* Espace sous la navbar */
            display: flex;
            justify-content: space-between; /* Espace entre les éléments de gauche et de droite */
            align-items: center; /* Centrer les éléments verticalement */
            border-radius: 0px; /* Coins arrondis */
        }

        .logo-container {
            display: flex;
            align-items: center; /* Centrer le logo et le texte verticalement */
            color: #ffffff;
        }

        .logo {
            width: 74px; /* Ajuster la taille du logo */
            height: 50px;
            margin-right: 10px; /* Espace entre le logo et le texte */
        }

        .deconnexion-container {
            margin-left: auto; /* Pousse le bouton de déconnexion à droite */
        }

        .deconnexion {
            font-size: 14px;
        }

        .deconnexion:hover {
            font-size: 15px;
        }

        .navbar ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center; /* Centrer les éléments verticalement */
        }

        .navbar ul li {
            margin: 0 15px;
        }

        .navbar ul li a {
            text-align: center;
            padding: 0px 0px;
            text-decoration: none;
            display: block;
        }

        .user-info {
            color: #ffffff;
            margin-left: 800px; /* Ajustez si nécessaire */
            display: flex; /* Flexbox pour aligner l'icône et le texte */
            align-items: center; /* Centrer verticalement */
        }

        .user-circle {
            width: 30px; /* Ajuster la taille du cercle */
            height: 30px; /* Ajuster la taille du cercle */
            border-radius: 50%; /* Rendre le cercle arrondi */
            background-color: #007bff; /* Couleur de fond du cercle */
            color: white; /* Couleur du texte */
            display: flex; /* Pour centrer le texte */
            justify-content: center; /* Centrer horizontalement */
            align-items: center; /* Centrer verticalement */
            font-weight: bold; /* Mettre le texte en gras */
            margin-right: 5px; /* Espace entre le cercle et le nom */
            font-size: 16px; /* Ajuster la taille de la lettre */
        }

        .user-info i {
            margin-left: 10px;
        }
        .form-group-1{
            display: flex;
            gap: 4px; /* Espacement entre les éléments */
            margin-bottom: 2px; /* Espacement entre les groupes */
        }
        .user-name{
            margin-top:4px;
        }
    </style>
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

</body>
</html>
 