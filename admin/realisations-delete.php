<?php
// on inclus le fichier qui s'occupe de toutes les inclusions
require("../config/includes.php");
// on protège la page par mot de passe
require("../config/adminRequired.php");

/**
 * Suppression d'une réalisation
 */
// SI on a bien le paramètre d'URL nommé 'id', et qu'il est bien de type nombre entier
if (isset($_GET["id"]) && ctype_digit($_GET["id"]) && $_GET['csrfToken'] === $_SESSION['csrfToken']) {
  //On supprime la réalisation de la base de données
  $query = $db->prepare("DELETE FROM realisations WHERE id = :id");
  $query->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
  $query->execute();
  // Ajouter un message Flash
  $flashMessage->add("La réalisation a été supprimée");
}

// Redirection vers la page des réalisations
header("Location: $baseUrl/admin/realisations.php");
exit();