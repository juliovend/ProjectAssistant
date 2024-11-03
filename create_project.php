<?php
session_start();
require_once 'database_connection.php'; // Inclure la connexion à la base de données

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté.']);
    exit();
}

$userId = $_SESSION['user_id'];

// Récupère et valide les données reçues
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$start_date = filter_input(INPUT_POST, 'start_date', FILTER_SANITIZE_STRING);
$end_date = filter_input(INPUT_POST, 'end_date', FILTER_SANITIZE_STRING);
$budget = filter_input(INPUT_POST, 'budget', FILTER_VALIDATE_FLOAT);

if (empty($name)) {
    echo json_encode(['success' => false, 'message' => 'Nom du projet manquant.']);
    exit();
}
if (empty($start_date)) {
    echo json_encode(['success' => false, 'message' => 'Date de début manquante.']);
    exit();
}
if (empty($end_date)) {
    echo json_encode(['success' => false, 'message' => 'Date de fin manquante.']);
    exit();
}
if ($budget === false) { // vérifie si le budget n'est pas un nombre valide
    echo json_encode(['success' => false, 'message' => 'Budget invalide.']);
    exit();
}

// Prépare l'insertion du projet dans la base de données
try {
    $stmt = $db->prepare("INSERT INTO projet (nom, date_debut, date_fin, budget, utilisateur_id) VALUES (:name, :start_date, :end_date, :budget, :user_id)");
    $stmt->execute([
        ':name' => $name,
        ':start_date' => $start_date,
        ':end_date' => $end_date,
        ':budget' => $budget,
        ':user_id' => $userId  
    ]);
    $project_id = $db->lastInsertId();
    echo json_encode(['success' => true, 'project_id' => $project_id, 'message' => 'Projet créé avec succès.']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la création du projet : ' . $e->getMessage()]);
    exit();
}

?>
