<?php
// Paramètres de connexion
$host = "localhost";
$dbname = "u915171535_ProAss";
$username = "u915171535_ProAss_user";
$password = "4_Euryale";

try {
    // Crée une nouvelle instance PDO
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    
    // Configure PDO pour lancer des exceptions en cas d'erreurs
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Si la connexion échoue, afficher un message d'erreur
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>