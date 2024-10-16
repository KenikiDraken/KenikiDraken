<?php
session_start();
require_once("cn.php");

if (empty($_SESSION['cmp'])) {
    header("location:first_authent.php");
}

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    // Total des vehicule
    $totalVehiculesStmt = $db->query("SELECT COUNT(*) as total FROM vehicules");
    $totalVehicules = $totalVehiculesStmt->fetch(PDO::FETCH_OBJ)->total;
    // Total des Vehicules à Essence
    $totalEssenceStmt = $db->query("SELECT COUNT(*) as total FROM vehicules WHERE carburant='Essence'");
    $totalEssence = $totalEssenceStmt->fetch(PDO::FETCH_OBJ)->total;
    // Total des Vehicules à Essence
    $totalGasoilStmt = $db->query("SELECT COUNT(*) as total FROM vehicules WHERE carburant='Gasoil'");
    $totalGasoil = $totalGasoilStmt->fetch(PDO::FETCH_OBJ)->total;

} catch (PDOException $e) {
    die("Erreur: " . $e->getMessage());
}

$searchResults = [];

try {
    // Récupération des paramètres de recherche
    $ID_vehicule = isset($_POST['nom_vehicule']) ? $_POST['nom_vehicule'] : '';
    $matricule = isset($_POST['matricule']) ? $_POST['matricule'] : '';
    $carburant = isset($_POST['carburant']) ? $_POST['carburant'] : '';
    $marque = isset($_POST['marque']) ? $_POST['marque'] : '';
    $categorie = isset($_POST['categorie']) ? $_POST['categorie'] : '';
    $modele = isset($_POST['modele']) ? $_POST['modele'] : '';
    $departement = isset($_POST['departement']) ? $_POST['departement'] : '';

    // Construction de la requête SQL en fonction des critères
    $query = "SELECT * FROM vehicules WHERE 1=1";
    if ($ID_vehicule) {
        $query .= " AND nom_vehicule = :nom_vehicule";
    }
    if ($matricule) {
        $query .= " AND matricule = :matricule";
    }
    if ($carburant) {
        $query .= " AND carburant = :carburant";
    }
    if ($marque) {
        $query .= " AND marque LIKE :marque";
    }
    if ($categorie) {
        $query .= " AND categorie = :categorie";
    }
    if ($modele) {
        $query .= " AND modele LIKE :modele";
    }
    if ($departement) {
        $query .= " AND departement LIKE :departement";
    }

    $stmt = $db->prepare($query);

    // Lier les paramètres à la requête
    if ($ID_vehicule) $stmt->bindParam(':nom_vehicule', $nom_vehicule);
    if ($matricule) $stmt->bindParam(':matricule', $matricule);
    if ($carburant) $stmt->bindParam(':carburant', $carburant);
    if ($marque) $stmt->bindValue(':marque', '%' . $marque . '%');
    if ($categorie) $stmt->bindParam(':categorie', $categorie);
    if ($modele) $stmt->bindValue(':modele', '%' . $modele . '%');
    if ($departement) $stmt->bindValue(':departement', '%' . $departement . '%');

    $stmt->execute();
    $searchResults = $stmt->fetchAll(PDO::FETCH_OBJ);

} catch (PDOException $e) {
    die("Erreur: " . $e->getMessage());
}
?>