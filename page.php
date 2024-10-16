<?php
require_once('cn.php');

if(isset($_POST["vehicules"])){
    header('location: gest_veh.php');
}
elseif(isset($_POST["fournisseurs"])){
    header('location: gest_fournisseur.php');
}
elseif(isset($_POST["chauffeurs"])){
    header('location:gest_chauf.php');
}
elseif(isset($_POST["missions"])){
    header('location:gest_mission.php');
}
elseif(isset($_POST["responsables"])){
    header('location:gest_responsable.php');
}
elseif(isset($_POST["home"])){
    header('location: index.php');
}
elseif(isset($_POST["operations"])){
    header('location: gest_operation.php');
}
elseif(isset($_POST["assurances"])){
    header('location: gest_assurance.php');
}
elseif(isset($_POST["pieces"])){
    header('location: gest_piece.php');
}
elseif(isset($_POST["statistiques"])){
    header('location: gest_stat.php');
}
elseif(isset($_POST["alertes"])){
    header('location: gest_alerte.php');
}
else{
    header("location:index.php?msg=1");
}
?>