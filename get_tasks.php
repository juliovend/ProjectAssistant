<?php
session_start();
require_once 'database_connection.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['project_id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur ou projet non valide']);
    exit();
}

$projectId = $_GET['project_id'];

try {
    $stmt = $db->prepare("SELECT * FROM tache WHERE projet_id = :project_id");
    $stmt->bindParam(':project_id', $projectId, PDO::PARAM_INT);
    $stmt->execute();
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'tasks' => $tasks]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la récupération des tâches.']);
}
?>
