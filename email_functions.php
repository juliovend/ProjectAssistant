<?php
function sendVerificationEmail($email, $fullName, $verification_token) {
    $to = $email;
    $subject = "Validez votre inscription";
    $message = "Bonjour $fullName,\n\n";
    $message .= "Merci de vous être inscrit sur notre plateforme. Cliquez sur le lien suivant pour valider votre inscription :\n\n";
    $message .= "https://www.project-assistant.tech/verify.php?token=$verification_token\n\n";
    $message .= "Si vous n'avez pas créé de compte, veuillez ignorer cet email.";

    $headers = "From: no-reply@project-assistant.tech\r\n";
    return mail($to, $subject, $message, $headers);
}
?>