<?php
// Pour quitter la page accueil
session_start();

if($_GET['quitter']=='1'){
    unset($_SESSION['cmp']);
    session_destroy();
    header("location:first_authent.php?msg=2");
}
?>
