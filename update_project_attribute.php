<?php
session_start();
require_once 'database_connection.php';

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté.']);
    exit();
}

$projectId = filter_input(INPUT_POST, 'project_id', FILTER_SANITIZE_STRING);
$attribute = filter_input(INPUT_POST, 'attribute', FILTER_SANITIZE_STRING);
$value = filter_input(INPUT_POST, 'value', FILTER_SANITIZE_STRING);

if (empty($projectId)) {
    echo json_encode(['success' => false, 'message' => 'Projet_ID manquant.']);
    exit();
}
if (empty($attribute)) {
    echo json_encode(['success' => false, 'message' => 'Attribut manquant.']);
    exit();
}
if (empty($value)) {
    echo json_encode(['success' => false, 'message' => 'Valeur manquante.']);
    exit();
}

// Vérification pour sécuriser l'attribut (optionnel, selon votre base de données)
$allowedAttributes = ['nom', 'date_debut', 'date_fin', 'budget']; // Liste des colonnes autorisées
if (!in_array($attribute, $allowedAttributes)) {
    echo json_encode(['success' => false, 'message' => 'Attribut non valide.']);
    exit();
}

try {
    // Construction dynamique de la requête
    $stmt = $db->prepare("UPDATE projet SET $attribute = :value WHERE id = :id");
    $stmt->execute([
        ':value' => $value,
        ':id' => $projectId
    ]);
    echo json_encode(['success' => true, 'message' => 'Projet modifié avec succès.']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la modification du projet : ' . $e->getMessage()]);
    exit();
}
?>