<?php
try {
    // Requête pour les entretiens
    // Entretiens expirant dans une semaine
    $sql_entretien_semaine = "SELECT * FROM ENTRETIEN WHERE date_rappel BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)";
    $entretiens_semaine = $db->query($sql_entretien_semaine);

    // Entretiens déjà expirés
    $sql_entretien_expire = "SELECT * FROM ENTRETIEN WHERE date_rappel < CURDATE()";
    $entretiens_expire = $db->query($sql_entretien_expire);

    // Total des entretiens expirant bientôt
    $PresqueEntretienStmt = $db->query("SELECT COUNT(*) as total FROM ENTRETIEN WHERE date_rappel BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)");
    $totalPresqueEntretien = $PresqueEntretienStmt->fetch(PDO::FETCH_OBJ)->total;

    // Total des entretiens déjà expirés
    $ExpirEntretienStmt = $db->query("SELECT COUNT(*) as total FROM ENTRETIEN WHERE date_rappel < CURDATE()");
    $totalExpirEntretien = $ExpirEntretienStmt->fetch(PDO::FETCH_OBJ)->total;

} catch (PDOException $e) {
    echo '<div class="alert alert-danger" role="alert">Erreur lors de la récupération des entretiens: ' . htmlspecialchars($e->getMessage()) . '</div>';
    $entretiens_semaine = [];
    $entretiens_expire = [];
}

try {
    // Requête pour les assurances
    // Assurances expirant dans une semaine
    $sql_assurance_semaine = "SELECT * FROM ASSURANCE WHERE date_expiration BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)";
    $assurances_semaine = $db->query($sql_assurance_semaine);

    // Assurances déjà expirées
    $sql_assurance_expire = "SELECT * FROM ASSURANCE WHERE date_expiration < CURDATE()";
    $assurances_expire = $db->query($sql_assurance_expire);

    // Total des assurances expirant bientôt
    $PresqueAssuranceStmt = $db->query("SELECT COUNT(*) as total FROM ASSURANCE WHERE date_expiration BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)");
    $totalPresqueAssurance = $PresqueAssuranceStmt->fetch(PDO::FETCH_OBJ)->total;

    // Total des assurances déjà expirées
    $ExpirAssuranceStmt = $db->query("SELECT COUNT(*) as total FROM ASSURANCE WHERE date_expiration < CURDATE()");
    $totalExpirAssurance = $ExpirAssuranceStmt->fetch(PDO::FETCH_OBJ)->total;

} catch (PDOException $e) {
    echo '<div class="alert alert-danger" role="alert">Erreur lors de la récupération des assurances: ' . htmlspecialchars($e->getMessage()) . '</div>';
    $assurances_semaine = [];
    $assurances_expire = [];
}
?>

