<?php
session_start();
require_once 'database_connection.php'; // Assurez-vous que ce fichier contient la connexion à la base de données

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non authentifié']);
    exit();
}

$userId = $_SESSION['user_id'];


// Prépare et exécute la requête pour récupérer les projets de l'utilisateur
try {
    $stmt = $db->prepare("SELECT t.projet_id
    FROM tache t
    JOIN projet p ON t.projet_id = p.id
    WHERE p.utilisateur_id = :user_id
    ORDER BY t.date_derniere_modification DESC
    LIMIT 1");
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $project = $stmt->fetch(PDO::FETCH_ASSOC);

     echo json_encode(['success' => true, 'project_id' => $project['projet_id']]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Aucune tâche trouvée' . $e->getMessage()]);
}
?>