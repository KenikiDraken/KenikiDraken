<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal d'enregistrement</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
.modal-header {
    background-color: #0056b3;
    color: white;
}

.btn-primary {
    background-color: #0056b3;
    border-color: #0056b3;
}

.btn-primary:hover {
    background-color: #004494;
    border-color: #004494;
}

.btn-secondary {
    background-color: #d9534f;
    border-color: #d9534f;
}

.btn-secondary:hover {
    background-color: #c9302c;
    border-color: #c9302c;
}

    </style>
</head>
<body>
    <!-- Button to Open the Modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
      Nouveau chauffeur
    </button>

    <!-- The Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Nouveau chauffeur</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="nom" class="form-label">Nom :</label>
                  <input type="text" class="form-control" id="nom" placeholder="Entrez le nom">
                </div>
                <div class="col-md-6 mb-3">
                  <label for="prenom" class="form-label">Prénom :</label>
                  <input type="text" class="form-control" id="prenom" placeholder="Entrez le prénom">
                </div>
                <div class="col-md-6 mb-3">
                  <label for="login" class="form-label">Login :</label>
                  <input type="text" class="form-control" id="login" placeholder="Entrez le login">
                </div>
                <div class="col-md-6 mb-3">
                  <label for="password" class="form-label">Mot de passe :</label>
                  <input type="password" class="form-control" id="password" placeholder="Entrez le mot de passe">
                </div>
                <div class="col-md-6 mb-3">
                  <label for="cin" class="form-label">CIN :</label>
                  <input type="text" class="form-control" id="cin" placeholder="Entrez le CIN">
                </div>
                <div class="col-md-6 mb-3">
                  <label for="telephone" class="form-label">Téléphone :</label>
                  <input type="text" class="form-control" id="telephone" placeholder="Entrez le numéro">
                </div>
                <div class="col-md-6 mb-3">
                  <label for="departement" class="form-label">Département :</label>
                  <input type="text" class="form-control" id="departement" placeholder="Entrez le département">
                </div>
                <div class="col-md-6 mb-3">
                  <label for="service" class="form-label">Service :</label>
                  <input type="text" class="form-control" id="service" placeholder="Entrez le service">
                </div>
                <div class="col-md-6 mb-3">
                  <label for="adresse" class="form-label">Adresse :</label>
                  <input type="text" class="form-control" id="adresse" placeholder="Entrez l'adresse">
                </div>
                <div class="col-md-6 mb-3">
                  <label for="email" class="form-label">Email :</label>
                  <input type="email" class="form-control" id="email" placeholder="Entrez l'email">
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            <button type="button" class="btn btn-primary">Enregistrer</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bouton pour ajouter une assurance -->
<button type="button" data-toggle="modal" data-target="#ajoutAssurance">Ajouter Assurance</button>

<!-- Modal pour ajouter une assurance -->
<div class="modal fade" tabindex="-1" id="ajoutAssurance" role="dialog" aria-hidden="true" aria-labelledby="ajoutAssuranceLabel">  
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ajouter Assurance</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form action="enregistrer_assurance.php" method="POST">
                    <!-- Champs pour l'assurance -->
                    <div class="form-group">
                        <label>Nom de l'assurance</label>
                        <input type="text" name="nom" required>
                    </div>
                    <div class="form-group">
                        <label>Coût</label>
                        <input type="number" name="cout" required>
                    </div>
                    <div class="form-group">
                        <label>Téléphone</label>
                        <input type="text" name="tel" required>
                    </div>
                    <div class="form-group">
                        <label>Date de mise en place</label>
                        <input type="date" name="date_mise" required>
                    </div>
                    <div class="form-group">
                        <label>Date d'expiration</label>
                        <input type="date" name="date_expiration" required>
                    </div>
                    <!-- Bouton de soumission -->
                    <button type="submit" class="btn-valider">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Icônes d'alerte -->
<div>
    <span class="badge badge-danger">Assurances expirées : <span id="alerteExpirationsRouge">0</span></span>
    <span class="badge badge-warning">Assurances proches de l'expiration : <span id="alerteExpirationsJaune">0</span></span>
</div>

<!-- Tableau des assurances -->
<h3>Assurances Valides</h3>
<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Coût</th>
            <th>Téléphone</th>
            <th>Date de mise</th>
            <th>Date d'expiration</th>
        </tr>
    </thead>
    <tbody id="tableValidAssurance">
        <!-- Les assurances valides seront affichées ici -->
    </tbody>
</table>

<h3>Assurances Expirées</h3>
<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Coût</th>
            <th>Téléphone</th>
            <th>Date de mise</th>
            <th>Date d'expiration</th>
        </tr>
    </thead>
    <tbody id="tableExpiredAssurance">
        <!-- Les assurances expirées seront affichées ici -->
    </tbody>
</table>

<h3>Assurances Proches de l'expiration</h3>
<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Coût</th>
            <th>Téléphone</th>
            <th>Date de mise</th>
            <th>Date d'expiration</th>
        </tr>
    </thead>
    <tbody id="tableNearExpirationAssurance">
        <!-- Les assurances proches de l'expiration seront affichées ici -->
    </tbody>
</table>
<?php
// enregistrer_assurance.php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $cout = $_POST['cout'];
    $tel = $_POST['tel'];
    $date_mise = $_POST['date_mise'];
    $date_expiration = $_POST['date_expiration'];

    // Enregistrez ces informations dans votre base de données ou tableau
    // Connexion à la base de données
    // $db = new PDO(...);
    // $query = "INSERT INTO assurances (nom, cout, tel, date_mise, date_expiration) VALUES (?, ?, ?, ?, ?)";
    // $stmt = $db->prepare($query);
    // $stmt->execute([$nom, $cout, $tel, $date_mise, $date_expiration]);

    header('Location: index.php'); // Retour à la page principale
}
// Code pour récupérer et afficher les assurances
$today = new DateTime();
$nearExpirationLimit = (clone $today)->modify('+1 month');

// Requête pour récupérer toutes les assurances
$query = "SELECT * FROM assurances";
$stmt = $db->query($query);
$assurances = $stmt->fetchAll();

$expiredCount = 0;
$nearExpirationCount = 0;

foreach ($assurances as $assurance) {
    $expirationDate = new DateTime($assurance['date_expiration']);

    if ($expirationDate < $today) {
        // Affiche l'assurance dans la table des expirées
        echo "<tr><td>{$assurance['nom']}</td><td>{$assurance['cout']}</td><td>{$assurance['tel']}</td><td>{$assurance['date_mise']}</td><td>{$assurance['date_expiration']}</td></tr>";
        $expiredCount++;
    } elseif ($expirationDate <= $nearExpirationLimit) {
        // Affiche l'assurance dans la table des proches de l'expiration
        echo "<tr><td>{$assurance['nom']}</td><td>{$assurance['cout']}</td><td>{$assurance['tel']}</td><td>{$assurance['date_mise']}</td><td>{$assurance['date_expiration']}</td></tr>";
        $nearExpirationCount++;
    } else {
        // Affiche l'assurance dans la table des valides
        echo "<tr><td>{$assurance['nom']}</td><td>{$assurance['cout']}</td><td>{$assurance['tel']}</td><td>{$assurance['date_mise']}</td><td>{$assurance['date_expiration']}</td></tr>";
    }
}

// Mettre à jour les badges d'alerte
echo "<script>document.getElementById('alerteExpirationsRouge').innerText = $expiredCount;</script>";
echo "<script>document.getElementById('alerteExpirationsJaune').innerText = $nearExpirationCount;</script>";

?>
</body>
</html>
