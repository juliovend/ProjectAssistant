<?php
// Connexion à la base de données
include 'database_connection.php';

// Vérification de la présence du token dans l'URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Rechercher l'utilisateur correspondant au token
    $query = "SELECT * FROM utilisateur WHERE verification_token = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user) {
        // Si un utilisateur est trouvé, mettez à jour le champ email_verified
        $updateQuery = "UPDATE utilisateur SET email_verified = 1, verification_token = NULL WHERE id = ?";
        $stmt = $db->prepare($updateQuery);
        $stmt->execute([$user['id']]);

        echo "<p>Votre email a été vérifié avec succès ! Vous pouvez maintenant <a href='index.php'>vous connecter</a>.</p>";
    } else {
        echo "<p>Lien de validation invalide ou expiré.</p>";
    }
} else {
    echo "<p>Token de validation manquant.</p>";
}
?>