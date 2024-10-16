<?php 
require_once('cn.php');

 session_start();

 extract($_POST);

 if($_POST['acces']=='1')
 {  
    $v=$db->prepare("SELECT compte,motpass FROM administrateur where compte=? and motpass=?");
    $v->execute([$compte,$motpass]);
    $tabv=$v->fetch();
    if($tabv['compte']==$compte && $tabv['motpass']==$motpass)
    {
        $_SESSION['cmp']=$compte;
        header("location:index.php");
    }
    else
    {
        header("location:first_authent.php?msg=1");   
    }
 }

?>