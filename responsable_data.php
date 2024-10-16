<?php 
session_start();
require_once("cn.php");

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    // Total des fournisseurs
    $totalUsersStmt = $db->query("SELECT COUNT(*) as total FROM fournisseur");
    $totalUsers = $totalUsersStmt->fetch(PDO::FETCH_OBJ)->total;

} catch (PDOException $e) {
    die("Erreur: " . $e->getMessage());
}

try {
    // Récupération des paramètres de recherche
    $idp = isset($_POST['idp']) ? $_POST['idp'] : '';
    $compte = isset($_POST['compte']) ? $_POST['compte'] : '';
    $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
    $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : '';
    $fonction = isset($_POST['fonction']) ? $_POST['fonction'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $adresse = isset($_POST['adresse']) ? $_POST['adresse'] : '';

    // Construction de la requête SQL en fonction des critères
    $query = "SELECT * FROM user WHERE 1=1";
    if ($idp) {
        $query .= " AND idp = :idp";
    }
    if ($compte) {
        $query .= " AND compte LIKE :compte";
    }
    if ($nom) {
        $query .= " AND nom LIKE :nom";
    }
    if ($prenom) {
        $query .= " AND prenom LIKE :prenom";
    }
    if ($fonction) {
        $query .= " AND fonction LIKE :fonction";
    }
    if ($email) {
        $query .= " AND email LIKE :email";
    }
    if ($adresse) {
        $query .= " AND adresse LIKE :adresse";
    }

    $stmt = $db->prepare($query);

    // Lier les paramètres à la requête
    if ($idp) $stmt->bindParam(':idp', $idp);
    if ($compte) $stmt->bindValue(':compte', '%' . $compte . '%');
    if ($nom) $stmt->bindValue(':nom', '%' . $nom . '%');
    if ($prenom) $stmt->bindValue(':prenom', '%' . $prenom . '%');
    if ($fonction) $stmt->bindValue(':fonction', '%' . $fonction . '%');
    if ($email) $stmt->bindValue(':email', '%' . $email . '%');
    if ($adresse) $stmt->bindValue(':adresse', '%' . $adresse . '%');

    $stmt->execute();
    $searchResults = $stmt->fetchAll(PDO::FETCH_OBJ);

} catch (PDOException $e) {
    die("Erreur: " . $e->getMessage());
}
?>