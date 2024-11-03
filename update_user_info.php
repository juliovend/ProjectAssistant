<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté']);
    exit();
}

include 'database_connection.php'; // Incluez votre connexion à la base de données

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
$updateQuery = "UPDATE utilisateur SET nom = ?, email = ?";
$params = [$userName, $userEmail];
if (!empty($userPassword)) {
    $updateQuery .= ", mot_de_passe = ?";
    $hashedPassword = password_hash($userPassword, PASSWORD_DEFAULT);
    $params[] = $hashedPassword;
}
$updateQuery .= " WHERE id = ?";
$params[] = $user_id;

$stmt = $pdo->prepare($updateQuery);
$success = $stmt->execute($params);

echo json_encode(['success' => $success]);
?>