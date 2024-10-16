<?php
require_once("cn.php");

// Vérification si l'ID de la pièce est fourni
if (isset($_GET['id_piece'])) {
    $id_piece = $_GET['id_piece']; // Récupérer l'ID de la pièce depuis l'URL

    // Requête SQL pour récupérer les informations de la pièce
    $sql = "SELECT type_piece, nom_fournisseur, prix_unitaire, quantite, date_livraison FROM piece WHERE ID_piece = :id_piece";
    $stmt = $db->prepare($sql);
    $stmt->execute(['id_piece' => $id_piece]);
    $piece = $stmt->fetch(PDO::FETCH_OBJ); // Récupérer les données sous forme d'objet

    // Vérifier si la pièce a été trouvée
    if ($piece) {
        // La pièce existe, vous pouvez maintenant utiliser $piece->type_piece, etc.
    } else {
        echo "Pièce introuvable.";
    }
} else {
    echo "ID de pièce non fourni.";
}

// Traitement de l'enregistrement d'une nouvelle pièce
if (isset($_POST["enreg"])) {
    $type_piece = $_POST["type_piece"];
    $nom_fournisseur = $_POST["nom_fournisseur"];
    $prix_unitaire = $_POST["prix_unitaire"];
    $quantite = $_POST["quantite"];
    $date_livraison = $_POST["date_livraison"];
    
    // Calculer le prix total
    $prix_total = $prix_unitaire * $quantite;

    // Préparation de la requête d'insertion
    $insert = $db->prepare("INSERT INTO piece(type_piece, nom_fournisseur, prix_unitaire, quantite, date_livraison, prix_total) 
    VALUES (?, ?, ?, ?, ?, ?)");

    // Exécution de la requête avec les paramètres
    $result = $insert->execute([
        $type_piece,
        $nom_fournisseur,
        $prix_unitaire,
        $quantite,
        $date_livraison,
        $prix_total
    ]);

    if ($result) {
        header("Location: gest_piece.php"); // Rediriger vers la page de gestion des pièces
        exit();
    } else {
        echo "Erreur lors de l'enregistrement.";
    }
}

// Traitement de la mise à jour d'une pièce
if (isset($_POST['modif'])) {
    // Récupérer l'ID de la pièce
    $id_piece = $_POST['id_piece'];

    // Récupérer les autres informations du formulaire
    $type_piece = $_POST['type_piece'];
    $nom_fournisseur = $_POST['nom_fournisseur'];
    $prix_unitaire = $_POST['prix_unitaire'];
    $quantite = $_POST['quantite'];
    $date_livraison = $_POST['date_livraison'];
    
    // Calculer le prix total
    $prix_total = $prix_unitaire * $quantite;

    // Mettre à jour les informations dans la base de données
    $sql = "UPDATE piece SET type_piece = :type_piece, nom_fournisseur = :nom_fournisseur, prix_unitaire = :prix_unitaire, quantite = :quantite, date_livraison = :date_livraison, prix_total = :prix_total WHERE ID_piece = :id_piece";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        'type_piece' => $type_piece,
        'nom_fournisseur' => $nom_fournisseur,
        'prix_unitaire' => $prix_unitaire,
        'quantite' => $quantite,
        'date_livraison' => $date_livraison,
        'prix_total' => $prix_total,
        'id_piece' => $id_piece
    ]);

    // Rediriger ou afficher un message de succès
    header("Location: gest_piece.php?message=Modification réussie");
    exit();
}
?>
