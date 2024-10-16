<?php
require_once("cn.php");

if (isset($_GET['id_user'])) {
    $id_user = $_GET['id_user']; // Récupérer l'ID de l'utilisateur depuis l'URL

    // Requête SQL pour récupérer les informations de l'utilisateur
    $sql = "SELECT compte, nom, prenom, email, fonction, adresse FROM user WHERE idp = :id_user";
    $stmt = $db->prepare($sql);
    $stmt->execute(['id_user' => $id_user]);
    $user = $stmt->fetch(PDO::FETCH_OBJ); // Récupérer les données sous forme d'objet

    // Vérifier si l'utilisateur a été trouvé
    if ($user) {
        // L'utilisateur existe, vous pouvez maintenant utiliser $user->compte, $user->nom, etc.
    } else {
        echo "Utilisateur introuvable.";
    }
} else {
    echo "ID d'utilisateur non fourni.";
}

if (isset($_POST["enreg"])) {
    $compte = $_POST["compte"];
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $fonction = $_POST["fonction"];
    $email = $_POST["email"];
    $adresse = $_POST["adresse"];
    $motpasse = $_POST["motpasse"]; // Assurez-vous de chiffrer le mot de passe avant de l'enregistrer

    // Préparation de la requête d'insertion
    $insert = $db->prepare("INSERT INTO user(compte, nom, prenom, fonction, email, adresse, motpasse) 
    VALUES (?, ?, ?, ?, ?, ?, ?)");

    // Exécution de la requête avec les paramètres
    $result = $insert->execute([
        $compte,
        $nom,
        $prenom,
        $fonction,
        $email,
        $adresse,
        password_hash($motpasse, PASSWORD_DEFAULT) // Chiffrement du mot de passe
    ]);

    if ($result) {
        header("Location: gest_responsable.php"); // Rediriger vers la page de gestion des utilisateurs
        exit();
    } else {
        echo "Erreur lors de l'enregistrement.";
    }
}
if (isset($_POST['modif'])) {
    // Récupérer l'ID de l'utilisateur
    $id_user = $_POST['id_user'];

    // Récupérer les autres informations du formulaire
    $compte = $_POST['compte'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $fonction = $_POST['fonction'];
    $email = $_POST['email'];
    $adresse = $_POST['adresse'];

    // Mettre à jour les informations dans la base de données
    $sql = "UPDATE user SET compte = :compte, nom = :nom, prenom = :prenom, fonction = :fonction, email = :email, adresse = :adresse WHERE idp = :id_user";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        'compte' => $compte,
        'nom' => $nom,
        'prenom' => $prenom,
        'fonction' => $fonction,
        'email' => $email,
        'adresse' => $adresse,
        'id_user' => $id_user
    ]);

    // Rediriger ou afficher un message de succès
    header("Location: gest_responsable.php?message=Modification réussie");
    exit();
}


?>