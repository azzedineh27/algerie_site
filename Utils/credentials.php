<?php
$dsn = 'mysql:host=localhost;dbname=voiture';
$login = 'root';
$mdp = 'Ultime10';

try {
    $bd = new PDO($dsn, $login, $mdp);
    $bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
