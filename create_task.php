<?php
session_start();
require_once 'database_connection.php'; // Inclure la connexion à la base de données

// Vérifiez que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non authentifié']);
    exit();
}

// Récupération des données POST
$project_id = $_POST['project_id'] ?? null;
$name = $_POST['name'] ?? null;
$priority = $_POST['priority'] ?? 0;
$category = $_POST['category'] ?? null;
$effort = $_POST['effort'] ?? 0;
$budget = $_POST['budget'] ?? 0;

if (!$project_id || !$name) {
    echo json_encode(['success' => false, 'message' => 'Données incomplètes']);
    exit();
}

// Préparation de la requête d'insertion
$stmt = $db->prepare("INSERT INTO tache (projet_id, libelle, priorite, categorie, charge_restante_estimee, budget_restant_estime) VALUES (?, ?, ?, ?, ?, ?)");

if ($stmt->execute([$project_id, $name, $priority, $category, $effort, $budget])) {
    echo json_encode(['success' => true, 'message' => 'Tâche créée avec succès']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la création de la tâche']);
}
?>