<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $entrepriseName = isset($_POST['entrepriseName']) ? trim($_POST['entrepriseName']) : '';
    $personnelName = isset($_POST['personnelName']) ? trim($_POST['personnelName']) : '';
    $email = trim($_POST['email']);
    $description = trim($_POST['description']);
    $budget = isset($_POST['budget']) ? trim($_POST['budget']) : '';

    // Vérification de base
    if (empty($email) || empty($description)) {
        echo 'Veuillez remplir tous les champs obligatoires.';
        exit;
    }

    // Traitement des pièces jointes
    $attachmentPath = '';
    if (isset($_FILES['attachments']) && $_FILES['attachments']['error'] == 0) {
        $allowedExtensions = ['pdf', 'doc', 'docx', 'jpg', 'png'];
        $fileInfo = pathinfo($_FILES['attachments']['name']);
        $fileExtension = strtolower($fileInfo['extension']);

        if (in_array($fileExtension, $allowedExtensions)) {
            $uploadDir = 'uploads/';
            $attachmentPath = $uploadDir . basename($_FILES['attachments']['name']);
            
            if (!move_uploaded_file($_FILES['attachments']['tmp_name'], $attachmentPath)) {
                echo 'Erreur lors du téléchargement du fichier.';
                exit;
            }
        } else {
            echo 'Extension de fichier non autorisée.';
            exit;
        }
    }

    // Préparer le message
    $to = 'optiflow32@gmail.com';  // Remplacez par l'adresse e-mail de réception
    $subject = 'Nouvelle demande de devis';
    $message = "Email: $email\nDescription: $description\nBudget: $budget\n";

    if (!empty($entrepriseName)) {
        $message .= "Nom de l'entreprise: $entrepriseName\n";
    }

    if (!empty($personnelName)) {
        $message .= "Nom & Prénoms: $personnelName\n";
    }

    // Gestion des pièces jointes dans l'email (simplifié)
    if (!empty($attachmentPath)) {
        $message .= "Pièce jointe: $attachmentPath\n";
    }

    // Envoyer l'email
    if (mail($to, $subject, $message)) {
        echo 'Votre demande a été envoyée avec succès.';
    } else {
        echo 'Erreur lors de l\'envoi de votre demande.';
    }
} else {
    echo 'Méthode de requête invalide.';
}
?>
