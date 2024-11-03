<?php
session_start();
header('Content-Type: application/json'); // Ajout du header JSON
require_once 'database_connection.php'; // Inclure la connexion à la base de données

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté.']);
    exit();
}

$userId = $_SESSION['user_id'];

// Prépare et exécute la requête pour récupérer les projets de l'utilisateur
try {
    $stmt = $db->prepare("SELECT id, nom FROM projet WHERE utilisateur_id = :user_id ORDER BY nom");
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'projects' => $projects]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la récupération des projets: ' . $e->getMessage()]);
}
?>
