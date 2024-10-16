<?php 
session_start();
require_once("cn.php");

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    // Total des pièces
    $totalPieceStmt = $db->query("SELECT COUNT(*) as total FROM piece");
    $totalPiece = $totalPieceStmt->fetch(PDO::FETCH_OBJ)->total;

} catch (PDOException $e) {
    die("Erreur: " . $e->getMessage());
}

try {
    // Récupération des paramètres de recherche
    $id_piece = isset($_POST['id_piece']) ? $_POST['id_piece'] : '';
    $type_piece = isset($_POST['type_piece']) ? $_POST['type_piece'] : '';
    $nom_fournisseur = isset($_POST['nom_fournisseur']) ? $_POST['nom_fournisseur'] : '';
    $prix_unitaire = isset($_POST['prix_unitaire']) ? $_POST['prix_unitaire'] : '';
    $quantite = isset($_POST['quantite']) ? $_POST['quantite'] : '';
    $date_livraison = isset($_POST['date_livraison']) ? $_POST['date_livraison'] : '';
    $prix_total = isset($_POST['prix_total']) ? $_POST['prix_total'] : '';

    // Construction de la requête SQL en fonction des critères
    $query = "SELECT * FROM piece WHERE 1=1";
    if ($id_piece) {
        $query .= " AND ID_piece = :id_piece";
    }
    if ($type_piece) {
        $query .= " AND type_piece LIKE :type_piece";
    }
    if ($nom_fournisseur) {
        $query .= " AND nom_fournisseur LIKE :nom_fournisseur";
    }
    if ($prix_unitaire) {
        $query .= " AND prix_unitaire = :prix_unitaire"; // Coût exact
    }
    if ($quantite) {
        $query .= " AND quantite = :quantite"; // Quantité exacte
    }
    if ($date_livraison) {
        $query .= " AND date_livraison = :date_livraison"; // Date exacte
    }
    if ($prix_total) {
        $query .= " AND prix_total = :prix_total"; // Prix total exact
    }

    $stmt = $db->prepare($query);

    // Lier les paramètres à la requête
    if ($id_piece) $stmt->bindParam(':id_piece', $id_piece);
    if ($type_piece) $stmt->bindValue(':type_piece', '%' . $type_piece . '%');
    if ($nom_fournisseur) $stmt->bindValue(':nom_fournisseur', '%' . $nom_fournisseur . '%');
    if ($prix_unitaire) $stmt->bindParam(':prix_unitaire', $prix_unitaire);
    if ($quantite) $stmt->bindParam(':quantite', $quantite);
    if ($date_livraison) $stmt->bindParam(':date_livraison', $date_livraison);
    if ($prix_total) $stmt->bindParam(':prix_total', $prix_total);

    $stmt->execute();
    $searchResults = $stmt->fetchAll(PDO::FETCH_OBJ);

} catch (PDOException $e) {
    die("Erreur: " . $e->getMessage());
}
?>