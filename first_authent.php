<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>

    <title>Connexion Utilisateur</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
            background:#ffffff /* Dégradé du bleu foncé au noir */
        }

        .login-container {
            width: 350px;
            padding: 40px;
            background: linear-gradient(to bottom, #003366, #4a4a4a); /* Dégradé du bleu foncé au gris foncé */
            border-radius: 10px; /* Coins arrondis */
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
            color: #fff; /* Texte en blanc */
            z-index: 1; /* Place le formulaire au-dessus de l'image */
            border: 2px solid; /* Épaisseur de la bordure ajustée */
            border-image: #ffff /* Dégradé de la bordure du blanc au noir */
            border-image-slice: 1; /* Appliquer le dégradé sur toute la bordure */
        }

        .login-container h1 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group-addon {
            background-color: rgba(255, 255, 255, 0.2);
            border : none;
            color: #9d9d9d;
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.1);
            border: none;
            color: #fff;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            width: 100%;
            padding: 10px;
            font-size: 16px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .checkbox-inline {
            color: #fff;
        }
    </style>
</head>
<body>

<div class="login-container">            
    <form action="connexion.php" method="POST">
        <h1>Connexion</h1>
        <!-- Compte utilisateur -->
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>            
            <input type="text" class="form-control" name="compte" placeholder="Nom d'utilisateur" required>
        </div>
        <!-- Mot de Passe -->
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>            
            <input type="password" class="form-control" name="motpass" required placeholder="Mot de passe">
        </div>
        <!-- Checkbox Administrateur -->
        <label class="checkbox-inline">
            <input type="checkbox" name="genre" value="A" checked> Administrateur ?
        </label><br><br>
        <!-- Bouton Connecter -->
        <button class="btn btn-primary" type="submit" name="acces" value="1">
            Connexion
        </button>
    </form>     
</div>

</body>
</html>
