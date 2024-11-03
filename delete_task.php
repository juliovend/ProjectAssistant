<?php
session_start();
require_once 'database_connection.php';

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté']);
    exit();
}

// Récupérer les données POST
$input = json_decode(file_get_contents('php://input'), true);
$task_id = $input['task_id'] ?? null;

if (!$task_id) {
    echo json_encode(['success' => false, 'message' => 'ID de tâche manquant']);
    exit();
}

try {
    // Préparer la requête de suppression
    $stmt = $db->prepare("DELETE FROM tache WHERE id = :id");
    $stmt->execute(['id' => $task_id]);

    // Vérifier si une tâche a été supprimée
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Tâche non trouvée ou déjà supprimée']);
    }
} catch (Exception $e) {
    error_log("Erreur lors de la suppression de la tâche : " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la suppression de la tâche']);
}
?>