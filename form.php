<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Vérifiez si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';

    // Valider les données
    $errors = [];
    if (empty($name)) {
        $errors[] = "Le nom est requis.";
    }
    if (empty($email)) {
        $errors[] = "L'email est requis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'email n'est pas valide.";
    }
    if (empty($message)) {
        $errors[] = "Le message est requis.";
    }

    // Si aucune erreur, traiter les données
    if (empty($errors)) {
        // Configuration de l'email
        $to = 'kader.94vts@gmail.com'; // Adresse email à laquelle vous souhaitez envoyer les soumissions de formulaire
        $subject = 'Nouveau message de contact';
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        // Créer le contenu de l'email
        $email_content = "Nom : $name\n";
        $email_content .= "Email : $email\n";
        $email_content .= "Message :\n$message";

        // Envoyer l'email
        if (mail($to, $subject, $email_content, $headers)) {
            echo "Votre message a été envoyé avec succès.";
        } else {
            echo "Une erreur est survenue lors de l'envoi de votre message. Veuillez réessayer.";
        }
    } else {
        // Afficher les erreurs
        foreach ($errors as $error) {
            echo "$error\n";
        }
    }
} else {
    // Rediriger si l'accès n'est pas autorisé
    header('Location: index.html');
    exit;
}
?>