<?php
header("Content-Type: application/json");

require_once 'database_connection.php'; // Inclure la connexion à la base de données

// Récupérer et décoder les données JSON
$data = json_decode(file_get_contents("php://input"), true);
if (!$data) {
    echo json_encode(["success" => false, "message" => "Données JSON invalides"]);
    exit;
}

$fullName = $data['fullName'];
$email = $data['email'];
$password = $data['password'];

// Vérifier si l'email existe déjà
$stmt = $db->prepare("SELECT id FROM utilisateur WHERE email = :email");
$stmt->execute([':email' => $email]);
$result = $stmt->fetch();

if ($result) {
    echo json_encode(["success" => false, "message" => "Cet email est déjà utilisé"]);
    exit;
}

// Hacher le mot de passe
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insérer les nouvelles données d'utilisateur
try {
    $stmt = $db->prepare("INSERT INTO utilisateur (nom, email, mot_de_passe) VALUES (:name, :email, :password)");
    $stmt->execute([
        ':name' => $fullName,
        ':email' => $email,
        ':password' => $hashedPassword
    ]);

    echo json_encode(['success' => true, 'message' => 'Compte créé avec succès.']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la création du compte : ' . $e->getMessage()]);
    exit();
}
?>
