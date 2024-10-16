<?php 
session_start();
require_once("cn.php");

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    // Total des missions
    $totalMissionStmt = $db->query("SELECT COUNT(*) as total FROM mission");
    $totalMission = $totalMissionStmt->fetch(PDO::FETCH_OBJ)->total;

    $totalCoursStmt = $db->query("SELECT COUNT(*) as total FROM mission WHERE statut = 'En cours' or statut = 'Prévu'");
    $totalCours = $totalCoursStmt->fetch(PDO::FETCH_OBJ)->total;

    $totalAnnulésStmt = $db->query("SELECT COUNT(*) as total FROM mission WHERE statut = 'Annulé'");
    $totalAnnulés = $totalAnnulésStmt->fetch(PDO::FETCH_OBJ)->total;

    $totalTerminerStmt = $db->query("SELECT COUNT(*) as total FROM mission WHERE statut = 'Terminée'");
    $totalTerminer = $totalTerminerStmt->fetch(PDO::FETCH_OBJ)->total;

} catch (PDOException $e) {
    die("Erreur: " . $e->getMessage());
}

try {
    // Récupération des paramètres de recherche
    $id_mission = isset($_POST['id_mission']) ? $_POST['id_mission'] : '';
    $nom_chauffeur = isset($_POST['nom_chauffeur']) ? $_POST['nom_chauffeur'] : '';
    $matricule = isset($_POST['matricule']) ? $_POST['matricule'] : '';
    $date_debut = isset($_POST['date_debut']) ? $_POST['date_debut'] : '';
    $date_fin = isset($_POST['date_fin']) ? $_POST['date_fin'] : '';
    $cout_carburant = isset($_POST['cout_carburant']) ? $_POST['cout_carburant'] : '';
    $lieu_mission = isset($_POST['lieu_mission']) ? $_POST['lieu_mission'] : '';
    $statut = isset($_POST['statut']) ? $_POST['statut'] : '';

    // Construction de la requête SQL en fonction des critères
    $query = "SELECT * FROM mission WHERE 1=1";
    if ($id_mission) {
        $query .= " AND id_mission = :id_mission";
    }
    if ($nom_chauffeur) {
        $query .= " AND nom_chauffeur LIKE :nom_chauffeur";
    }
    if ($matricule) {
        $query .= " AND matricule LIKE :matricule";
    }
    if ($date_debut) {
        $query .= " AND date_debut = :date_debut"; // On suppose que c'est une date exacte
    }
    if ($date_fin) {
        $query .= " AND date_fin = :date_fin"; // On suppose que c'est une date exacte
    }
    if ($cout_carburant) {
        $query .= " AND cout_carburant = :cout_carburant"; // On suppose que c'est un coût exact
    }
    if ($lieu_mission) {
        $query .= " AND lieu_mission LIKE :lieu_mission";
    }
    if ($statut) {
        $query .= " AND statut LIKE :statut";
    }

    $stmt = $db->prepare($query);

    // Lier les paramètres à la requête
    if ($id_mission) $stmt->bindParam(':id_mission', '%' .$id_mission . '%');
    if ($nom_chauffeur) $stmt->bindValue(':nom_chauffeur', '%' . $nom_chauffeur . '%');
    if ($matricule) $stmt->bindValue(':matricule', '%' . $matricule . '%');
    if ($date_debut) $stmt->bindParam(':date_debut', $date_debut); // pour une date exacte
    if ($date_fin) $stmt->bindParam(':date_fin', $date_fin); // pour une date exacte
    if ($cout_carburant) $stmt->bindParam(':cout_carburant', $cout_carburant); // pour un coût exact
    if ($lieu_mission) $stmt->bindValue(':lieu_mission', '%' . $lieu_mission . '%');
    if ($statut) $stmt->bindValue(':statut', '%' . $statut . '%');

    $stmt->execute();
    $searchResults = $stmt->fetchAll(PDO::FETCH_OBJ);

} catch (PDOException $e) {
    die("Erreur: " . $e->getMessage());
}
?>
