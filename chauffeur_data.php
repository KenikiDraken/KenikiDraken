<?php 
session_start();
require_once("cn.php");

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    // Total des chauffeurs
    $totalChauffeursStmt = $db->query("SELECT COUNT(*) as total FROM chauffeur");
    $totalChauffeurs = $totalChauffeursStmt->fetch(PDO::FETCH_OBJ)->total;

} catch (PDOException $e) {
    die("Erreur: " . $e->getMessage());
}

try {
    // Récupération des paramètres de recherche
    $id_chauffeur = isset($_POST['id_chauffeur']) ? $_POST['id_chauffeur'] : '';
    $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
    $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : '';
    $date_debut = isset($_POST['date_debut']) ? $_POST['date_debut'] : '';
    $permis = isset($_POST['permis']) ? $_POST['permis'] : '';
    $telephone = isset($_POST['telephone']) ? $_POST['telephone'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $departement = isset($_POST['departement']) ? $_POST['departement'] : '';

    // Construction de la requête SQL en fonction des critères
    $query = "SELECT * FROM chauffeur WHERE 1=1";
    if ($id_chauffeur) {
        $query .= " AND ID_chauffeur = :id_chauffeur";
    }
    if ($nom) {
        $query .= " AND nom LIKE :nom";
    }
    if ($prenom) {
        $query .= " AND prenom LIKE :prenom";
    }
    if ($date_debut) {
        $query .= " AND date_debut = :date_debut"; // On suppose que c'est une date exacte
    }
    if ($permis) {
        $query .= " AND permis LIKE :permis";
    }
    if ($telephone) {
        $query .= " AND telephone = :telephone"; // On suppose que c'est un numéro exact
    }
    if ($email) {
        $query .= " AND email LIKE :email";
    }
    if ($departement) {
        $query .= " AND departement LIKE :departement";
    }

    $stmt = $db->prepare($query);

    // Lier les paramètres à la requête
    if ($id_chauffeur) $stmt->bindParam(':id_chauffeur', $id_chauffeur);
    if ($nom) $stmt->bindValue(':nom', '%' . $nom . '%');
    if ($prenom) $stmt->bindValue(':prenom', '%' . $prenom . '%');
    if ($date_debut) $stmt->bindParam(':date_debut', $date_debut); // pour une date exacte
    if ($permis) $stmt->bindValue(':permis', '%' . $permis . '%');
    if ($telephone) $stmt->bindParam(':telephone', $telephone); // pour un numéro exact
    if ($email) $stmt->bindValue(':email', '%' . $email . '%');
    if ($departement) $stmt->bindValue(':departement', '%' . $departement . '%');

    $stmt->execute();
    $searchResults = $stmt->fetchAll(PDO::FETCH_OBJ);

} catch (PDOException $e) {
    die("Erreur: " . $e->getMessage());
}
?>
