<?php
require_once("cn.php");

if (isset($_GET['id_entretien'])) {
    $id_entretien = $_GET['id_entretien']; // Récupérer l'ID de l'entretien depuis l'URL

    // Requête SQL pour récupérer les informations de l'entretien
    $sql = "SELECT matricule, type_entretien, detaille, date_rappel, cout, etat FROM entretien WHERE ID_entretien = :id_entretien";
    $stmt = $db->prepare($sql);
    $stmt->execute(['id_entretien' => $id_entretien]);
    $entretien = $stmt->fetch(PDO::FETCH_OBJ); // Récupérer les données sous forme d'objet

    // Vérifier si l'entretien a été trouvé
    if ($entretien) {
        // L'entretien existe, vous pouvez maintenant utiliser $entretien->matricule, $entretien->type_entretien, etc.
    } else {
        echo "Entretien introuvable.";
    }
} else {
    echo "ID d'entretien non fourni.";
}

if (isset($_POST["enreg"])) {
    $matricule = $_POST["matricule"];
    $type_entretien = $_POST["type_entretien"];
    $detaille = $_POST["detaille"];
    $date_rappel = $_POST["date_rappel"];
    $cout = $_POST["cout"];
    $etat = $_POST["etat"];

    // Préparation de la requête d'insertion
    $insert = $db->prepare("INSERT INTO entretien(matricule, type_entretien, detaille, date_rappel, cout, etat) 
    VALUES (?, ?, ?, ?, ?, ?)");

    // Exécution de la requête avec les paramètres
    $result = $insert->execute([
        $matricule,
        $type_entretien,
        $detaille,
        $date_rappel,
        $cout,
        $etat
    ]);

    if ($result) {
        header("Location: gest_operation.php"); // Rediriger vers la page de gestion des entretiens
        exit();
    } else {
        echo "Erreur lors de l'enregistrement.";
    }
}

if (isset($_POST['modif'])) {
    // Récupérer l'ID de l'entretien
    $id_entretien = $_POST['id_entretien'];

    // Récupérer les autres informations du formulaire
    $matricule = $_POST['matricule'];
    $type_entretien = $_POST['type_entretien'];
    $detaille = $_POST['detaille'];
    $date_rappel = $_POST['date_rappel'];
    $cout = $_POST['cout'];
    $etat = $_POST['etat'];

    // Mettre à jour les informations dans la base de données
    $sql = "UPDATE entretien SET matricule = :matricule, type_entretien = :type_entretien, detaille = :detaille, date_rappel = :date_rappel, cout = :cout, etat = :etat WHERE id_entretien = :id_entretien";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        'matricule' => $matricule,
        'type_entretien' => $type_entretien,
        'detaille' => $detaille,
        'date_rappel' => $date_rappel,
        'cout' => $cout,
        'etat' => $etat,
        'id_entretien' => $id_entretien
    ]);

    // Rediriger ou afficher un message de succès
    header("Location: gest_operation.php?message=Modification réussie");
    exit();
}
?>
