<?php
session_start();
require_once 'database_connection.php';

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté.']);
    exit();
}

$taskId = filter_input(INPUT_POST, 'task_id', FILTER_SANITIZE_STRING);
$attribute = filter_input(INPUT_POST, 'attribute', FILTER_SANITIZE_STRING);
$value = filter_input(INPUT_POST, 'value', FILTER_SANITIZE_STRING);

if (empty($taskId)) {
    echo json_encode(['success' => false, 'message' => 'Task Id manquant.']);
    exit();
}
if (empty($attribute)) {
    echo json_encode(['success' => false, 'message' => 'Attribut manquant.']);
    exit();
}
if (!isset($value)) {
    echo json_encode(['success' => false, 'message' => 'Valeur manquante.']);
    exit();
}

// Vérification pour sécuriser l'attribut (optionnel, selon votre base de données)
$allowedAttributes = ['libelle', 'priorite', 'categorie', 'charge_consommee', 'charge_restante_estimee', 'charge_totale_estimee', 'budget_consomme', 'budget_restant_estime', 'budget_total_estime', 'commentaire', 'IsCompleted']; // Liste des colonnes autorisées
if (!in_array($attribute, $allowedAttributes)) {
    echo json_encode(['success' => false, 'message' => 'Attribut non valide.']);
    exit();
}

try {
    // Si l'attribut est 'IsCompleted', convertir $value en booléen
    if ($attribute === 'IsCompleted') {
        $value = $value === 'true' ? 1 : 0; // Conversion en entier pour MySQL (1 ou 0)
    }

    // Construction dynamique de la requête
    $stmt = $db->prepare("UPDATE tache SET $attribute = :value WHERE id = :id");
    $stmt->execute([
        ':value' => $value,
        ':id' => $taskId
    ]);
    echo json_encode(['success' => true, 'message' => 'Tache modifiée avec succès.']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la modification de la tache : ' . $e->getMessage()]);
    exit();
}
?>