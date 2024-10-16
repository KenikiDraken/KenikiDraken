<?php
// Nombre de missions à afficher par page
$PerPage = 4; // Limiter à 4 missions par page

// Calculer la page actuelle
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $PerPage;

// Requête SQL pour récupérer les missions avec pagination
$sql = "SELECT * FROM mission LIMIT :offset, :limit";
$stmt = $db->prepare($sql);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':limit', $PerPage, PDO::PARAM_INT);
$stmt->execute();

?>