<?php
session_start();
require_once 'database_connection.php';

// Activer le rapport d'erreurs (à désactiver en production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Vérifiez que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non authentifié.']);
    exit();
}

// Vérifiez que l'ID du projet et le nouveau nom sont fournis
$input = json_decode(file_get_contents('php://input'), true);
if (!isset($input['project_id']) || !isset($input['new_project_name'])) {
    echo json_encode(['success' => false, 'message' => 'Données incomplètes.']);
    exit();
}

$projectId = intval($input['project_id']);
$newProjectName = trim($input['new_project_name']);
$userId = $_SESSION['user_id'];

try {
    // Vérifier si le projet appartient à l'utilisateur
    $stmt = $db->prepare("SELECT * FROM projet WHERE id = :project_id AND utilisateur_id = :user_id");
    $stmt->execute([':project_id' => $projectId, ':user_id' => $userId]);
    $originalProject = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$originalProject) {
        echo json_encode(['success' => false, 'message' => 'Projet introuvable ou non autorisé.']);
        exit();
    }

    // Commencer une transaction
    $db->beginTransaction();

    // Dupliquer le projet
    $stmt = $db->prepare("INSERT INTO projet (nom, date_debut, date_fin, budget, utilisateur_id) VALUES (:nom, :date_debut, :date_fin, :budget, :user_id)");
    $stmt->execute([
        ':nom' => $newProjectName,
        ':date_debut' => $originalProject['date_debut'],
        ':date_fin' => $originalProject['date_fin'],
        ':budget' => $originalProject['budget'],
        ':user_id' => $userId
    ]);

    $newProjectId = $db->lastInsertId();

    // Dupliquer les tâches associées
    $stmt = $db->prepare("SELECT * FROM tache WHERE projet_id = :project_id");
    $stmt->execute([':project_id' => $projectId]);
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($tasks as $task) {
        $stmt = $db->prepare("INSERT INTO tache (projet_id, libelle, priorite, categorie, charge_consommee, charge_restante_estimee, budget_consomme, budget_restant_estime, commentaire) VALUES (:projet_id, :libelle, :priorite, :categorie, :charge_consommee, :charge_restante_estimee, :budget_consomme, :budget_restant_estime, :commentaire)");
        $stmt->execute([
            ':projet_id' => $newProjectId,
            ':libelle' => $task['libelle'],
            ':priorite' => $task['priorite'],
            ':categorie' => $task['categorie'],
            ':charge_consommee' => $task['charge_consommee'],
            ':charge_restante_estimee' => $task['charge_restante_estimee'],
            ':budget_consomme' => $task['budget_consomme'],
            ':budget_restant_estime' => $task['budget_restant_estime'],
            ':commentaire' => $task['commentaire']
        ]);
    }

    // Valider la transaction
    $db->commit();

    // Récupérer les détails du nouveau projet
    $stmt = $db->prepare("SELECT * FROM projet WHERE id = :project_id");
    $stmt->execute([':project_id' => $newProjectId]);
    $newProject = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'new_project' => $newProject]);

} catch (PDOException $e) {
    // Annuler la transaction en cas d'erreur
    if ($db->inTransaction()) {
        $db->rollBack();
    }
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la duplication du projet : ' . $e->getMessage()]);
    exit();
}
?>