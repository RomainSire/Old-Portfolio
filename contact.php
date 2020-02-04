<?php
// on inclus le fichier qui s'occupe de toutes les inclusions
require("config/includes.php");


if (isset($_POST) && isset($_POST['csrfToken']) && $_POST['csrfToken'] === $_SESSION['csrfToken']) {
    // Enregistrer le message en base de données
    $query = $db->prepare("INSERT INTO messages (name, email, content) VALUES (:name, :email, :content)");
    $query->bindParam(':name', $_POST['name']);
    $query->bindParam(':email', $_POST['email']);
    $query->bindParam(':content', $_POST['content']);
    $query->execute();    

    // envoi de l'email

    $to      = 'romain.sire@gmx.com';
    $subject = 'Portfolio - nouveau message de ' . htmlspecialchars($_POST['name']);
    $message = utf8_decode('Un message a été envoyé!

    Envoyé par : ' . htmlspecialchars($_POST['name']) . '
    Email renseigné : ' . htmlspecialchars($_POST['email']) . '

    Message :
    ' . nl2br(htmlspecialchars($_POST['content'])));

    $headers[] = 'From: contact@romainsire.com';

    // Envoi du mail
    $success = mail($to, $subject, $message, implode("\r\n", $headers));


    if ($success) {
        $flashMessage->add("Le message a bien été envoyé");
    } else {
        $flashMessage->add("PROBLEME D'ENVOI ! Le message n'a pas été envoyé");
    }
}

// on définit le contenu de la page qui sera appelé, et on inclut la vue
$pageTitle = "Contact";  // titre de la page
$template = 'contact.phtml'; // vue appelée (rangée dans le dossier "vues")
include("layout.phtml"); // layout appelé