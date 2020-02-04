<?php
// on inclus le fichier qui s'occupe de toutes les inclusions
require("../config/includes.php");
// on protège la page par mot de passe
require("../config/adminRequired.php");

/**
 * Suppression d'une catégorie
 */
// SI on a bien le paramètre d'URL nommé 'id', et qu'il est bien de type nombre entier
if (isset($_GET["id"]) && ctype_digit($_GET["id"])  && $_GET['csrfToken'] === $_SESSION['csrfToken']) {
  //On supprime la catégorie de la base de données
  $query = $db->prepare("DELETE FROM categories WHERE id = :id");
  $query->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
  $query->execute();
  // Ajouter un message Flash
  $flashMessage->add("La catégorie a été supprimée");
}

// Redirection vers la page des catégories
header("Location: $baseUrl/admin/categories.php");
exit();