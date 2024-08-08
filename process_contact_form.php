<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    // Vérification de base
    if (empty($nom) || empty($email) || empty($message)) {
        echo 'Veuillez remplir tous les champs obligatoires.';
        exit;
    }

    // Préparer le message
    $to = 'optiflow32@gmail.com';  // Remplacez par l'adresse e-mail de réception
    $subject = 'Nouveau message de contact';
    $body = "Nom: $nom\nEmail: $email\nMessage: $message\n";

    // En-têtes de l'email
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Envoyer l'email
    if (mail($to, $subject, $body, $headers)) {
        echo 'Votre message a été envoyé avec succès.';
    } else {
        echo 'Erreur lors de l\'envoi de votre message.';
    }
} else {
    echo 'Méthode de requête invalide.';
}
?>
