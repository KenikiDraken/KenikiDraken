<?php 
 
require_once('cn.php');

if (isset($_GET['id_vehicule'])) {
    $id_vehicule = $_GET['id_vehicule']; // Récupérer l'ID du véhicule depuis l'URL

    // Requête SQL pour récupérer les informations du véhicule
    $sql = "SELECT matricule, marque, categorie, modele, mise_circulation, carburant, departement, etat, nom_chauffeur FROM vehicules WHERE ID_vehicule = :id_vehicule";
    $stmt = $db->prepare($sql);
    $stmt->execute(['id_vehicule' => $id_vehicule]);
    $vehicule = $stmt->fetch(PDO::FETCH_OBJ); // Récupérer les données sous forme d'objet

    // Vérifier si le véhicule a été trouvé
    if ($vehicule) {
        // Le véhicule existe, vous pouvez maintenant utiliser $vehicule->matricule, $vehicule->marque, etc.
    } else {
        echo "Véhicule introuvable.";
    }
} else {
    echo "ID de véhicule non fourni.";
}


if (isset($_POST["enreg"])) {
    $matricule = $_POST["matricule"];
    $marque = $_POST["marque"];
    $categorie = $_POST["categorie"];
    $modele = $_POST["modele"];
    $mise_circulation = $_POST["mise_circulation"];
    $carburant = $_POST["carburant"];
    $departement = $_POST["departement"];
    $etat = $_POST["etat"];
    $nom_chauffeur = $_POST["nom_chauffeur"];

    $insert = $db->prepare("INSERT INTO vehicules(matricule, marque, categorie, modele, mise_circulation, carburant, departement, etat, nom_chauffeur) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $result = $insert->execute([
        $matricule,
        $marque,
        $categorie,
        $modele,
        $mise_circulation,
        $carburant,
        $departement,
        $etat,
        $nom_chauffeur
    ]);

    if ($result) {
        header("Location: gest_veh.php");
        exit();
    } else {
        echo "Erreur lors de l'enregistrement.";
    }
}

elseif (isset($_POST['modif'])) {
    // Récupérer l'ID du véhicule
    $id_vehicule = $_POST['id_vehicule'];

    // Vérifier si l'ID est valide
    if (empty($id_vehicule)) {
        echo "Erreur : ID de véhicule non spécifié.";
        exit();
    }

    // Récupérer les autres informations du formulaire
    $matricule = $_POST['matricule'];
    $marque = $_POST['marque'];
    $modele = $_POST['modele'];
    $categorie = $_POST['categorie'];
    $mise_circulation = $_POST['mise_circulation'];
    $carburant = $_POST['carburant'];
    $departement = $_POST['departement'];
    $etat = $_POST['etat'];
    $nom_chauffeur = $_POST['nom_chauffeur'];

    // Mettre à jour les informations dans la base de données
    $sql = "UPDATE vehicules SET matricule = :matricule, marque = :marque, modele = :modele, categorie = :categorie, mise_circulation = :mise_circulation, carburant = :carburant, departement = :departement, etat = :etat, nom_chauffeur = :nom_chauffeur WHERE ID_vehicule = :id_vehicule";
    $stmt = $db->prepare($sql);

    // Debug: Afficher les données
    var_dump($_POST);

    if ($stmt->execute([
        'matricule' => $matricule,
        'marque' => $marque,
        'modele' => $modele,
        'categorie' => $categorie,
        'mise_circulation' => $mise_circulation,
        'carburant' => $carburant,
        'departement' => $departement,
        'etat' => $etat,
        'nom_chauffeur' => $nom_chauffeur,
        'id_vehicule' => $id_vehicule
    ])) {
        // Rediriger ou afficher un message de succès
        header("Location: gest_veh.php?message=Modification réussie");
        exit();
    } else {
        // Afficher un message d'erreur
        echo "Erreur lors de la mise à jour : " . implode(", ", $stmt->errorInfo());
    }
}


?>
