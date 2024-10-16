<?php
require_once("cn.php");

if (isset($_POST['id_mission'])) {
    $_SESSION['id_mission'] = $_POST['id_mission'];
    echo "ID de mission stocké dans la session.";
} else {
    echo "ID de mission non fourni.";
}
if (isset($_SESSION['id_mission'])) {
    $id_mission = $_SESSION['id_mission'];
    
        // Récupérer les autres informations du formulaire
        $nom_chauffeur = $_POST['nom_chauffeur'];
        $matricule = $_POST['matricule'];
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
        $cout_carburant = $_POST['cout_carburant'];
        $lieu_mission = $_POST['lieu_mission'];
        $statut = $_POST['statut'];
    
        // Mettre à jour les informations dans la base de données
        $sql = "UPDATE mission SET nom_chauffeur = :nom_chauffeur, matricule = :matricule, date_debut = :date_debut, date_fin = :date_fin, cout_carburant = :cout_carburant, lieu_mission = :lieu_mission, statut = :statut WHERE id_mission = :id_mission";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            'nom_chauffeur' => $nom_chauffeur,
            'matricule' => $matricule,
            'date_debut' => $date_debut,
            'date_fin' => $date_fin,
            'cout_carburant' => $cout_carburant,
            'lieu_mission' => $lieu_mission,
            'statut' => $statut,
            'id_mission' => $id_mission
        ]);
    
        // Rediriger ou afficher un message de succès
        header("Location: gest_mission.php?message=Modification réussie");
        exit();

    // Une fois la modification terminée, vous pouvez libérer la session si nécessaire
    unset($_SESSION['id_mission']);
} else {
    echo "ID de mission non fourni.";
}

// Traitement de l'enregistrement d'une nouvelle mission
if (isset($_POST["enreg"])) {
    $nom_chauffeur = $_POST["nom_chauffeur"];
    $matricule = $_POST["matricule"];
    $date_debut = $_POST["date_debut"];
    $date_fin = $_POST["date_fin"];
    $cout_carburant = $_POST["cout_carburant"];
    $lieu_mission = $_POST["lieu_mission"];
    $statut = $_POST["statut"];

    // Préparation de la requête d'insertion
    $insert = $db->prepare("INSERT INTO mission(nom_chauffeur, matricule, date_debut, date_fin, cout_carburant, lieu_mission, statut) 
    VALUES (?, ?, ?, ?, ?, ?, ?)");

    // Exécution de la requête avec les paramètres
    $result = $insert->execute([
        $nom_chauffeur,
        $matricule,
        $date_debut,
        $date_fin,
        $cout_carburant,
        $lieu_mission,
        $statut
    ]);

    if ($result) {
        header("Location: gest_mission.php"); // Rediriger vers la page de gestion des missions
        exit();
    } else {
        echo "Erreur lors de l'enregistrement.";
    }
}

?>
