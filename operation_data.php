<?php 
session_start();
require_once("cn.php");

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    // Total des entretiens
    $totalEntretienStmt = $db->query("SELECT COUNT(*) as total FROM entretien");
    $totalEntretien = $totalEntretienStmt->fetch(PDO::FETCH_OBJ)->total;

} catch (PDOException $e) {
    die("Erreur: " . $e->getMessage());
}

try {
    // Récupération des paramètres de recherche
    $id_entretien = isset($_POST['id_entretien']) ? $_POST['id_entretien'] : '';
    $matricule = isset($_POST['matricule']) ? $_POST['matricule'] : '';
    $type_entretien = isset($_POST['type_entretien']) ? $_POST['type_entretien'] : '';
    $detaille = isset($_POST['detaille']) ? $_POST['detaille'] : '';
    $date_rappel = isset($_POST['date_rappel']) ? $_POST['date_rappel'] : '';
    $cout = isset($_POST['cout']) ? $_POST['cout'] : '';
    $etat = isset($_POST['etat']) ? $_POST['etat'] : '';

    // Construction de la requête SQL en fonction des critères
    $query = "SELECT * FROM entretien WHERE 1=1";
    if ($id_entretien) {
        $query .= " AND id_entretien = :id_entretien";
    }
    if ($matricule) {
        $query .= " AND matricule LIKE :matricule";
    }
    if ($type_entretien) {
        $query .= " AND type_entretien LIKE :type_entretien";
    }
    if ($detaille) {
        $query .= " AND detaille LIKE :detaille";
    }
    if ($date_rappel) {
        $query .= " AND date_rappel = :date_rappel"; // On suppose que c'est une date exacte
    }
    if ($cout) {
        $query .= " AND cout = :cout"; // On suppose que c'est un coût exact
    }
    if ($etat) {
        $query .= " AND etat LIKE :etat";
    }

    $stmt = $db->prepare($query);

    // Lier les paramètres à la requête
    if ($id_entretien) $stmt->bindParam(':id_entretien', $id_entretien);
    if ($matricule) $stmt->bindValue(':matricule', '%' . $matricule . '%');
    if ($type_entretien) $stmt->bindValue(':type_entretien', '%' . $type_entretien . '%');
    if ($detaille) $stmt->bindValue(':detaille', '%' . $detaille . '%');
    if ($date_rappel) $stmt->bindParam(':date_rappel', $date_rappel); // pour une date exacte
    if ($cout) $stmt->bindParam(':cout', $cout); // pour un coût exact
    if ($etat) $stmt->bindValue(':etat', '%' . $etat . '%');

    $stmt->execute();
    $searchResults = $stmt->fetchAll(PDO::FETCH_OBJ);

} catch (PDOException $e) {
    die("Erreur: " . $e->getMessage());
}
?>
