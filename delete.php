<?php
include("cn.php");

if(isset($_GET["id_vehicule"])){
    $id_vehicule=$_GET["id_vehicule"];
    $delete=$db->prepare("DELETE FROM vehicules where ID_vehicule=:id_vehicule");
    $delete->execute(["id_vehicule"=>$id_vehicule]);

    if ($delete) {
       header("Location:gest_veh.php");
    }
}
elseif(isset($_GET["id_chauffeur"])){
    $id_chauf=$_GET["id_chauffeur"];
    $delete=$db->prepare("DELETE FROM chauffeur where ID_chauffeur=:id_chauffeur");
    $delete->execute(["id_chauffeur"=>$id_chauf]);

    if ($delete) {
       header("Location:gest_chauf.php");
    }
}
elseif (isset($_GET["id_fournisseur"])) {
    $id_fournisseur = $_GET["id_fournisseur"];
    $delete = $db->prepare("DELETE FROM fournisseur WHERE ID_fournisseur = :id_fournisseur");
    $delete->execute(["id_fournisseur" => $id_fournisseur]);

    if ($delete) {
        header("Location: gest_fournisseur.php");
        exit();
    }
}
elseif(isset($_GET["id_user"])){
    $id_user=$_GET["id_user"];
    $delete=$db->prepare("DELETE FROM user where idp=:id_user");
    $delete->execute(["id_user"=>$id_user]);

    if ($delete) {
       header("Location:gest_responsable.php");
    }
}
elseif (isset($_GET["id_entretien"])) {
    $id_entretien = $_GET["id_entretien"];
    $delete = $db->prepare("DELETE FROM entretien WHERE ID_entretien = :id_entretien");
    $delete->execute(["id_entretien" => $id_entretien]);

    if ($delete) {
        header("Location: gest_operation.php");
        exit(); // Ajouter exit() pour s'assurer que le script s'arrête après la redirection
    }
}
elseif (isset($_GET["id_assurance"])) {
    $id_assurance = $_GET["id_assurance"];
    $delete = $db->prepare("DELETE FROM ASSURANCE WHERE ID_assurance = :id_assurance");
    $delete->execute(["id_assurance" => $id_assurance]);

    if ($delete) {
        header("Location: gest_assurance.php");
        exit(); // Assurez-vous que le script s'arrête après la redirection
    }
}
// Traitement de la suppression d'une pièce
elseif (isset($_GET["id_piece"])) {
    $id_piece = $_GET["id_piece"];
    $delete = $db->prepare("DELETE FROM piece WHERE ID_piece = :id_piece");
    $delete->execute(["id_piece" => $id_piece]);

    if ($delete) {
        header("Location: gest_piece.php");
        exit();
    }
}

elseif (isset($_GET["id_mission"])) {
    $id_mission = $_GET["id_mission"];
    $delete = $db->prepare("DELETE FROM piece WHERE ID_mission = :id_mission");
    $delete->execute(["id_mission" => $id_mission]);

    if ($delete) {
        header("Location: gest_mission.php");
        exit();
    }
}