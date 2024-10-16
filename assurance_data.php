<?php
session_start();
require_once("cn.php");

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    // Total des assurances
    $totalAssuranceStmt = $db->query("SELECT COUNT(*) as total FROM ASSURANCE");
    $totalAssurance = $totalAssuranceStmt->fetch(PDO::FETCH_OBJ)->total;

} catch (PDOException $e) {
    die("Erreur: " . $e->getMessage());
}

try {
    // Récupération des paramètres de recherche
    $id_assurance = isset($_POST['id_assurance']) ? $_POST['id_assurance'] : '';
    $matricule = isset($_POST['matricule']) ? $_POST['matricule'] : '';
    $fournisseur = isset($_POST['fournisseur']) ? $_POST['fournisseur'] : '';
    $date_debut = isset($_POST['date_debut']) ? $_POST['date_debut'] : '';
    $date_expiration = isset($_POST['date_expiration']) ? $_POST['date_expiration'] : '';
    $prime = isset($_POST['prime']) ? $_POST['prime'] : '';

    // Construction de la requête SQL en fonction des critères
    $query = "SELECT * FROM ASSURANCE WHERE 1=1";
    if ($id_assurance) {
        $query .= " AND ID_assurance = :id_assurance";
    }
    if ($matricule) {
        $query .= " AND matricule LIKE :matricule";
    }
    if ($fournisseur) {
        $query .= " AND fournisseur LIKE :fournisseur";
    }
    if ($date_debut) {
        $query .= " AND date_debut = :date_debut"; // Exact match for the date_debut
    }
    if ($date_expiration) {
        $query .= " AND date_expiration = :date_expiration"; // Exact match for the date_expiration
    }
    if ($prime) {
        $query .= " AND prime = :prime"; // Exact match for the prime
    }

    $stmt = $db->prepare($query);

    // Lier les paramètres à la requête
    if ($id_assurance) $stmt->bindParam(':id_assurance', $id_assurance);
    if ($matricule) $stmt->bindValue(':matricule', '%' . $matricule . '%');
    if ($fournisseur) $stmt->bindValue(':fournisseur', '%' . $fournisseur . '%');
    if ($date_debut) $stmt->bindParam(':date_debut', $date_debut);
    if ($date_expiration) $stmt->bindParam(':date_expiration', $date_expiration);
    if ($prime) $stmt->bindParam(':prime', $prime);

    // Exécuter la requête et récupérer les résultats
    $stmt->execute();
    $searchResults = $stmt->fetchAll(PDO::FETCH_OBJ);

} catch (PDOException $e) {
    die("Erreur: " . $e->getMessage());
}
?>
