<?php
require_once("cn.php");

// Récupération des informations d'une assurance spécifique via l'ID
if (isset($_GET['ID_assurance'])) {
    $ID_assurance = $_GET['ID_assurance']; // Récupérer l'ID de l'assurance depuis l'URL

    // Requête SQL pour récupérer les informations de l'assurance
    $sql = "SELECT matricule, fournisseur, date_debut, date_expiration, prime FROM ASSURANCE WHERE ID_assurance = :ID_assurance";
    $stmt = $db->prepare($sql);
    $stmt->execute(['ID_assurance' => $ID_assurance]);
    $assurance = $stmt->fetch(PDO::FETCH_OBJ); // Récupérer les données sous forme d'objet

    // Vérifier si l'assurance a été trouvée
    if ($assurance) {
        // L'assurance existe, vous pouvez maintenant utiliser $assurance->matricule, $assurance->fournisseur, etc.
    } else {
        echo "Assurance introuvable.";
    }
} else {
    echo "ID d'assurance non fourni.";
}

// Enregistrement d'une nouvelle assurance
if (isset($_POST["enreg"])) {
    $matricule = $_POST["matricule"];
    $fournisseur = $_POST["fournisseur"];
    $date_debut = $_POST["date_debut"];
    $date_expiration = $_POST["date_expiration"];
    $prime = $_POST["prime"];

    // Préparation de la requête d'insertion
    $insert = $db->prepare("INSERT INTO ASSURANCE (matricule, fournisseur, date_debut, date_expiration, prime) 
                            VALUES (?, ?, ?, ?, ?)");

    // Exécution de la requête avec les paramètres
    $result = $insert->execute([
        $matricule,
        $fournisseur,
        $date_debut,
        $date_expiration,
        $prime
    ]);

    if ($result) {
        header("Location: gest_assurance.php"); // Rediriger vers la page de gestion des assurances
        exit();
    } else {
        echo "Erreur lors de l'enregistrement.";
    }
}

// Modification d'une assurance existante
if (isset($_POST['modif'])) {
    // Récupérer l'ID de l'assurance
    $ID_assurance = $_POST['ID_assurance'];

    // Récupérer les autres informations du formulaire
    $matricule = $_POST['matricule'];
    $fournisseur = $_POST['fournisseur'];
    $date_debut = $_POST['date_debut'];
    $date_expiration = $_POST['date_expiration'];
    $prime = $_POST['prime'];

    // Mettre à jour les informations dans la base de données
    $sql = "UPDATE ASSURANCE 
            SET matricule = :matricule, fournisseur = :fournisseur, date_debut = :date_debut, date_expiration = :date_expiration, prime = :prime 
            WHERE ID_assurance = :ID_assurance";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        'matricule' => $matricule,
        'fournisseur' => $fournisseur,
        'date_debut' => $date_debut,
        'date_expiration' => $date_expiration,
        'prime' => $prime,
        'ID_assurance' => $ID_assurance
    ]);

    // Rediriger ou afficher un message de succès
    header("Location: gest_assurance.php?message=Modification réussie");
    exit();
}
?>
