<?php
session_start();
header('Content-Type: application/json');

require_once 'database_connection.php'; // Inclure la connexion à la base de données

$data = json_decode(file_get_contents("php://input"), true);
if (!$data) {
    echo json_encode(["success" => false, "message" => "Données JSON invalides"]);
    exit;
}
//test
$email = $data['email'];
$password = $data['password'];

// Modifier la requête SQL pour récupérer le nom complet
$stmt = $db->prepare("SELECT id, nom, mot_de_passe, email FROM utilisateur WHERE email = :email");
$stmt->execute([':email' => $email]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    if (password_verify($password, $result['mot_de_passe'])) {
        // Stockez l'ID et le nom de l'utilisateur dans la session
        $_SESSION['user_id'] = $result['id'];
        $_SESSION['user_name'] = $result['nom'];
        $_SESSION['user_email'] = $result['email'];
        echo json_encode(["success" => true, "message" => "Connexion réussie", "redirect" => "dashboard.php"]);
    } else {
        echo json_encode(["success" => false, "message" => "Mot de passe incorrect"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Email non trouvé"]);
}
?>

