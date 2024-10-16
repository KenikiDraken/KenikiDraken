<?php
require_once("cn.php");

if (isset($_GET['id_chauffeur'])) {
    $id_chauffeur = $_GET['id_chauffeur']; // Récupérer l'ID du chauffeur depuis l'URL

    // Requête SQL pour récupérer les informations du chauffeur
    $sql = "SELECT nom, prenom, date_debut, permis, telephone, email, departement FROM chauffeur WHERE id_chauffeur = :id_chauffeur";
    $stmt = $db->prepare($sql);
    $stmt->execute(['id_chauffeur' => $id_chauffeur]);
    $chauffeur = $stmt->fetch(PDO::FETCH_OBJ); // Récupérer les données sous forme d'objet

    // Vérifier si le chauffeur a été trouvé
    if ($chauffeur) {
        // Le chauffeur existe, vous pouvez maintenant utiliser $chauffeur->nom, $chauffeur->prenom, etc.
    } else {
        echo "Chauffeur introuvable.";
    }
} else {
    echo "ID du chauffeur non fourni.";
}

if (isset($_POST["enreg"])) {
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $date_debut = $_POST["date_debut"];
    $permis = $_POST["permis"];
    $telephone = $_POST["telephone"];
    $email = $_POST["email"];
    $departement = $_POST["departement"];

    // Préparation de la requête d'insertion
    $insert = $db->prepare("INSERT INTO chauffeur(nom, prenom, date_debut, permis, telephone, email, departement) 
    VALUES (?, ?, ?, ?, ?, ?, ?)");

    // Exécution de la requête avec les paramètres
    $result = $insert->execute([
        $nom,
        $prenom,
        $date_debut,
        $permis,
        $telephone,
        $email,
        $departement
    ]);

    if ($result) {
        header("Location: gest_chauf.php"); // Rediriger vers la page de gestion des chauffeurs
        exit();
    } else {
        echo "Erreur lors de l'enregistrement.";
    }
}

elseif (isset($_POST['modif'])) {
    // Récupérer l'ID du chauffeur
    $id_chauffeur = $_POST['id_chauffeur'];

    // Récupérer les autres informations du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $date_debut = $_POST['date_debut'];
    $permis = $_POST['permis'];
    $telephone = $_POST['telephone'];
    $email = $_POST['email'];
    $departement = $_POST['departement'];

    // Mettre à jour les informations dans la base de données
    $sql = "UPDATE chauffeur SET nom = :nom, prenom = :prenom, date_debut = :date_debut, permis = :permis, telephone = :telephone, email = :email, departement = :departement WHERE id_chauffeur = :id_chauffeur";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        'nom' => $nom,
        'prenom' => $prenom,
        'date_debut' => $date_debut,
        'permis' => $permis,
        'telephone' => $telephone,
        'email' => $email,
        'departement' => $departement,
        'id_chauffeur' => $id_chauffeur
    ]);

    // Rediriger ou afficher un message de succès
    header("Location: gest_chauf.php?message=Modification réussie");
    exit();
}
?>
