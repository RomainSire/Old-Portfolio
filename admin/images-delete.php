<?php
// on inclus le fichier qui s'occupe de toutes les inclusions
require("../config/includes.php");
// on protège la page par mot de passe
require("../config/adminRequired.php");

/**
 * Suppression d'une image
 */
// SI on a bien le paramètre d'URL nommé 'id', et qu'il est bien de type nombre entier
if (isset($_GET["id"]) && ctype_digit($_GET["id"]) && $_GET['csrfToken'] === $_SESSION['csrfToken']) {
  // 1 - On suprime l'image du dossier
  // On récupère le nom de fichier associé à l'ID
  $query = $db->prepare("SELECT filename FROM images WHERE id = :id");
  $query->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
  $query->execute();
  $filename = $query->fetch();  // nom de l'image
  $imagePath = $baseFolder . "/img/portfolio/" . $filename['filename'];  // chemin de l'image
  unlink($imagePath); // supression de l'image

  // 2 - On supprime l'image de la base de données
  $query = $db->prepare("DELETE FROM images WHERE id = :id");
  $query->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
  $query->execute();

  // 3 - Ajouter un message Flash
  $flashMessage->add("L'image a été supprimée");
}

// Redirection vers la page des images
header("Location: $baseUrl/admin/images.php");
exit();