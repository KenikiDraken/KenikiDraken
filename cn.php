<?php
try {
    $db = new PDO("mysql:host=localhost;dbname=parcauto",'root','' );
} catch (EXCEPTION $e) {
    echo" erreur :".$e->getMessage();
}
?>