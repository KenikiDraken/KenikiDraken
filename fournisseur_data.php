<?php 
session_start();
require_once("cn.php");

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    // Total des fournisseurs
    $totalFournisseurStmt = $db->query("SELECT COUNT(*) as total FROM fournisseur");
    $totalFournisseur = $totalFournisseurStmt->fetch(PDO::FETCH_OBJ)->total;

} catch (PDOException $e) {
    die("Erreur: " . $e->getMessage());
}

try {
    // Récupération des paramètres de recherche
    $id_fournisseur = isset($_POST['id_fournisseur']) ? $_POST['id_fournisseur'] : '';
    $nom_fournisseur = isset($_POST['nom_fournisseur']) ? $_POST['nom_fournisseur'] : '';
    $contact = isset($_POST['contact']) ? $_POST['contact'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $type_fourniture = isset($_POST['type_fourniture']) ? $_POST['type_fourniture'] : '';
    $adresse = isset($_POST['adresse']) ? $_POST['adresse'] : '';

    // Construction de la requête SQL en fonction des critères
    $query = "SELECT * FROM fournisseur WHERE 1=1";
    if ($id_fournisseur) {
        $query .= " AND ID_fournisseur = :id_fournisseur";
    }
    if ($nom_fournisseur) {
        $query .= " AND nom_fournisseur LIKE :nom_fournisseur";
    }
    if ($contact) {
        $query .= " AND contact LIKE :contact";
    }
    if ($email) {
        $query .= " AND email LIKE :email";
    }
    if ($type_fourniture) {
        $query .= " AND type_fourniture LIKE :type_fourniture";
    }
    if ($adresse) {
        $query .= " AND adresse LIKE :adresse";
    }

    $stmt = $db->prepare($query);

    // Lier les paramètres à la requête
    if ($id_fournisseur) $stmt->bindParam(':id_fournisseur', $id_fournisseur);
    if ($nom_fournisseur) $stmt->bindValue(':nom_fournisseur', '%' . $nom_fournisseur . '%');
    if ($contact) $stmt->bindValue(':contact', '%' . $contact . '%');
    if ($email) $stmt->bindValue(':email', '%' . $email . '%');
    if ($type_fourniture) $stmt->bindValue(':type_fourniture', '%' . $type_fourniture . '%');
    if ($adresse) $stmt->bindValue(':adresse', '%' . $adresse . '%');

    $stmt->execute();
    $searchResults = $stmt->fetchAll(PDO::FETCH_OBJ);

} catch (PDOException $e) {
    die("Erreur: " . $e->getMessage());
}
?>
