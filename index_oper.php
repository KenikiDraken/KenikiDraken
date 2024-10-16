<?php

require_once('cn.php');

if (isset($_POST["valider"])) {
    $compte = $_POST["compte"];
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $fonction = $_POST["fonction"];
    $email = $_POST["email"];
    $adresse = $_POST["adresse"];
    $motpasse = $_POST["motpasse"];
    $date_naiss = $_POST["date_naiss"];
    $type_user = $_POST["type_user"];

    $insert = $db->prepare("INSERT INTO user (compte, nom, prenom, fonction, email, adresse, motpasse, date_naiss, type_user) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $result = $insert->execute([
        $compte,
        $nom,
        $prenom,
        $fonction,
        $email,
        $adresse,
        $motpasse,
        $date_naiss,
        $type_user
    ]);

    if ($result) {
        header("Location: index.php");
        exit();
    } else {
        echo "Erreur lors de l'enregistrement.";
    }
}
?>
