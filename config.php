<?php

$PARAM_hote='localhost'; // le chemin vers le serveur
$PARAM_port='8080';
$PARAM_nom_bd='belle'; // le nom de votre base de données
$PARAM_utilisateur='root'; // nom d'utilisateur pour se connecter
$PARAM_mot_passe=''; // mot de passe de l'utilisateur pour se connecter

$con = mysql_connect($PARAM_hote,$PARAM_utilisateur,$PARAM_mot_passe) or die(mysql_error());

if (!$con) {
    echo "Unable to connect to DB: " . mysql_error();
    exit;
}

if (!mysql_select_db($PARAM_nom_bd)) {
    echo "Unable to select mydbname: " . mysql_error();
    exit;
}
?>
