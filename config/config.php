<?php 

// Définition des var de connexion

$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASSWORD = "";
$DB_NAME = "projetcv";


// Connexion à la base de donnée

try {
    $db = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8",$DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
    echo "echec de connexion : ". $e->getMessage();
  }
?>