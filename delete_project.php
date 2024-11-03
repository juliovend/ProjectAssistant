<?php
session_start();
require_once 'database_connection.php';

// Vérifiez que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non authentifié.']);
    exit();
}

// Vérifiez que l'ID du projet est fourni
$input = json_decode(file_get_contents('php://input'), true);
if (!isset($input['project_id'])) {
    echo json_encode(['success' => false, 'message' => 'ID du projet non fourni.']);
    exit();
}

$projectId = intval($input['project_id']);
$userId = $_SESSION['user_id'];


try {
    // Vérifier si le projet appartient à l'utilisateur
    $stmt = $db->prepare("SELECT id FROM projet WHERE id = :project_id AND utilisateur_id = :user_id");
    $stmt->execute([':project_id' => $projectId, ':user_id' => $userId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
        echo json_encode(['success' => false, 'message' => 'Projet introuvable ou non autorisé.']);
        exit();
    }

    // Commencer une transaction
    $db->beginTransaction();

    // Supprimer les tâches associées au projet
    $stmt = $db->prepare("DELETE FROM tache WHERE projet_id = :project_id");
    $stmt->execute([':project_id' => $projectId]);

    // Supprimer le projet
    $stmt = $db->prepare("DELETE FROM projet WHERE id = :project_id");
    $stmt->execute([':project_id' => $projectId]);

    // Valider la transaction
    $db->commit();

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    // Annuler la transaction en cas d'erreur
    if ($db->inTransaction()) {
        $db->rollBack();
    }
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la suppression du projet : ' . $e->getMessage()]);
    exit();
}
?>