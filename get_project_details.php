<?php
session_start();
require_once 'database_connection.php';

if (!isset($_GET['project_id']) || !isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Projet ou utilisateur non valide.']);
    exit();
}

$projectId = $_GET['project_id'];
$userId = $_SESSION['user_id'];

try {
    $stmt = $db->prepare("SELECT * FROM projet WHERE id = :project_id AND utilisateur_id = :user_id");
    $stmt->bindParam(':project_id', $projectId, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $project = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($project) {
        echo json_encode(['success' => true, 'project' => $project]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Projet non trouvé.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la récupération du projet.']);
}
?>