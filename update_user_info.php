<?php
session_start();
require_once 'database_connection.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté']);
    exit();
}

$user_id = $_SESSION['user_id'];
$userName = $_POST['userName'] ?? '';
$userEmail = $_POST['userEmail'] ?? '';
$userPassword = $_POST['userPassword'] ?? '';

// Vérifier et valider les champs
if (empty($userName) || empty($userEmail)) {
    echo json_encode(['success' => false, 'message' => 'Nom d\'utilisateur et email sont requis']);
    exit();
}

// Mettre à jour les informations dans la base de données
$updateQuery = "UPDATE utilisateur SET user_name = ?, user_email = ?";
$params = [$userName, $userEmail];
if (!empty($userPassword)) {
    $updateQuery .= ", user_password = ?";
    $hashedPassword = password_hash($userPassword, PASSWORD_DEFAULT);
    $params[] = $hashedPassword;
}
$updateQuery .= " WHERE user_id = ?";
$params[] = $user_id;

$stmt = $db->prepare($updateQuery);
$success = $stmt->execute($params);

echo json_encode(['success' => $success]);
?>