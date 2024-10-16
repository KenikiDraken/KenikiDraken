<?php
require_once("cn.php");

// Vérification si l'ID du fournisseur est fourni
if (isset($_GET['id_fournisseur'])) {
    $id_fournisseur = $_GET['id_fournisseur']; // Récupérer l'ID du fournisseur depuis l'URL

    // Requête SQL pour récupérer les informations du fournisseur
    $sql = "SELECT nom_fournisseur, contact, email, type_fourniture, adresse FROM fournisseur WHERE ID_fournisseur = :id_fournisseur";
    $stmt = $db->prepare($sql);
    $stmt->execute(['id_fournisseur' => $id_fournisseur]);
    $fournisseur = $stmt->fetch(PDO::FETCH_OBJ); // Récupérer les données sous forme d'objet

    // Vérifier si le fournisseur a été trouvé
    if ($fournisseur) {
        // Le fournisseur existe, vous pouvez maintenant utiliser $fournisseur->nom_fournisseur, etc.
    } else {
        echo "Fournisseur introuvable.";
    }
} else {
    echo "ID de fournisseur non fourni.";
}

// Traitement de l'enregistrement d'un nouveau fournisseur
if (isset($_POST["enreg"])) {
    $nom_fournisseur = $_POST["nom_fournisseur"];
    $contact = $_POST["contact"];
    $email = $_POST["email"];
    $type_fourniture = $_POST["type_fourniture"];
    $adresse = $_POST["adresse"];

    // Préparation de la requête d'insertion
    $insert = $db->prepare("INSERT INTO fournisseur(nom_fournisseur, contact, email, type_fourniture, adresse) 
    VALUES (?, ?, ?, ?, ?)");

    // Exécution de la requête avec les paramètres
    $result = $insert->execute([
        $nom_fournisseur,
        $contact,
        $email,
        $type_fourniture,
        $adresse
    ]);

    if ($result) {
        header("Location: gest_fournisseur.php"); // Rediriger vers la page de gestion des fournisseurs
        exit();
    } else {
        echo "Erreur lors de l'enregistrement.";
    }
}

// Traitement de la mise à jour d'un fournisseur
if (isset($_POST['modif'])) {
    // Récupérer l'ID du fournisseur
    $id_fournisseur = $_POST['id_fournisseur'];

    // Récupérer les autres informations du formulaire
    $nom_fournisseur = $_POST['nom_fournisseur'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $type_fourniture = $_POST['type_fourniture'];
    $adresse = $_POST['adresse'];

    // Mettre à jour les informations dans la base de données
    $sql = "UPDATE fournisseur SET nom_fournisseur = :nom_fournisseur, contact = :contact, email = :email, type_fourniture = :type_fourniture, adresse = :adresse WHERE ID_fournisseur = :id_fournisseur";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        'nom_fournisseur' => $nom_fournisseur,
        'contact' => $contact,
        'email' => $email,
        'type_fourniture' => $type_fourniture,
        'adresse' => $adresse,
        'id_fournisseur' => $id_fournisseur
    ]);

    // Rediriger ou afficher un message de succès
    header("Location: gest_fournisseur.php?message=Modification réussie");
    exit();
}

?>
