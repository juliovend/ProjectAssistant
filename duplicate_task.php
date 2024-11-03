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
    // Commencer une transaction
    $db->beginTransaction();

    // Récupérer la tâche originale
    $stmt = $db->prepare("SELECT * FROM tache WHERE id = :id");
    $stmt->execute(['id' => $task_id]);
    $originalTask = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$originalTask) {
        throw new Exception("Tâche non trouvée");
    }

    // Modifier les données pour la nouvelle tâche
    $newTaskData = $originalTask;
    unset($newTaskData['id']); // Retirer l'ID pour l'auto-incrémentation
    $newTaskData['libelle'] = $originalTask['libelle'] . ' (copie)';

    // Créer une liste des colonnes et des valeurs
    $columns = array_keys($newTaskData);
    $placeholders = array_map(function($col) { return ':' . $col; }, $columns);

    // Préparer les données pour l'insertion
    $insertData = [];
    foreach ($columns as $column) {
        $insertData[':' . $column] = $newTaskData[$column];
    }

    // Insérer la nouvelle tâche
    $sql = "INSERT INTO tache (" . implode(',', $columns) . ") VALUES (" . implode(',', $placeholders) . ")";
    $stmt = $db->prepare($sql);
    $stmt->execute($insertData);

    // Récupérer l'ID de la nouvelle tâche
    $newTaskId = $db->lastInsertId();

    // Valider la transaction
    $db->commit();

    // Récupérer les données complètes de la nouvelle tâche
    $stmt = $db->prepare("SELECT * FROM tache WHERE id = :id");
    $stmt->execute(['id' => $newTaskId]);
    $newTask = $stmt->fetch(PDO::FETCH_ASSOC);

    // Renvoyer les données de la nouvelle tâche
    echo json_encode(['success' => true, 'task' => $newTask]);

} catch (Exception $e) {
    // Annuler la transaction en cas d'erreur
    $db->rollBack();
    error_log("Erreur lors de la duplication de la tâche : " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la duplication de la tâche']);
}
?>